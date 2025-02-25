<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
		$data['title'] = 'Dashboard';
		$date = date("Y-m");
		$data['pembelian'] = $this->db->query("SELECT SUM(total) AS total_pembelian FROM t_pembelian_barang WHERE tgl_pembelian LIKE '%$date%'")->row();
		$data['hutang_toko'] = $this->db->query("SELECT SUM(hutang) AS hutang_toko FROM t_pembelian_barang WHERE tgl_pembelian LIKE '%$date%'")->row();
		// $data['penjualan'] = $this->db->query("SELECT SUM(total) AS total_penjualan FROM t_invoice WHERE tgl_jual LIKE '%$date%'")->row();
		// $data['hutang_customer'] = $this->db->query("SELECT SUM(hutang) AS hutang_toko FROM t_invoice WHERE tgl_jual LIKE '%$date%'")->row();
		$this->template->load('template/template', 'dashboard/dashboard', $data);
	}
}
