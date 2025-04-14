<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Penjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('is_login')) {
            redirect('Login');
        }
    }

    public function index()
    {
        $data['title'] = 'Invoice';
        $tgl =  date('Y-m-d');
        $data['invoice'] =  $this->db->query("SELECT * FROM t_invoice WHERE tgl_jual = '$tgl'")->result();
        $this->template->load('template/template', 'penjualan/invoice', $data);
    }

    public function searchCustomer()
    {
        if (empty($_REQUEST['term']))
            exit;

        $getCustomer = $this->db->query("SELECT id_customer, nama_customer FROM t_customer WHERE (nama_customer LIKE '%" . $_REQUEST['term'] . "%') ORDER BY nama_customer ASC LIMIT 0,10")->result_array();
        $data = array();
        foreach ($getCustomer as $r) {
            $data[] = array(
                "label" => $r['nama_customer'], // Untuk ditampilkan di dropdown
                "value" => $r['nama_customer'],   // Untuk diisi di input
                "id_customer" => $r['id_customer']
            );
        }
        echo json_encode($data);
    }

    public function searchBarang()
    {
        if (empty($_REQUEST['term']))
            exit;

        $getBarang = $this->db->query("SELECT * FROM t_stok WHERE (kode_barang LIKE '%" . $_REQUEST['term'] . "%') ORDER BY kode_barang ASC LIMIT 0,10")->result_array();
        $data = array();
        foreach ($getBarang as $r) {
            $data[] = array(
                "label" => $r['kode_barang'] . ' - ' . $r['nama_barang'] . ' - ' . $r['stok'],
                "value" => $r['kode_barang'],
                "id_barang" => $r['id'],
                "nama_barang" => $r['nama_barang'],
                "stok" => $r['stok'],
                "satuan" => $r['satuan'],
                "harga_jual" =>  intval($r['harga_jual']),
                "harga_permeter" =>  intval($r['harga_permeter'])
            );
        }
        echo json_encode($data);
    }

    public function filterData()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $metode_pembayaran = $this->input->post('metode_pembayaran');
        $status_pembayaran = $this->input->post('status_pembayaran');
        $customer = $this->input->post('customer');
        $jenis_invoice = $this->input->post('jenis_invoice');

        if ($metode_pembayaran == '*') {
            $mp = "";
        } else if ($metode_pembayaran == 'tunai') {
            $mp = "AND metode_pembayaran = 'tunai' OR nominal_tunai != '0.00'";
        } else if ($metode_pembayaran == 'nontunai') {
            $mp = "AND metode_pembayaran = 'nontunai' OR nominal_nontunai != '0.00'";
        } else if ($metode_pembayaran == 'split') {
            $mp = "AND metode_pembayaran = 'split'";
        }

        if ($status_pembayaran == '*') {
            $sp = "";
        } else {
            $sp = "AND status_pembayaran = '$status_pembayaran'";
        }


        if ($jenis_invoice == '*') {
            $jp = "";
        } else {
            $jp = "AND jenis_invoice = '$jenis_invoice'";
        }

        if ($customer == '*') {
            $cus = "";
        } else {
            $cus = "AND id_customer = '$customer'";
        }

        $data['title'] = 'Invoice';
        $data['invoice'] = $this->db->query("SELECT * FROM t_invoice WHERE tgl_jual BETWEEN '$tgl_awal' AND '$tgl_akhir' $mp $sp $jp $cus")->result();
        $this->template->load('template/template', 'penjualan/invoice', $data);
    }

    public function addView()
    {
        $data['title'] = 'Invoice';
        $this->template->load('template/template', 'penjualan/invoice_add', $data);
    }

    public function validasiStok()
    {
        $id = $this->input->post('id');
        $getStok = $this->db->query("SELECT stok FROM t_stok WHERE id ='$id'")->row()->stok;

        if ($getStok <= "0") {
            $st = 0;
        } else {
            $st = 1;
        }
        echo json_decode($st);
    }

    public function addData()
    {
        $this->form_validation->set_rules('id_customer', 'Customer', 'required');
        $this->form_validation->set_rules('term', 'Term', 'required');
        if ($this->form_validation->run() != FALSE) {
            $maxDetailInput = $this->db->query("SELECT max_detail_input FROM t_pengaturan")->row()->max_detail_input;

            $id_customer = $this->input->post('id_customer');
            $tgl_jual = $this->input->post('tgl_jual');
            $jatuh_tempo = $this->input->post('jatuh_tempo');
            $spg = $this->input->post('spg');
            $term = $this->input->post('term');
            $nominal_tunai = str_replace(',', '.', str_replace('.', '', $this->input->post('nominal_tunai')));
            $nominal_nontunai = str_replace(',', '.', str_replace('.', '', $this->input->post('nominal_nontunai')));

            $subtotal = str_replace(',', '.', str_replace('.', '', $this->input->post('subtotal')));
            $ongkir = str_replace(',', '.', str_replace('.', '', $this->input->post('ongkir')));
            $total = str_replace(',', '.', str_replace('.', '', $this->input->post('total')));

            $status_pembayaran = $this->input->post('status_pembayaran');
            if ($status_pembayaran == 'lunas') {
                $hutang = '0';
            } else {
                $hutang = $total;
            }

            $metode_pembayaran = $this->input->post('metode_pembayaran');
            if ($metode_pembayaran == 'tunai') {
                $id_rekening = '0';
            } else if ($metode_pembayaran == 'split') {
                $totalNominal = $nominal_tunai + $nominal_nontunai;
                if ($totalNominal != $total) {
                    $this->session->set_flashdata('message', 'nominalError');
                    redirect('penjualan');
                } else {
                    $id_rekening = $this->input->post('id_rekening');
                }
            } else {
                $id_rekening = $this->input->post('id_rekening');
            }

            $no_invoice = $this->generateNoInvoice();

            $dataHead = [
                'no_invoice' => $no_invoice,
                'id_customer' => $id_customer,
                'tgl_jual' => $tgl_jual,
                'jatuh_tempo' => $jatuh_tempo,
                'term' => $term,
                'spg' => $spg,
                'jenis_invoice' => '0',
                'status_pembayaran' => $status_pembayaran,
                'hutang' => $hutang,
                'metode_pembayaran' => $metode_pembayaran,
                'nominal_tunai' => $nominal_tunai,
                'nominal_nontunai' => $nominal_nontunai,
                'id_rekening' => $id_rekening,
                'subtotal' => $subtotal,
                'ongkir' => $ongkir,
                'total' => $total
            ];
            $this->db->insert('t_invoice', $dataHead);
            $id_invoice = $this->db->insert_id();
            if ($id_invoice) {
                for ($d = 1; $d <= $maxDetailInput; $d++) {
                    if (!empty($_REQUEST['nama_barang3' . $d])) {
                        $id_barang = $_REQUEST['id_barang1' . $d];
                        $nama_barang = $_REQUEST['nama_barang3' . $d];
                        $stok = $_REQUEST['stok4' . $d];
                        $satuan = $_REQUEST['satuan5' . $d];
                        $harga_jual = str_replace(',', '.', str_replace('.', '', $_REQUEST['harga_jual6' . $d]));
                        $harga_after_diskon = str_replace(',', '.', str_replace('.', '', $_REQUEST['harga_after_diskon' . $d]));
                        $diskon_persen = $_REQUEST['diskon_persen7' . $d];
                        $diskon_nominal = str_replace(',', '.', str_replace('.', '', $_REQUEST['diskon_nominal8' . $d]));
                        $jumlah = str_replace(',', '.', str_replace('.', '', $_REQUEST['jumlah9' . $d]));

                        $dataDetail = [
                            'id_invoice' => $id_invoice,
                            'no_invoice' => $no_invoice,
                            'id_barang' => $id_barang,
                            'nama_barang' => $nama_barang,
                            'harga_jual' => $harga_jual,
                            'harga_after_diskon' => $harga_after_diskon,
                            'stok' => $stok,
                            'satuan' => $satuan,
                            'diskon_persen' => $diskon_persen,
                            'diskon_nominal' => $diskon_nominal,
                            'jumlah' => $jumlah
                        ];
                        $this->db->insert('t_invoice_detail', $dataDetail);

                        //update stok barang (-)
                        $getStok = $this->db->query("SELECT stok FROM t_stok WHERE id = '$id_barang'")->row()->stok;
                        $jmlStok = $getStok - $stok;
                        $this->db->query("UPDATE t_stok SET stok = '$jmlStok' WHERE id = '$id_barang'");
                    }
                }

                //insert ke t_logs
                $dataLogs = [
                    'username' => $this->session->userdata('username'),
                    'tanggal' => date("Y-m-d H-i-s"),
                    'keterangan' => 'Transaksi invoice dengan no invoice ' . $no_invoice
                ];
                $this->db->insert('t_logs', $dataLogs);

                $this->session->set_flashdata('message', 'berhasil tambah');
                redirect('penjualan');
            }
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('penjualan/addView');
        }
    }

    public function detailData($id)
    {
        $jenisInv = $this->db->query("SELECT jenis_invoice FROM t_invoice WHERE id_invoice='$id'")->row()->jenis_invoice;
        if ($jenisInv == '0') {
            $data['title'] = 'Detail Invoice';
        } else {
            $data['title'] = 'Detail Invoice Kaca';
        }

        $data['data'] = $this->db->query("SELECT * FROM t_invoice WHERE id_invoice='$id'")->row();
        $data['detail'] = $this->db->query("SELECT * FROM t_invoice_detail WHERE id_invoice='$id'")->result();
        $data['detailkaca'] = $this->db->query("SELECT * FROM t_invoice_detail_kaca WHERE id_invoice='$id'")->result();
        $this->template->load('template/template', 'penjualan/inv_detail', $data);
    }

    public function editView($id)
    {
        $data['title'] = 'Invoice';
        $data['data'] = $this->db->query("SELECT * FROM t_invoice WHERE id_invoice='$id'")->row();
        $data['detail'] = $this->db->query("SELECT * FROM t_invoice_detail WHERE id_invoice='$id'")->result();
        $this->template->load('template/template', 'penjualan/invoice_edit', $data);
    }

    public function editData($id)
    {

        $maxDetailInput = $this->db->query("SELECT max_detail_input FROM t_pengaturan")->row()->max_detail_input;

        $id_customer = $this->input->post('id_customer');
        $tgl_jual = $this->input->post('tgl_jual');
        $jatuh_tempo = $this->input->post('jatuh_tempo');
        $spg = $this->input->post('spg');
        $term = $this->input->post('term');
        $nominal_tunai = str_replace(',', '.', str_replace('.', '', $this->input->post('nominal_tunai')));
        $nominal_nontunai = str_replace(',', '.', str_replace('.', '', $this->input->post('nominal_nontunai')));

        $subtotal = str_replace(',', '.', str_replace('.', '', $this->input->post('subtotal')));
        $ongkir = str_replace(',', '.', str_replace('.', '', $this->input->post('ongkir')));
        $total = str_replace(',', '.', str_replace('.', '', $this->input->post('total')));

        $status_pembayaran = $this->input->post('status_pembayaran');
        if ($status_pembayaran == 'lunas') {
            $hutang = '0';
        } else {
            $hutang = $total;
        }

        $metode_pembayaran = $this->input->post('metode_pembayaran');
        if ($metode_pembayaran == 'tunai') {
            $id_rekening = '0';
        } else if ($metode_pembayaran == 'split') {
            $totalNominal = $nominal_tunai + $nominal_nontunai;
            if ($totalNominal != $total) {
                $this->session->set_flashdata('message', 'nominalError');
                redirect('penjualan');
            } else {
                $id_rekening = $this->input->post('id_rekening');
            }
        } else {
            $id_rekening = $this->input->post('id_rekening');
        }

        $no_invoice = $this->db->query("SELECT no_invoice FROM t_invoice WHERE id_invoice='$id'")->row()->no_invoice;

        $dataHead = [
            'no_invoice' => $no_invoice,
            'id_customer' => $id_customer,
            'tgl_jual' => $tgl_jual,
            'jatuh_tempo' => $jatuh_tempo,
            'term' => $term,
            'spg' => $spg,
            'jenis_invoice' => '0',
            'status_pembayaran' => $status_pembayaran,
            'hutang' => $hutang,
            'metode_pembayaran' => $metode_pembayaran,
            'nominal_tunai' => $nominal_tunai,
            'nominal_nontunai' => $nominal_nontunai,
            'id_rekening' => $id_rekening,
            'subtotal' => $subtotal,
            'ongkir' => $ongkir,
            'total' => $total
        ];
        $this->db->where('id_invoice', $id);
        $this->db->update('t_invoice', $dataHead);

        //balikin stok sebelumnya
        $id_barang = $this->db->query("SELECT * FROM t_invoice_detail WHERE id_invoice='$id'")->result();
        foreach ($id_barang as $ib) {
            $this->db->query("UPDATE t_stok SET stok = stok + " . $ib->stok . " WHERE id = '$ib->id_barang'");
        }

        //hapus detail pembelian
        $this->db->where('id_invoice', $id);
        $this->db->delete('t_invoice_detail');

        //insert ulang detail pembelian
        for ($d = 1; $d <= $maxDetailInput; $d++) {
            if (!empty($_REQUEST['nama_barang3' . $d])) {
                $id_barang = $_REQUEST['id_barang1' . $d];
                $nama_barang = $_REQUEST['nama_barang3' . $d];
                $stok = $_REQUEST['stok4' . $d];
                $satuan = $_REQUEST['satuan5' . $d];
                $harga_jual = str_replace(',', '.', str_replace('.', '', $_REQUEST['harga_jual6' . $d]));
                $harga_after_diskon = str_replace(',', '.', str_replace('.', '', $_REQUEST['harga_after_diskon' . $d]));
                $diskon_persen = $_REQUEST['diskon_persen7' . $d];
                $diskon_nominal = str_replace(',', '.', str_replace('.', '', $_REQUEST['diskon_nominal8' . $d]));
                $jumlah = str_replace(',', '.', str_replace('.', '', $_REQUEST['jumlah9' . $d]));

                $dataDetail = [
                    'id_invoice' => $id,
                    'no_invoice' => $no_invoice,
                    'id_barang' => $id_barang,
                    'nama_barang' => $nama_barang,
                    'harga_jual' => $harga_jual,
                    'harga_after_diskon' => $harga_after_diskon,
                    'stok' => $stok,
                    'satuan' => $satuan,
                    'diskon_persen' => $diskon_persen,
                    'diskon_nominal' => $diskon_nominal,
                    'jumlah' => $jumlah
                ];
                $this->db->insert('t_invoice_detail', $dataDetail);

                //update stok barang (+)
                $getStok = $this->db->query("SELECT stok FROM t_stok WHERE id = '$id_barang'")->row()->stok;
                $stokAkhir = $getStok - $stok;
                $this->db->query("UPDATE t_stok SET stok = '$stokAkhir' WHERE id = '$id_barang'");
            }
        }

        //insert ke t_logs
        $dataLogs = [
            'username' => $this->session->userdata('username'),
            'tanggal' => date("Y-m-d H-i-s"),
            'keterangan' => 'Melakukan update transaksi invoice dengan no invoice ' . $no_invoice
        ];
        $this->db->insert('t_logs', $dataLogs);

        $this->session->set_flashdata('message', 'berhasil ubah');
        redirect('penjualan');
    }

    public function hapusData()
    {
        $id = $this->input->post('id');
        $jenis_inv = $this->db->query("SELECT jenis_invoice FROM t_invoice WHERE id_invoice ='$id'")->row()->jenis_invoice;
        $no_invoice = $this->db->query("SELECT no_invoice FROM t_invoice WHERE id_invoice ='$id'")->row()->no_invoice;
        $deleteData = $this->db->delete('t_invoice', ['id_invoice' => $id]);
        if ($deleteData) {
            //balikin stok barang ke semula
            if ($jenis_inv == '0') {
                $id_barang = $this->db->query("SELECT * FROM t_invoice_detail WHERE id_invoice='$id'")->result();
            } else {
                $id_barang = $this->db->query("SELECT * FROM t_invoice_detail_kaca WHERE id_invoice='$id'")->result();
            }
            foreach ($id_barang as $ib) {
                $this->db->query("UPDATE t_stok SET stok = stok + " . $ib->stok . " WHERE id = '$ib->id_barang'");
            }

            //hapus di t_pembelian_barang_detail
            $this->db->delete('t_invoice_detail', ['id_invoice' => $id]);
            //insert ke t_logs
            if ($jenis_inv == '0') {
                $keterangan = 'Menghapus invoice dengan no invoice ' . $no_invoice;
            } else {
                $keterangan = 'Menghapus invoice kaca dengan no invoice ' . $no_invoice;
            }
            $dataLogs = [
                'username' => $this->session->userdata('username'),
                'tanggal' => date("Y-m-d H-i-s"),
                'keterangan' => $keterangan
            ];
            $this->db->insert('t_logs', $dataLogs);
            echo json_encode('berhasil');
        }
    }

    public function cetakInvoice($id)
    {
        $data['setting'] = $this->db->query("SELECT * FROM t_pengaturan")->row();
        $data['inv'] = $this->db->query("SELECT * FROM t_invoice WHERE id_invoice='$id'")->row();

        $jenisInv = $this->db->query("SELECT jenis_invoice FROM t_invoice WHERE id_invoice='$id'")->row()->jenis_invoice;
        if ($jenisInv == '0') {
            $data['detail'] = $this->db->query("SELECT * FROM t_invoice_detail WHERE id_invoice='$id'")->result();
            $this->load->view('penjualan/cetak_invoice', $data);
        } else {
            $data['detail'] = $this->db->query("SELECT * FROM t_invoice_detail_kaca WHERE id_invoice='$id'")->result();
            $this->load->view('penjualan/cetak_invoice_kaca', $data);
        }
    }

    // INVOICE KACA
    public function addViewKaca()
    {
        $data['title'] = 'Invoice Kaca';
        $this->template->load('template/template', 'penjualan/invoice_kaca_add', $data);
    }

    public function addDataInvKaca()
    {
        $this->form_validation->set_rules('id_customer', 'Customer', 'required');
        $this->form_validation->set_rules('term', 'Term', 'required');
        if ($this->form_validation->run() != FALSE) {
            $maxDetailInput = $this->db->query("SELECT max_detail_input FROM t_pengaturan")->row()->max_detail_input;

            $id_customer = $this->input->post('id_customer');
            $tgl_jual = $this->input->post('tgl_jual');
            $jatuh_tempo = $this->input->post('jatuh_tempo');
            $spg = $this->input->post('spg');
            $term = $this->input->post('term');

            $subtotal = str_replace(',', '.', str_replace('.', '', $this->input->post('subtotal')));
            $ongkir = str_replace(',', '.', str_replace('.', '', $this->input->post('ongkir')));
            $total = str_replace(',', '.', str_replace('.', '', $this->input->post('total')));

            $status_pembayaran = $this->input->post('status_pembayaran');
            if ($status_pembayaran == 'lunas') {
                $hutang = '0';
            } else {
                $hutang = $total;
            }

            $metode_pembayaran = $this->input->post('metode_pembayaran');
            if ($metode_pembayaran == 'tunai') {
                $id_rekening = '0';
            } else {
                $id_rekening = $this->input->post('id_rekening');
            }

            $no_invoice = $this->generateNoInvoice();

            $dataHead = [
                'no_invoice' => $no_invoice,
                'id_customer' => $id_customer,
                'tgl_jual' => $tgl_jual,
                'jatuh_tempo' => $jatuh_tempo,
                'term' => $term,
                'spg' => $spg,
                'jenis_invoice' => '1',
                'status_pembayaran' => $status_pembayaran,
                'hutang' => $hutang,
                'metode_pembayaran' => $metode_pembayaran,
                'id_rekening' => $id_rekening,
                'subtotal' => $subtotal,
                'ongkir' => $ongkir,
                'total' => $total
            ];
            $this->db->insert('t_invoice', $dataHead);
            $id_invoice = $this->db->insert_id();
            if ($id_invoice) {
                for ($d = 1; $d <= $maxDetailInput; $d++) {
                    if (!empty($_REQUEST['nama_barang3' . $d])) {
                        $id_barang = $_REQUEST['id_barang1' . $d];
                        $nama_barang = $_REQUEST['nama_barang3' . $d];
                        $stok = $_REQUEST['stok4' . $d];
                        $satuan = $_REQUEST['satuan5' . $d];
                        $panjang = $_REQUEST['panjang' . $d];
                        $lebar = $_REQUEST['lebar' . $d];
                        $harga_jual = str_replace(',', '.', str_replace('.', '', $_REQUEST['harga_jual6' . $d]));
                        $harga_after_diskon = str_replace(',', '.', str_replace('.', '', $_REQUEST['harga_after_diskon' . $d]));
                        $harga_permeter = str_replace(',', '.', str_replace('.', '', $_REQUEST['harga_permeter' . $d]));
                        $diskon_persen = $_REQUEST['diskon_persen7' . $d];
                        $diskon_nominal = str_replace(',', '.', str_replace('.', '', $_REQUEST['diskon_nominal8' . $d]));
                        $jumlah = str_replace(',', '.', str_replace('.', '', $_REQUEST['jumlah9' . $d]));

                        $dataDetail = [
                            'id_invoice' => $id_invoice,
                            'no_invoice' => $no_invoice,
                            'id_barang' => $id_barang,
                            'nama_barang' => $nama_barang,
                            'harga_jual' => $harga_jual,
                            'harga_after_diskon' => $harga_after_diskon,
                            'harga_permeter' => $harga_permeter,
                            'stok' => $stok,
                            'satuan' => $satuan,
                            'panjang' => $panjang,
                            'lebar' => $lebar,
                            'diskon_persen' => $diskon_persen,
                            'diskon_nominal' => $diskon_nominal,
                            'jumlah' => $jumlah
                        ];
                        $this->db->insert('t_invoice_detail_kaca', $dataDetail);

                        //update stok barang (-)
                        $getStok = $this->db->query("SELECT stok FROM t_stok WHERE id = '$id_barang'")->row()->stok;
                        $jmlStok = $getStok - $stok;
                        $this->db->query("UPDATE t_stok SET stok = '$jmlStok' WHERE id = '$id_barang'");
                    }
                }
                //insert ke t_logs
                $dataLogs = [
                    'username' => $this->session->userdata('username'),
                    'tanggal' => date("Y-m-d H-i-s"),
                    'keterangan' => 'Transaksi invoice kaca dengan no invoice ' . $no_invoice
                ];
                $this->db->insert('t_logs', $dataLogs);

                $this->session->set_flashdata('message', 'berhasil tambah');
                redirect('penjualan');
            }
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('penjualan/addViewKaca');
        }
    }

    public function editKacaView($id)
    {
        $data['title'] = 'Invoice Kaca';
        $data['data'] = $this->db->query("SELECT * FROM t_invoice WHERE id_invoice='$id'")->row();
        $data['detail'] = $this->db->query("SELECT * FROM t_invoice_detail_kaca WHERE id_invoice='$id'")->result();
        $this->template->load('template/template', 'penjualan/invoice_kaca_edit', $data);
    }

    public function editDataKaca($id)
    {

        $maxDetailInput = $this->db->query("SELECT max_detail_input FROM t_pengaturan")->row()->max_detail_input;

        $id_customer = $this->input->post('id_customer');
        $tgl_jual = $this->input->post('tgl_jual');
        $jatuh_tempo = $this->input->post('jatuh_tempo');
        $spg = $this->input->post('spg');
        $term = $this->input->post('term');

        $subtotal = str_replace(',', '.', str_replace('.', '', $this->input->post('subtotal')));
        $ongkir = str_replace(',', '.', str_replace('.', '', $this->input->post('ongkir')));
        $total = str_replace(',', '.', str_replace('.', '', $this->input->post('total')));

        $status_pembayaran = $this->input->post('status_pembayaran');
        if ($status_pembayaran == 'lunas') {
            $hutang = '0';
        } else {
            $hutang = $total;
        }

        $metode_pembayaran = $this->input->post('metode_pembayaran');
        if ($metode_pembayaran == 'tunai') {
            $id_rekening = '0';
        } else {
            $id_rekening = $this->input->post('id_rekening');
        }

        $no_invoice = $this->db->query("SELECT no_invoice FROM t_invoice WHERE id_invoice='$id'")->row()->no_invoice;

        $dataHead = [
            'no_invoice' => $no_invoice,
            'id_customer' => $id_customer,
            'tgl_jual' => $tgl_jual,
            'jatuh_tempo' => $jatuh_tempo,
            'term' => $term,
            'spg' => $spg,
            'jenis_invoice' => '1',
            'status_pembayaran' => $status_pembayaran,
            'hutang' => $hutang,
            'metode_pembayaran' => $metode_pembayaran,
            'id_rekening' => $id_rekening,
            'subtotal' => $subtotal,
            'ongkir' => $ongkir,
            'total' => $total
        ];
        $this->db->where('id_invoice', $id);
        $this->db->update('t_invoice', $dataHead);

        //balikin stok sebelumnya
        $id_barang = $this->db->query("SELECT * FROM t_invoice_detail_kaca WHERE id_invoice='$id'")->result();
        foreach ($id_barang as $ib) {
            $this->db->query("UPDATE t_stok SET stok = stok + " . $ib->stok . " WHERE id = '$ib->id_barang'");
        }

        //hapus detail pembelian
        $this->db->where('id_invoice', $id);
        $this->db->delete('t_invoice_detail_kaca');

        //insert ulang detail pembelian
        for ($d = 1; $d <= $maxDetailInput; $d++) {
            if (!empty($_REQUEST['nama_barang3' . $d])) {
                $id_barang = $_REQUEST['id_barang1' . $d];
                $nama_barang = $_REQUEST['nama_barang3' . $d];
                $stok = $_REQUEST['stok4' . $d];
                $satuan = $_REQUEST['satuan5' . $d];
                $panjang = $_REQUEST['panjang' . $d];
                $lebar = $_REQUEST['lebar' . $d];
                $harga_jual = str_replace(',', '.', str_replace('.', '', $_REQUEST['harga_jual6' . $d]));
                $harga_after_diskon = str_replace(',', '.', str_replace('.', '', $_REQUEST['harga_after_diskon' . $d]));
                $harga_permeter = str_replace(',', '.', str_replace('.', '', $_REQUEST['harga_permeter' . $d]));
                $diskon_persen = $_REQUEST['diskon_persen7' . $d];
                $diskon_nominal = str_replace(',', '.', str_replace('.', '', $_REQUEST['diskon_nominal8' . $d]));
                $jumlah = str_replace(',', '.', str_replace('.', '', $_REQUEST['jumlah9' . $d]));

                $dataDetail = [
                    'id_invoice' => $id,
                    'no_invoice' => $no_invoice,
                    'id_barang' => $id_barang,
                    'nama_barang' => $nama_barang,
                    'harga_jual' => $harga_jual,
                    'harga_after_diskon' => $harga_after_diskon,
                    'harga_permeter' => $harga_permeter,
                    'stok' => $stok,
                    'satuan' => $satuan,
                    'panjang' => $panjang,
                    'lebar' => $lebar,
                    'diskon_persen' => $diskon_persen,
                    'diskon_nominal' => $diskon_nominal,
                    'jumlah' => $jumlah
                ];
                $this->db->insert('t_invoice_detail_kaca', $dataDetail);

                //update stok barang (-)
                $getStok = $this->db->query("SELECT stok FROM t_stok WHERE id = '$id_barang'")->row()->stok;
                $stokAkhir = $getStok - $stok;
                $this->db->query("UPDATE t_stok SET stok = '$stokAkhir' WHERE id = '$id_barang'");
            }
        }

        //insert ke t_logs
        $dataLogs = [
            'username' => $this->session->userdata('username'),
            'tanggal' => date("Y-m-d H-i-s"),
            'keterangan' => 'Melakukan update transaksi invoice kaca dengan no invoice ' . $no_invoice
        ];
        $this->db->insert('t_logs', $dataLogs);

        $this->session->set_flashdata('message', 'berhasil ubah');
        redirect('penjualan');
    }

    // END INVOICE KACA

    public function generateNoInvoice()
    {
        $date = date("ym");
        $ins = "INV/";
        $getNoTransaksi = $this->db->query("SELECT no_invoice FROM t_invoice WHERE no_invoice LIKE '$ins$date%' ORDER BY id_invoice DESC LIMIT 1")->row();
        if ($getNoTransaksi) {
            $lastNumber = intval(substr($getNoTransaksi->no_invoice, -4));
            $noInvoice = $lastNumber + 1;
        } else {
            $noInvoice = 1;
        }

        if ($noInvoice > 9999) {
            $this->session->set_flashdata('message', 'melebihi_batas');
            redirect('penjualan');
            return false;
        }

        $no_invoice = $ins . $date . str_pad($noInvoice, 4, "0", STR_PAD_LEFT);
        return $no_invoice;
    }
}
