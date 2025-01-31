<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelompokbarang extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'Kelompokbarang';
        $data['kelompokbarang'] = $this->db->get("t_kelompok_barang")->result();
        $this->template->load('template/template', 'persediaan/kelompokbarang', $data);
    }

    public function addView()
    {
        $data['title'] = 'Kelompokbarang';
        $this->template->load('template/template', 'persediaan/kelompokbarang_add', $data);
    }

    public function addData()
    {
        $this->form_validation->set_rules('kode_kelompok', 'Kode_kelompok', 'required');
        $this->form_validation->set_rules('nama_kelompok', 'Nama_kelompok', 'required');
        if ($this->form_validation->run() != FALSE) {
            $data = [
                'kode_kelompok' => $this->input->post('kode_kelompok'),
                'nama_kelompok' => $this->input->post('nama_kelompok')
            ];
           
            $this->db->insert('t_kelompok_barang', $data);

            $this->session->set_flashdata('message', 'berhasil tambah');
            redirect('kelompokbarang');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('kelompokbarang/addView');
        }
    }

    public function editView($id_kelompok)
    {
        $data['title'] = 'Kelompokbarang';
        $data['kelompokbarang'] = $this->db->query("SELECT * FROM t_kelompok_barang WHERE id_kelompok='$id_kelompok', ")->row();
        $this->template->load('template/template', 'persediaan/kelompokbarang_edit', $data);
    }

    public function editData($id_kelompok)
    {
        $this->form_validation->set_rules('kode_kelompok', 'Kode_kelompok', 'required');
        $this->form_validation->set_rules('nama_kelompok', 'Nama_kelompok', 'required');
        if ($this->form_validation->run() != FALSE) {
            $data = [
                'kode_kelompok' => $this->input->post('kode_kelompok'),
                'nama_kelompok' => $this->input->post('nama_kelompok')
            ];
            $this->db->where('id_kelompok', $id_kelompok);
            $this->db->update('t_kelompok_barang', $data);

            $this->session->set_flashdata('message', 'berhasil ubah');
            redirect('kelompokbarang');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('kelompokbarang/editView/' . $id_kelompok);
        }
    }

    public function hapusData()
    {
        $id_kelompok = $this->input->post('id');
        $deleteData = $this->db->delete('t_kelompok_barang', ['id_kelompok' => $id_kelompok]);
        if ($deleteData) {
            echo json_encode('berhasil');
        }
    }
}
