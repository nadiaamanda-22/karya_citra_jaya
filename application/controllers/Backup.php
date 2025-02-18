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
        $db_name = 'db_karya_citra_jaya-' . date("Y-m-d_H-i-s") . '.sql';

        $dataLogs = [
            'username' => $this->session->userdata('username'),
            'tanggal' => date("Y-m-d_H-i-s"),
            'keterangan' => 'melakukan backup database'
        ];
        $this->db->insert('t_logs', $dataLogs);

        $this->load->helper('download');
        force_download($db_name, $backup);
    }

    public function restoreProses()
    {
        if (!empty($_FILES['database']['name'])) {
            $file_tmp = $_FILES['database']['tmp_name']; // Path sementara
            $file_name = $_FILES['database']['name'];

            // cek extension, harus sql
            if (pathinfo($file_name, PATHINFO_EXTENSION) !== 'sql') {
                $this->session->set_flashdata('message', 'formatted');
                redirect('backup');
            }

            // Baca isi file
            $isi_file = file_get_contents($file_tmp);
            $array_query = preg_split('/;\s*\n/', $isi_file);

            // Jalankan query satu per satu
            foreach ($array_query as $query) {

                if (!empty($query)) {
                    $this->db->query($query);
                    redirect('backup');
                    // if (!$this->db->query($query)) {
                    //     echo $this->db->error();
                    // }

                    // echo "<pre>$query</pre>";


                    // $dataLogs = [
                    //     'username' => $this->session->userdata('username'),
                    //     'tanggal' => date("Y-m-d_H-i-s"),
                    //     'keterangan' => 'melakukan restore database'
                    // ];
                    // $this->db->insert('t_logs', $dataLogs);

                    // $this->session->set_flashdata('message', 'berhasil');
                    // redirect('backup');
                } else {
                    $this->session->set_flashdata('message', 'gagal');
                    redirect('backup');
                }
            }
        } else {
            $this->session->set_flashdata('message', 'null');
            redirect('backup');
        }
    }
}
