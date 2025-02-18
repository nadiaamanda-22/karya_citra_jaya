<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

    public function addView()
    {
        $data['title'] = 'Pembelian Barang';
        $this->template->load('template/template', 'persediaan/pembelianbarang_add', $data);
    }

    public function addData()
    {
        $this->form_validation->set_rules('no_transaksi', 'No transaksi', 'required');
        
        if ($this->form_validation->run() != FALSE) {
            $data = [
                'no_transaksi' => $this->input->post('no_transaksi'),
                
            ];

            $this->db->insert('t_pembelian_barang', $data);

            $this->session->set_flashdata('message', 'berhasil tambah');
            redirect('pembelianbarang');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('pembelianbarang/addView');
        }
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
        $id = $this->input->post('id_pembelian');
        $deleteData = $this->db->delete('t_pembelian_barang', ['id_pembelian' => $id_pembelian]);
        if ($deleteData) {
            echo json_encode('berhasil');
        }
    }

}