<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
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
        $data['title'] = 'Customer';
        $data['customer'] = $this->db->get("t_customer")->result();
        $this->template->load('template/template', 'administrasi/customer', $data);
    }

    public function addView()
    {
        $data['title'] = 'Customer';
        $this->template->load('template/template', 'administrasi/customer_add', $data);
    }

    public function addData()
    {
        $this->form_validation->set_rules('nama_customer', 'Customer', 'required');
        $this->form_validation->set_rules('no_hp', 'Customer', 'required');
        $this->form_validation->set_rules('alamat', 'Customer', 'required');
        if ($this->form_validation->run() != FALSE) {
            $data = [
                'nama_customer' => $this->input->post('nama_customer'),
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat')
            ];
            $this->db->insert('t_customer', $data);

            $this->session->set_flashdata('message', 'berhasil tambah');
            redirect('customer');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('customer/addView');
        }
    }

    public function editView($id_customer)
    {
        $data['title'] = 'Customer';
        $data['customer'] = $this->db->query("SELECT * FROM t_customer WHERE id_customer='$id_customer'")->row();
        $this->template->load('template/template', 'administrasi/customer_edit', $data);
    }

    public function editData($id_customer)
    {
        $this->form_validation->set_rules('nama_customer', 'Customer', 'required');
        $this->form_validation->set_rules('no_hp', 'Customer', 'required');
        $this->form_validation->set_rules('alamat', 'Customer', 'required');
        if ($this->form_validation->run() != FALSE) {
            $data = [
                'nama_customer' => $this->input->post('nama_customer'),
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat')
            ];
            $this->db->where('id_customer', $id_customer);
            $this->db->update('t_customer', $data);

            $this->session->set_flashdata('message', 'berhasil ubah');
            redirect('customer');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('customer/editView/' . $id_customer);
        }
    }

    public function hapusData()
    {
        $id_customer = $this->input->post('id');
        $deleteData = $this->db->delete('t_customer', ['id_customer' => $id_customer]);
        if ($deleteData) {
            echo json_encode('berhasil');
        }
    }
}
