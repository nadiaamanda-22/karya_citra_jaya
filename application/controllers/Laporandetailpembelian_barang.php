<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Laporandetailpembelian_barang extends CI_Controller
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
        $data['title'] = 'Laporan Detail Pembelian Barang';
        $tgl =  date('Y-m-d');
        $data['laporandetailpembelian_barang'] = $this->db->get("t_pembelian_barang_detail")->result();
        $this->template->load('template/template', 'laporan/laporandetailpembelian_barang', $data);
        
    }

    public function filterData()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $metode_pembayaran = $this->input->post('metode_pembayaran');
        $supplier = $this->input->post('supplier');
    
        if (empty($tgl_awal)) {
            $tgl_awal = date('Y-m-01'); 
        }
        if (empty($tgl_akhir)) {
            $tgl_akhir = date('Y-m-d');
        }
    
        $this->db->select('*');
        $this->db->from('t_pembelian_barang_detail'); 
        $this->db->where('tgl_pembelian >=', $tgl_awal); 
        $this->db->where('tgl_pembelian <=', $tgl_akhir);
    
        if ($metode_pembayaran !== '*') {
            $this->db->where('metode_pembayaran', $metode_pembayaran);
        }
    
        if ($supplier !== '*') {
            $this->db->where('id_supplier', $supplier);
        }
    
        $data['title'] = 'Laporan Detail Pembelian Barang';
        $data['laporandetailpembelian_barang'] = $this->db->get()->result();
    
        $this->template->load('template/template', 'laporan/laporandetailpembelian_barang', $data);
    }
    

}

?>