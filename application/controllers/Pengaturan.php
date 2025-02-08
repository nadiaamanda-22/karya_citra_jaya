<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'Pengaturan';
        $data['customer'] = $this->db->get("t_pengaturan")->result();
        $this->template->load('template/template', 'dashboard/pengaturan', $data);
    }

    public function addView()
    {
        $data['title'] = 'Pengaturan';
        $this->template->load('template/template', 'dashboard/pengaturan', $data);
    }

}