<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('is_login')) {
            redirect('Login');
        }
        $this->load->library('upload');
    }

    public function index()
    {
        $data['title'] = 'Pengaturan';
        $data['pengaturan'] = $this->db->get("t_pengaturan")->row();
        $this->template->load('template/template', 'dashboard/pengaturan', $data);
    }

    public function updatePengaturan()
    {
        $this->form_validation->set_rules('nama_toko', 'Nama Toko', 'required');
        $this->form_validation->set_rules('no_telp', 'No Telepon', 'required');
        $this->form_validation->set_rules('id_no_hp[]', 'No Handphone', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('max_detail_input', 'Max Detail Input', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'data kosong');
            redirect('pengaturan');
        } else {
            $namaToko = $this->input->post('nama_toko');
            $noTelp = $this->input->post('no_telp');
            $noHP = $this->input->post('id_no_hp');
            $alamat = $this->input->post('alamat');
            $copy_print = $this->input->post('copy_print');
            $max_detail_input = $this->input->post('max_detail_input');

            $cekPengaturan = $this->db->query("SELECT * FROM t_pengaturan");
            if ($cekPengaturan->num_rows() > 0) {
                //update pengaturan
                $id = $cekPengaturan->row()->id;

                $newTTD = $_FILES['ttd']['name'];
                $newStempel = $_FILES['ttd']['name'];

                $olgImg = $this->db->query("SELECT ttd, stempel FROM t_pengaturan WHERE id='$id'")->row();
                $oldTTD = $olgImg->ttd;
                $oldStempel = $olgImg->stempel;

                if (!empty($newTTD)) {
                    if ($oldTTD != 'no-image.jpg') {
                        @unlink(FCPATH . './assets/img/setting/' . $oldTTD);
                    }
                    $TTD = $this->uploadGambarTTD();
                } else {
                    $TTD = $oldTTD;
                }

                if (!empty($newStempel)) {
                    if ($oldStempel != 'no-image.jpg') {
                        @unlink(FCPATH . './assets/img/setting/' . $oldStempel);
                    }
                    $stempel = $this->uploadGambarStempel();
                } else {
                    $stempel = $oldStempel;
                }

                if (!empty($noHP)) {
                    $no_hp_select = implode(',', $noHP);
                }

                $updateData = [
                    'nama_toko' => $namaToko,
                    'no_telp' => $noTelp,
                    'id_no_hp' => $no_hp_select,
                    'alamat' => $alamat,
                    'max_detail_input' => $max_detail_input,
                    'ttd' => $TTD,
                    'stempel' => $stempel
                ];
                $this->db->where('id', $id);
                $this->db->update('t_pengaturan', $updateData);
                $this->session->set_flashdata('message', 'berhasil ubah');
                redirect('pengaturan');
            } else {
                // ini belum ada data pengaturan, insert data
                if (!empty($_FILES['ttd']['name'])) {
                    $TTD = $this->uploadGambarTTD();
                } else {
                    $TTD = 'no-image.jpg';
                }

                if (!empty($_FILES['stempel']['name'])) {
                    $stempel = $this->uploadGambarStempel();
                } else {
                    $stempel = 'no-image.jpg';
                }

                if (!empty($noHP)) {
                    $no_hp_select = implode(',', $noHP);
                }

                $insertData = [
                    'nama_toko' => $namaToko,
                    'no_telp' => $noTelp,
                    'id_no_hp' => $no_hp_select,
                    'alamat' => $alamat,
                    'max_detail_input' => $max_detail_input,
                    'ttd' => $TTD,
                    'stempel' => $stempel
                ];
                $this->db->insert('t_pengaturan', $insertData);
                $this->session->set_flashdata('message', 'berhasil ubah');
                redirect('pengaturan');
            }
        }
    }

    public function uploadGambarTTD()
    {;
        $config = [
            'upload_path' => './assets/img/setting',
            'allowed_types' => 'jpg|png|jpeg',
            'max_size' => 10048,
            'file_name' => 'ttd_' . time()
        ];
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('ttd')) {
            $TTD = 'no-image.jpg';
            return $TTD;
        } else {
            $TTD = $this->upload->data('file_name');
            return $TTD;
        }
    }


    public function uploadGambarStempel()
    {
        $config = [
            'upload_path' => './assets/img/setting',
            'allowed_types' => 'jpg|png|jpeg',
            'max_size' => 10048,
            'file_name' => 'stempel_' . time()
        ];
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('stempel')) {
            $stempel = 'no-image.jpg';
            return $stempel;
        } else {
            $stempel = $this->upload->data('file_name');
            return $stempel;
        }
    }
}
