<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends CI_Controller
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
        $data['title'] = 'Profil';
        $idUser = $this->session->userdata('id_user');
        $idUser = $this->db->query("SELECT id_user FROM t_user WHERE id_user='$idUser'")->row()->id_user;

        $data['user'] = $this->db->query("SELECT * FROM t_user WHERE id_user='$idUser'")->row();
        $this->template->load('template/template', 'dashboard/profil', $data);
    }

    public function editProfil($idUser)
    {
        $this->form_validation->set_rules('nama_user', 'nama', 'required');
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');

        if ($this->form_validation->run() != FALSE) {
            $nama_user = $this->input->post('nama_user');
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $newImg = $_FILES['image']['name'];
            $oldImg = $this->db->query("SELECT image FROM t_user WHERE id_user='$idUser'")->row()->image;

            //cek ada gambar yg di upload atau tidak
            if (!empty($newImg)) {
                if ($oldImg != 'default.png') {
                    @unlink(FCPATH . './assets/img/user/' . $oldImg);
                }
                $image = $this->uploadGambar();
            } else {
                //jika tidak ada yg di upload, gunakan gambar sebelumnya
                $image = $oldImg;
            }

            $updateData = [
                'nama_user' => $nama_user,
                'username' => $username,
                'password' => $password,
                'password_md5' => md5($password),
                'image' => $image
            ];
            $this->db->where('id_user', $idUser);
            $this->db->update('t_user', $updateData);

            // Perbarui session userdata
            $this->session->set_userdata('nama_user', $nama_user);
            $this->session->set_userdata('image', $image);

            $this->session->set_flashdata('message', 'berhasil ubah');
            redirect('profil');
        } else {
            $this->session->set_flashdata('message', 'error');
            redirect('profil');
        }
    }

    public function uploadGambar()
    {
        $config = [
            'upload_path' => './assets/img/user',
            'allowed_types' => 'jpg|png|jpeg',
            'max_size' => 10048,
            'file_name' => time() . '_' . $_FILES['image']['name']
        ];
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('image')) {
            $image = 'default.png';
            return $image;
        } else {
            $image = $this->upload->data('file_name');
            return $image;
        }
    }
}
