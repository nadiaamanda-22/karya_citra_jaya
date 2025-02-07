<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Backup extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'Backup & Restore';
        // $data['supplier'] = $this->db->get("t_supplier")->result();
        $this->template->load('template/template', 'dashboard/backup', $data);
    }
}
