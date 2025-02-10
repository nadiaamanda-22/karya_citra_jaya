<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekening extends CI_Controller
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
        $data['title'] = 'Rekening';
        $data['rekening'] = $this->db->get("t_rekening")->result();
        $this->template->load('template/template', 'administrasi/rekening', $data);
    }

    public function addView()
    {
        $data['title'] = 'Rekening';
        $this->template->load('template/template', 'administrasi/rekening_add', $data);
    }

    public function addData()
    {
        $this->form_validation->set_rules('rekening', 'Rekening', 'required');
        if ($this->form_validation->run() != FALSE) {
            $data = [
                'rekening' => $this->input->post('rekening')
            ];
            $this->db->insert('t_rekening', $data);

            $this->session->set_flashdata('message', 'berhasil tambah');
            redirect('rekening');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('rekening/addView');
        }
    }

    public function editView($id_rekening)
    {
        $data['title'] = 'Rekening';
        $data['rekening'] = $this->db->query("SELECT * FROM t_rekening WHERE id_rekening='$id_rekening'")->row();
        $this->template->load('template/template', 'administrasi/rekening_edit', $data);
    }

    public function editData($id_rekening)
    {
        $this->form_validation->set_rules('rekening', 'Rekening', 'required');
        if ($this->form_validation->run() != FALSE) {
            $data = [
                'rekening' => $this->input->post('rekening')
            ];
            $this->db->where('id_rekening', $id_rekening);
            $this->db->update('t_rekening', $data);

            $this->session->set_flashdata('message', 'berhasil ubah');
            redirect('rekening');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('rekening/editView/' . $id_rekening);
        }
    }

    public function hapusData()
    {
        $id_rekening = $this->input->post('id');
        $deleteData = $this->db->delete('t_rekening', ['id_rekening' => $id_rekening]);
        if ($deleteData) {
            echo json_encode('berhasil');
        }
    }
}
