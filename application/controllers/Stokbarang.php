<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stokbarang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('is_login')) {
            redirect('Login');
        }
        $this->load->helper('custom_helper');
    }

    public function index()
    {
        $data['title'] = 'Stok Barang';
        $data['stokbarang'] = $this->db->select('*')->from('t_stok')->join('t_kelompok_barang', 't_stok.id_kelompok = t_kelompok_barang.id_kelompok')->get()->result();
        $this->template->load('template/template', 'persediaan/stokbarang', $data);
    }


    public function addView()
    {
        $data['title'] = 'Stok Barang';
        $data['kelompokbarang'] = $this->db->get("t_kelompok_barang")->result();
        $this->template->load('template/template', 'persediaan/stokbarang_add', $data);
    }

    public function addData()
    {
        $this->form_validation->set_rules('kode_barang', 'Kode barang', 'required');
        $this->form_validation->set_rules('nama_barang', 'Nama barang', 'required');
        $this->form_validation->set_rules('stok', 'Stok', 'required');
        $this->form_validation->set_rules('harga_beli', 'Harga beli', 'required');
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required');
        if ($this->form_validation->run() != FALSE) {

            $hargaBeli = str_replace(',', '.', str_replace('.', '', $this->input->post('harga_beli')));
            $hargaJual = str_replace(',', '.', str_replace('.', '', $this->input->post('harga_jual')));
            $hargaPerMeter = str_replace(',', '.', str_replace('.', '', $this->input->post('harga_permeter')));

            $data = [
                'kode_barang' => $this->input->post('kode_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'id_kelompok' => $this->input->post('id_kelompok'),
                'stok' => $this->input->post('stok'),
                'satuan' => $this->input->post('satuan'),
                'harga_beli' => $hargaBeli,
                'harga_jual' => $hargaJual,
                'harga_permeter' => $hargaPerMeter
            ];
            $this->db->insert('t_stok', $data);

            $dataLogs = [
                'username' => $this->session->userdata('username'),
                'tanggal' => date("Y-m-d_H-i-s"),
                'keterangan' => 'Menambah stok barang dengan kode ' . $this->input->post('kode_barang')
            ];
            $this->db->insert('t_logs', $dataLogs);

            $this->session->set_flashdata('message', 'berhasil tambah');
            redirect('stokbarang');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('stokbarang/addView');
        }
    }

    public function cekKodeBarang()
    {
        $cekKode = $this->db->query("SELECT COUNT(`kode_barang`) as kode FROM `t_stok` WHERE `kode_barang` = '$_REQUEST[kodeBarang]' AND `id` != '$_REQUEST[idStok]'")->row()->kode;
        if ($cekKode == 0) {
            echo json_encode(array('st' => 0));
        } else {
            echo json_encode(array('st' => 1));
        }
    }


    public function editView($id)
    {
        $data['title'] = 'Stok Barang';
        $data['kelompokbarang'] = $this->db->get("t_kelompok_barang")->result();
        $data['stokbarang'] = $this->db->query("SELECT * FROM t_stok WHERE id='$id'")->row();

        $this->template->load('template/template', 'persediaan/stokbarang_edit', $data);
    }

    public function editData($id)
    {
        $this->form_validation->set_rules('kode_barang', 'Kode barang', 'required');
        $this->form_validation->set_rules('nama_barang', 'Nama barang', 'required');
        $this->form_validation->set_rules('stok', 'Stok', 'required');
        $this->form_validation->set_rules('harga_beli', 'Harga beli', 'required');
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required');
        if ($this->form_validation->run() != FALSE) {

            $hargaBeli = str_replace(',', '.', str_replace('.', '', $this->input->post('harga_beli')));
            $hargaJual = str_replace(',', '.', str_replace('.', '', $this->input->post('harga_jual')));
            $hargaPerMeter = str_replace(',', '.', str_replace('.', '', $this->input->post('harga_permeter')));

            $data = [
                'kode_barang' => $this->input->post('kode_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'id_kelompok' => $this->input->post('id_kelompok'),
                'stok' => $this->input->post('stok'),
                'satuan' => $this->input->post('satuan'),
                'harga_beli' => $hargaBeli,
                'harga_jual' => $hargaJual,
                'harga_permeter' => $hargaPerMeter
            ];

            $this->db->where('id', $id);
            $this->db->update('t_stok', $data);

            $dataLogs = [
                'username' => $this->session->userdata('username'),
                'tanggal' => date("Y-m-d_H-i-s"),
                'keterangan' => 'Mengubah stok barang dengan kode ' . $this->input->post('kode_barang')
            ];
            $this->db->insert('t_logs', $dataLogs);

            $this->session->set_flashdata('message', 'berhasil ubah');
            redirect('stokbarang');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('stokbarang/editView/' . $id);
        }
    }

    public function hapusData()
    {
        $id = $this->input->post('id');
        $kodeBrg = $this->db->query("SELECT kode_barang FROM t_stok WHERE id = '$id'")->row()->kode_barang;
        $deleteData = $this->db->delete('t_stok', ['id' => $id]);
        if ($deleteData) {
            $dataLogs = [
                'username' => $this->session->userdata('username'),
                'tanggal' => date("Y-m-d_H-i-s"),
                'keterangan' => 'Menghapus stok barang dengan kode ' . $kodeBrg
            ];
            $this->db->insert('t_logs', $dataLogs);
            echo json_encode('berhasil');
        }
    }
}
