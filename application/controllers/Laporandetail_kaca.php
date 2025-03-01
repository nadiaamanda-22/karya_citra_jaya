<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Laporandetail_kaca extends CI_Controller
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
        $data['title'] = 'Laporan Detail Invoice Kaca';
        $tgl =  date('Y-m-d');
        $data['laporandetail_kaca'] = $this->db->get("t_invoice_detail_kaca")->result();
        $this->template->load('template/template', 'laporan/laporandetail_kaca', $data);
    }

    public function filterData()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $metode_pembayaran = $this->input->post('metode_pembayaran');
        $customer = $this->input->post('customer');
   
        if (empty($tgl_awal)) {
            $tgl_awal = date('Y-m-01'); 
        }
        if (empty($tgl_akhir)) {
            $tgl_akhir = date('Y-m-d');
        }

        $this->db->select('*');
        $this->db->from('t_invoice_detail_kaca');
        $this->db->where('tgl_jual >=', $tgl_awal);
        $this->db->where('tgl_jual <=', $tgl_akhir);

        if ($metode_pembayaran !== '*') {
            $this->db->where('metode_pembayaran', $metode_pembayaran);
        }

        if ($customer !== '*') {
            $this->db->where('id_customer', $customer);
        }

        $data['title'] = 'Laporan Detail Invoice Kaca';
        $data['laporandetail_kaca'] = $this->db->get()->result();

        $this->template->load('template/template', 'laporan/laporandetail_kaca', $data);
    }

}

?>