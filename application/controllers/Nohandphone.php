<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nohandphone extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'No Handphone';
        $data['no_hp'] = $this->db->get("t_no_hp")->result();
        $this->template->load('template/template', 'dashboard/no_hp', $data);
    }

    public function addView()
    {
        $data['title'] = 'No Handphone';
        $this->template->load('template/template', 'dashboard/no_hp_add', $data);
    }

    public function addData()
    {
        $this->form_validation->set_rules('no_hp', 'no_hp', 'required');
        if ($this->form_validation->run() != FALSE) {
            $data = [
                'no_hp' => $this->input->post('no_hp')
            ];
            $this->db->insert('t_no_hp', $data);

            $this->session->set_flashdata('message', 'berhasil tambah');
            redirect('Nohandphone');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('Nohandphone/addView');
        }
    }

    public function editView($id)
    {
        $data['title'] = 'No Handphone';
        $data['no_hp'] = $this->db->query("SELECT * FROM t_no_hp WHERE id='$id'")->row();
        $this->template->load('template/template', 'dashboard/no_hp_edit', $data);
    }

    public function editData($id)
    {
        $this->form_validation->set_rules('no_hp', 'no_hp', 'required');
        if ($this->form_validation->run() != FALSE) {
            $data = [
                'no_hp' => $this->input->post('no_hp')
            ];
            $this->db->where('id', $id);
            $this->db->update('t_no_hp', $data);

            $this->session->set_flashdata('message', 'berhasil ubah');
            redirect('Nohandphone');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('Nohandphone/editView/' . $id);
        }
    }

    public function hapusData()
    {
        $id = $this->input->post('id');
        $deleteData = $this->db->delete('t_no_hp', ['id' => $id]);
        if ($deleteData) {
            echo json_encode('berhasil');
        }
    }
}
