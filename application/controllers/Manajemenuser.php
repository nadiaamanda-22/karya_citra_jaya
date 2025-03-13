<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manajemenuser extends CI_Controller
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
        $data['title'] = 'Manajemen User';
        $data['user'] = $this->db->get('t_user')->result();
        $this->template->load('template/template', 'dashboard/manajemenuser', $data);
    }

    public function addManajemenUser()
    {
        $data['title'] = 'Manajemen User';
        $this->template->load('template/template', 'dashboard/addManajemenUser', $data);
    }

    public function addUser()
    {
        $this->form_validation->set_rules('nama_user', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() != FALSE) {
            $namaUser = $this->input->post('nama_user');
            $username = $this->input->post('username');
            $level = $this->input->post('level');
            $role = $this->input->post('role');
            $menu = $this->input->post('menu');
            $password = $this->input->post('password');

            if (strlen($password) < 5) {
                $this->session->set_flashdata('message', 'karakter kurang');
                redirect('manajemenuser/addManajemenUser');
                return false;
            } else if (!preg_match('/[A-Z]/', $password)) {
                $this->session->set_flashdata('message', 'kapital');
                redirect('manajemenuser/addManajemenUser');
                return false;
            } else if (!preg_match('/\d/', $password)) {
                $this->session->set_flashdata('message', 'angka');
                redirect('manajemenuser/addManajemenUser');
                return false;
            } else if (!preg_match('/[_\-\!]/', $password)) {
                $this->session->set_flashdata('message', 'karakter khusus');
                redirect('manajemenuser/addManajemenUser');
                return false;
            } else {
                $inputPassword = $password;
            }

            if ($menu == null) {
                $this->session->set_flashdata('message', 'menu');
                redirect('manajemenuser/addManajemenUser');
                return false;
            } else {
                $inputMenu = $menu;
            }

            //cek ada gambar yg di upload atau tidak
            if (!empty($_FILES['image']['name'])) {
                $image = $this->uploadGambar();
            } else {
                //jika tidak ada yg di upload, gunakan default
                $image = 'default.png';
            }

            $insertData = [
                'nama_user' => $namaUser,
                'username' => $username,
                'password' => $inputPassword,
                'password_md5' => md5($inputPassword),
                'level' => $level,
                'role' => $role,
                'image' => $image
            ];
            $this->db->insert('t_user', $insertData);
            $idUser = $this->db->insert_id();

            foreach ($inputMenu as $sm) {
                $data = [
                    'id_user' => $idUser,
                    'id_menu' => $sm
                ];
                $this->db->insert('t_user_menu', $data);
            }
            $this->session->set_flashdata('message', 'berhasil tambah');
            redirect('manajemenuser');
        } else {
            $this->session->set_flashdata('message', 'required');
            redirect('manajemenuser/addManajemenUser');
        }
    }

    public function editView($idUser)
    {
        $data['title'] = 'Manajemen User';
        $data['user'] = $this->db->query("SELECT * FROM t_user WHERE id_user='$idUser'")->row();
        $data['menu_user'] = $this->db->query("SELECT id_menu FROM t_user_menu WHERE id_user = '$idUser'")->result_array();
        $this->template->load('template/template', 'dashboard/editManajemenUser', $data);
    }

    public function editData($idUser)
    {
        $this->form_validation->set_rules('nama_user', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() != FALSE) {

            $namaUser = $this->input->post('nama_user');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $level = $this->input->post('level');
            $role = $this->input->post('role');
            $menu = $this->input->post('menu');
            $newImg = $_FILES['image']['name'];
            $oldImg = $this->db->query("SELECT image FROM t_user WHERE id_user='$idUser'")->row()->image;

            if (strlen($password) < 5) {
                $this->session->set_flashdata('message', 'karakter kurang');
                redirect('manajemenuser/editView/' . $idUser);
                return false;
            } else if (!preg_match('/[A-Z]/', $password)) {
                $this->session->set_flashdata('message', 'kapital');
                redirect('manajemenuser/editView/' . $idUser);
                return false;
            } else if (!preg_match('/\d/', $password)) {
                $this->session->set_flashdata('message', 'angka');
                redirect('manajemenuser/editView/' . $idUser);
                return false;
            } else if (!preg_match('/[_\-\!]/', $password)) {
                $this->session->set_flashdata('message', 'karakter khusus');
                redirect('manajemenuser/editView/' . $idUser);
                return false;
            } else {
                $inputPassword = $password;
            }

            if ($menu == null) {
                $this->session->set_flashdata('message', 'menu');
                redirect('manajemenuser/editView/' . $idUser);
                return false;
            } else {
                $inputMenu = $menu;
            }

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
                'nama_user' => $namaUser,
                'username' => $username,
                'password' => $inputPassword,
                'password_md5' => md5($inputPassword),
                'level' => $level,
                'role' => $role,
                'image' => $image
            ];
            $this->db->where('id_user', $idUser);
            $this->db->update('t_user', $updateData);

            //hapus menu-menu user
            $this->db->delete('t_user_menu', ['id_user' => $idUser]);
            //insert ulang menu user
            foreach ($inputMenu as $sm) {
                $data = [
                    'id_user' => $idUser,
                    'id_menu' => $sm
                ];
                $this->db->insert('t_user_menu', $data);
            }
            $this->session->set_flashdata('message', 'berhasil ubah');
            redirect('manajemenuser');
        } else {
            $this->session->set_flashdata('message', 'required');
            redirect('manajemenuser/editView/' . $idUser);
        }
    }

    public function hapusData()
    {
        $idUser = $this->input->post('id');
        $oldImg = $this->db->query("SELECT image FROM t_user WHERE id_user='$idUser'")->row()->image;

        $deleteData = $this->db->delete('t_user', ['id_user' => $idUser]);
        if ($deleteData) {
            //delete menu by user
            $this->db->delete('t_user_menu', ['id_user' => $idUser]);

            //delete img di folder assets
            if ($oldImg != 'default.png') {
                @unlink(FCPATH . './assets/img/user/' . $oldImg);
            }
            echo json_encode('berhasil');
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
