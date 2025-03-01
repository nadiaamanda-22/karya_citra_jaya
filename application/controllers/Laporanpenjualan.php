<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Laporanpenjualan extends CI_Controller
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
        $data['title'] = 'Laporan Penjualan';
        $tgl =  date('Y-m-d');
        $data['laporanpenjualan'] =  $this->db->query("SELECT * FROM t_invoice WHERE tgl_jual = '$tgl'")->result();
        $this->template->load('template/template', 'laporan/laporanpenjualan', $data);
    }

    public function filterData()
{
    $tgl_awal = $this->input->post('tgl_awal');
    $tgl_akhir = $this->input->post('tgl_akhir');
    $metode_pembayaran = $this->input->post('metode_pembayaran');
    $customer = $this->input->post('customer');
    $jenis_invoice = $this->input->post('jenis_invoice');

    if (empty($tgl_awal)) {
        $tgl_awal = date('Y-m-01'); 
    }
    if (empty($tgl_akhir)) {
        $tgl_akhir = date('Y-m-d'); 
    }

    $this->db->select('*');
    $this->db->from('t_invoice');
    $this->db->where('tgl_jual >=', $tgl_awal);
    $this->db->where('tgl_jual <=', $tgl_akhir);

    if ($metode_pembayaran !== '*') {
        $this->db->where('metode_pembayaran', $metode_pembayaran);
    }

    if ($customer !== '*') {
        $this->db->where('id_customer', $customer);
    }

    if ($jenis_invoice !== '*') {
        $this->db->where('jenis_invoice', $jenis_invoice);
    }

    $data['title'] = 'Laporan Penjualan';
    $data['laporanpenjualan'] = $this->db->get()->result();

    $this->template->load('template/template', 'laporan/laporanpenjualan', $data);
}

}

?>