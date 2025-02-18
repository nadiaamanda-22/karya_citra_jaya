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
    }

    public function index()
    {
        $data['title'] = 'Stok Barang';
        // $data['stokbarang'] = $this->db->get("t_stok")->join('t_kelompok_barang', 't_stok.id = t_kelompok_barang.id_kelompok')->get()->result();
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
        $this->form_validation->set_rules('id_kelompok', 'Kelompok barang', 'required');
        $this->form_validation->set_rules('stok', 'Stok', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('harga_beli', 'Harga beli', 'required');
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required');
        $this->form_validation->set_rules('harga_permeter', 'Satuan');
        if ($this->form_validation->run() != FALSE) {
            $data = [
                'kode_barang' => $this->input->post('kode_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'id_kelompok' => $this->input->post('id_kelompok'),
                'stok' => $this->input->post('stok'),
                'satuan' => $this->input->post('satuan'),
                'harga_beli' => $this->input->post('harga_beli'),
                'harga_jual' => $this->input->post('harga_jual'),
                'harga_permeter' => $this->input->post('harga_permeter')
            ];
            $this->db->insert('t_stok', $data);

            $this->session->set_flashdata('message', 'berhasil tambah');
            redirect('stokbarang');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('stokbarang/addView');
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
        $this->form_validation->set_rules('id_kelompok', 'Kelompok barang', 'required');
        $this->form_validation->set_rules('stok', 'Stok', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('harga_beli', 'Harga beli', 'required');
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required');
        $this->form_validation->set_rules('harga_permeter', 'Satuan');
        if ($this->form_validation->run() != FALSE) {
            $data = [
                'kode_barang' => $this->input->post('kode_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'id_kelompok' => $this->input->post('id_kelompok'),
                'stok' => $this->input->post('stok'),
                'satuan' => $this->input->post('satuan'),
                'harga_beli' => $this->input->post('harga_beli'),
                'harga_jual' => $this->input->post('harga_jual'),
                'harga_permeter' => $this->input->post('harga_permeter')
            ];


            $this->db->where('id', $id);
            $this->db->update('t_stok', $data);

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
        $deleteData = $this->db->delete('t_stok', ['id' => $id]);
        if ($deleteData) {
            echo json_encode('berhasil');
        }
    }
}
