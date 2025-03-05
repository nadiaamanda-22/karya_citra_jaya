<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Laporandetail_invoice extends CI_Controller
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
        $data['title'] = 'Laporan Detail Invoice';
        $tgl = date('Y-m-d');
        $tglawal =  date('Y-m-01');
        $data['laporandetail_invoice'] = $this->db->select('*')->from('t_invoice_detail')->join('t_invoice', 't_invoice_detail.id_invoice = t_invoice.id_invoice')->where('tgl_jual', $tgl)->get()->result();
        $this->template->load('template/template', 'laporan/laporandetail_invoice', $data);
    }

    public function filterData()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $metode_pembayaran = $this->input->post('metode_pembayaran');
        $customer = $this->input->post('customer');
        $jenis_invoice = $this->input->post('jenis_invoice');

        $query = "SELECT * FROM t_invoice_detail JOIN t_invoice ON t_invoice_detail.id_invoice = t_invoice.id_invoice 
                  WHERE tgl_jual BETWEEN '$tgl_awal' AND '$tgl_akhir'";

        if ($metode_pembayaran != '*') {
            $query .= " AND metode_pembayaran = '$metode_pembayaran'";
        }
        if ($customer != '*') {
            $query .= " AND id_customer = '$customer'";
        }
        if ($jenis_invoice != '*') {
            $query .= " AND jenis_invoice = '$jenis_invoice'";
        }

        $data['title'] = 'Laporan Detail Invoice';
        $data['laporandetail_invoice'] = $this->db->query($query)->result();
        $this->template->load('template/template', 'laporan/laporandetail_invoice', $data);
    }
}
?>
