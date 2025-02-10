<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
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
        $data['title'] = 'Supplier';
        $data['supplier'] = $this->db->get("t_supplier")->result();
        $this->template->load('template/template', 'administrasi/supplier', $data);
    }

    public function addView()
    {
        $data['title'] = 'Supplier';
        $this->template->load('template/template', 'administrasi/supplier_add', $data);
    }

    public function addData()
    {
        $this->form_validation->set_rules('supplier', 'Supplier', 'required');
        if ($this->form_validation->run() != FALSE) {
            $data = [
                'supplier' => $this->input->post('supplier')
            ];
            $this->db->insert('t_supplier', $data);

            $this->session->set_flashdata('message', 'berhasil tambah');
            redirect('supplier');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('supplier/addView');
        }
    }

    public function editView($id_supplier)
    {
        $data['title'] = 'Supplier';
        $data['supplier'] = $this->db->query("SELECT * FROM t_supplier WHERE id_supplier='$id_supplier'")->row();
        $this->template->load('template/template', 'administrasi/supplier_edit', $data);
    }

    public function editData($id_supplier)
    {
        $this->form_validation->set_rules('supplier', 'Supplier', 'required');
        if ($this->form_validation->run() != FALSE) {
            $data = [
                'supplier' => $this->input->post('supplier')
            ];
            $this->db->where('id_supplier', $id_supplier);
            $this->db->update('t_supplier', $data);

            $this->session->set_flashdata('message', 'berhasil ubah');
            redirect('supplier');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('supplier/editView/' . $id_supplier);
        }
    }

    public function hapusData()
    {
        $id_supplier = $this->input->post('id');
        $deleteData = $this->db->delete('t_supplier', ['id_supplier' => $id_supplier]);
        if ($deleteData) {
            echo json_encode('berhasil');
        }
    }
}
