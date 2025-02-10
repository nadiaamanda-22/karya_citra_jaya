<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function index()
	{
		$this->load->view('login');
	}

	public function login()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() != FALSE) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$getUser = $this->db->get_where('t_user', ['username' => $username])->row_array();
			if ($getUser) {
				if (md5($password) == $getUser['password_md5']) {
					$data_session = [
						'id_user' => $getUser['id_user'],
						'username' => $getUser['username'],
						'nama_user' => $getUser['nama_user'],
						'level' => $getUser['level'],
						'role' => $getUser['role'],
						'image' => $getUser['image'],
						'is_login' => true
					];
					$this->session->set_userdata($data_session);
					redirect('Dashboard');
				} else {
					$this->session->set_flashdata('message', 'gagal_login');
					redirect('login');
				}
			} else {
				$this->session->set_flashdata('message', 'gagal_login');
				redirect('login');
			}
		} else {
			$this->session->set_flashdata('message', 'required');
			redirect('login');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('Login');
	}
}
