<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Backup extends CI_Controller
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
        $data['title'] = 'Backup & Restore';
        $this->template->load('template/template', 'dashboard/backup', $data);
    }

    public function backupProses()
    {
        $this->load->dbutil();
        $prefs = array(
            'format'      => 'zip',
            'filename'    => 'db_karya_citra_jaya-' . date("Y-m-d_H-i-s") . '.sql'
        );
        $backup = $this->dbutil->backup($prefs);
        $db_name = 'db_karya_citra_jaya-' . date("Y-m-d_H-i-s") . '.zip';

        $dataLogs = [
            'username' => $this->session->userdata('username'),
            'tanggal' => date("Y-m-d_H-i-s"),
            'keterangan' => 'melakukan backup database'
        ];
        $this->db->insert('t_logs', $dataLogs);

        $this->load->helper('download');
        force_download($db_name, $backup);
    }
}
