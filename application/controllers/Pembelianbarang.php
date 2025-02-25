<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Pembelianbarang extends CI_Controller
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
        $data['title'] = 'Pembelian Barang';
        $data['pembelianbarang'] = $this->db->get("t_pembelian_barang")->result();
        $this->template->load('template/template', 'persediaan/pembelianbarang', $data);
    }

    public function searchSupplier()
    {
        if (empty($_REQUEST['term']))
            exit;

        $getSupplier = $this->db->query("SELECT id_supplier, supplier FROM t_supplier WHERE (supplier LIKE '%" . $_REQUEST['term'] . "%') ORDER BY supplier ASC LIMIT 0,10")->result_array();
        $data = array();
        foreach ($getSupplier as $r) {
            $data[] = array(
                "label" => $r['supplier'], // Untuk ditampilkan di dropdown
                "value" => $r['supplier'],   // Untuk diisi di input
                "id_supplier" => $r['id_supplier']
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
                "label" => $r['kode_barang'] . ' - ' . $r['nama_barang'],
                "value" => $r['kode_barang'],
                "id_barang" => $r['id'],
                "nama_barang" => $r['nama_barang'],
                "stok" => $r['stok'],
                "satuan" => $r['satuan'],
                "harga_beli" =>  intval($r['harga_beli']),
            );
        }
        echo json_encode($data);
    }

    public function addView()
    {
        $data['title'] = 'Pembelian Barang';
        $this->template->load('template/template', 'persediaan/pembelianbarang_add', $data);
    }

    public function addData()
    {
        $this->form_validation->set_rules('id_supplier', 'Supplier', 'required');
        $this->form_validation->set_rules('term', 'Term', 'required');

        if ($this->form_validation->run() != FALSE) {
            $maxDetailInput = $this->db->query("SELECT max_detail_input FROM t_pengaturan")->row()->max_detail_input;
            $total = str_replace(',', '.', str_replace('.', '', $this->input->post('total')));
            $id_supplier = $this->input->post('id_supplier');
            $tgl_pembelian = $this->input->post('tgl_pembelian');
            $jatuh_tempo = $this->input->post('jatuh_tempo');
            $term = $this->input->post('term');

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

            $no_transaksi = $this->generateNoTransaksi();

            $dataHead = [
                'no_transaksi' => $no_transaksi,
                'id_supplier' => $id_supplier,
                'tgl_pembelian' => $tgl_pembelian,
                'jatuh_tempo' => $jatuh_tempo,
                'term' => $term,
                'status_pembayaran' => $status_pembayaran,
                'hutang' => $hutang,
                'metode_pembayaran' => $metode_pembayaran,
                'id_rekening' => $id_rekening,
                'total' => $total
            ];
            $this->db->insert('t_pembelian_barang', $dataHead);
            $id_pembelian_barang = $this->db->insert_id();

            if ($id_pembelian_barang) {
                for ($d = 1; $d <= $maxDetailInput; $d++) {
                    if (!empty($_REQUEST['nama_barang3' . $d])) {
                        $id_barang = $_REQUEST['id_barang1' . $d];
                        $nama_barang = $_REQUEST['nama_barang3' . $d];
                        $stok = $_REQUEST['stok4' . $d];
                        $satuan = $_REQUEST['satuan5' . $d];
                        $harga_beli = str_replace(',', '.', str_replace('.', '', $_REQUEST['harga_beli6' . $d]));
                        $diskon_persen = $_REQUEST['diskon_persen7' . $d];
                        $diskon_nominal = str_replace(',', '.', str_replace('.', '', $_REQUEST['diskon_nominal8' . $d]));
                        $jumlah = str_replace(',', '.', str_replace('.', '', $_REQUEST['jumlah9' . $d]));

                        $dataDetail = [
                            'id_pembelian' => $id_pembelian_barang,
                            'no_transaksi' => $no_transaksi,
                            'id_barang' => $id_barang,
                            'nama_barang' => $nama_barang,
                            'harga_beli' => $harga_beli,
                            'stok' => $stok,
                            'satuan' => $satuan,
                            'diskon_persen' => $diskon_persen,
                            'diskon_nominal' => $diskon_nominal,
                            'jumlah' => $jumlah
                        ];
                        $this->db->insert('t_pembelian_barang_detail', $dataDetail);
                        //update stok barang (+)
                        $getStok = $this->db->query("SELECT stok FROM t_stok WHERE id = '$id_barang'")->row()->stok;
                        $stokPembelian = $getStok + $stok;
                        $this->db->query("UPDATE t_stok SET stok = '$stokPembelian' WHERE id = '$id_barang'");
                    }
                }

                //insert ke t_logs
                $dataLogs = [
                    'username' => $this->session->userdata('username'),
                    'tanggal' => date("Y-m-d H-i-s"),
                    'keterangan' => 'Melakukan pembelian barang dengan no transaksi ' . $no_transaksi
                ];
                $this->db->insert('t_logs', $dataLogs);

                $this->session->set_flashdata('message', 'berhasil tambah');
                redirect('pembelianbarang');
            }
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('pembelianbarang/addView');
        }
    }

    public function detailData($id)
    {
        $data['title'] = 'Detail Pembelian Barang';
        $data['data'] = $this->db->query("SELECT * FROM t_pembelian_barang WHERE id_pembelian='$id'")->row();
        $data['detail'] = $this->db->query("SELECT * FROM t_pembelian_barang_detail WHERE id_pembelian='$id'")->result();
        $this->template->load('template/template', 'persediaan/pembelianbarang_detail', $data);
    }

    public function editView($id_pembelian)
    {
        $data['title'] = 'Pembelian Barang';
        $data['pembelianbarang'] = $this->db->query("SELECT * FROM t_pembelian_barang WHERE id_pembelian='$id_pembelian'")->row();
        $this->template->load('template/template', 'persediaan/pembelianbarang_edit', $data);
    }

    public function editData($id_pembelian)
    {
        $this->form_validation->set_rules('no_transaksi', 'No Transaksi', 'required');

        if ($this->form_validation->run() != FALSE) {
            $data = [
                'no_transaksi' => $this->input->post('no_tarnsaksi'),

            ];
            $this->db->where('id_pembelian', $id_pembelian);
            $this->db->update('t_pembelian_barang', $data);

            $this->session->set_flashdata('message', 'berhasil ubah');
            redirect('pembelianbarang');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('pembelianbarang/editView/' . $id);
        }
    }

    public function hapusData()
    {
        $id = $this->input->post('id');
        $deleteData = $this->db->delete('t_pembelian_barang', ['id_pembelian' => $id]);
        if ($deleteData) {
            $this->db->delete('t_pembelian_barang_detail', ['id_pembelian' => $id]);
            echo json_encode('berhasil');
        }
    }

    public function generateNoTransaksi()
    {
        $date = date("ym");
        $ins = "PB/";
        $getNoTransaksi = $this->db->query("SELECT no_transaksi FROM t_pembelian_barang WHERE no_transaksi LIKE '$ins$date%' ORDER BY id_pembelian DESC LIMIT 1")->row();
        if ($getNoTransaksi) {
            $lastNumber = intval(substr($getNoTransaksi->no_transaksi, -4));
            $noTransaksi = $lastNumber + 1;
        } else {
            $noTransaksi = 1;
        }

        if ($noTransaksi > 9999) {
            $this->session->set_flashdata('message', 'melebihi_batas');
            redirect('pembelianbarang');
            return false;
        }

        $no_transaksi = $ins . $date . str_pad($noTransaksi, 4, "0", STR_PAD_LEFT);
        return $no_transaksi;
    }
}
