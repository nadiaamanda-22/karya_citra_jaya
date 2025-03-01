<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Laporanpembelianbarang extends CI_Controller
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
        $data['title'] = 'Laporan Pembelian Barang';
        $tgl =  date('Y-m-d');
        $data['laporanpembelianbarang'] =  $this->db->query("SELECT * FROM t_pembelian_barang WHERE tgl_pembelian = '$tgl'")->result();
        $this->template->load('template/template', 'laporan/laporanpembelianbarang', $data);
    }

    public function filterData()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $metode_pembayaran = $this->input->post('metode_pembayaran');
        $supplier = $this->input->post('supplier');
       

        if ($metode_pembayaran == '*') {
            $mp = "";
        } else {
            $mp = "AND metode_pembayaran = '$metode_pembayaran'";
        }

        if ($supplier == '*') {
            $s = "";
        } else {
            $s = "AND id_supplier = '$supplier'";
        }

        

        $data['title'] = 'Laporan Pembelian Barang';
        $data['laporanpembelianbarang'] = $this->db->query("SELECT * FROM t_pembelian_barang WHERE tgl_pembelian BETWEEN '$tgl_awal' AND '$tgl_akhir' $mp $s")->result();
        $this->template->load('template/template', 'laporan/laporanpembelianbarang', $data);
    }
}

?>