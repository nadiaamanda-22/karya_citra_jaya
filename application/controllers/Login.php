<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
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

					$dataLogs = [
						'username' => $getUser['username'],
						'tanggal' => date("Y-m-d H-i-s"),
						'keterangan' => $getUser['nama_user'] . ' melakukan login'
					];
					$this->db->insert('t_logs', $dataLogs);

					$cekUser = $this->db->query("SELECT id_menu FROM t_user_menu WHERE id_user = '$getUser[id_user]' AND id_menu = '1'");
					if ($cekUser->num_rows() > 0) {
						redirect('Dashboard');
					} else {
						redirect('Welcome');
					}
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
		$dataLogs = [
			'username' => $this->session->userdata('username'),
			'tanggal' => date("Y-m-d H-i-s"),
			'keterangan' =>  $this->session->userdata('nama_user') . ' logout dari aplikasi'
		];
		$this->db->insert('t_logs', $dataLogs);

		$this->session->sess_destroy();
		redirect('Login');
	}
}
