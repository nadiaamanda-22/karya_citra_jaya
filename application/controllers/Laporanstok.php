<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporanstok extends CI_Controller
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
        $data['title'] = 'Laporan Stok';
        $data['laporanstok'] = $this->db->select('*')->from('t_stok')->join('t_kelompok_barang', 't_stok.id_kelompok = t_kelompok_barang.id_kelompok')->get()->result();
        $this->template->load('template/template', 'laporan/laporanstok', $data);
    }
    public function filterData()
    {
        $id_kelompok = $this->input->post('id_kelompok');
        $stok = $this->input->post('stok');
    
        $data['title'] = 'Laporan Stok';
        
        $this->db->select('*');
        $this->db->from('t_stok');
        $this->db->join('t_kelompok_barang', 't_stok.id_kelompok = t_kelompok_barang.id_kelompok');
    
    
        if ($id_kelompok !== '*') {
            $this->db->where('t_stok.id_kelompok', $id_kelompok);
        }
    
        if ($stok !== '*') {
            $this->db->where('t_stok.stok', $stok);
        }
    
        $data['laporanstok'] = $this->db->get()->result();
    
        $this->template->load('template/template', 'laporan/laporanstok', $data);
    }

}

?>