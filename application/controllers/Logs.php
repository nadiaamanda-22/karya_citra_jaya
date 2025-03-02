<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logs extends CI_Controller
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
        $data['title'] = 'Logs';
        $data['data'] = $this->db->get('t_logs')->result();
        $this->template->load('template/template', 'dashboard/logs', $data);
    }

    public function filterData()
    {
        $filterBulan = $this->input->post('filterBulan');
        $filterTahun = $this->input->post('filterTahun');

        if ($filterBulan == '*') {
            $bl = "";
        } else {
            $bl = $filterBulan;
        }

        if ($filterTahun == '*') {
            $th = "";
        } else {
            $th = $filterTahun;
        }

        $data['title'] = 'Logs';
        $data['data'] = $this->db->query("SELECT * FROM t_logs WHERE tanggal LIKE '%$th-$bl%'")->result();
        $this->template->load('template/template', 'dashboard/logs', $data);
    }
}
