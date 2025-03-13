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
        $this->load->dbutil();
        $prefs = array(
            'format'      => 'zip',
            'filename'    => 'db_karya_citra_jaya-' . date("Y-m-d_H-i-s") . '.sql'
        );
        $backup = $this->dbutil->backup($prefs);
        $db_name = 'db_karya_citra_jaya-' . date("Y-m-d_H-i-s") . '.sql';

        $this->load->helper('download');
        force_download($db_name, $backup);
    }
}
