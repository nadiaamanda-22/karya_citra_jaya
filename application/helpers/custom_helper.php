<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('formatPrice')) {
    function formatPrice($price)
    {
        $CI = &get_instance();
        $CI->load->database();
        return number_format($price, 0, ',', '.');
    }

    function formatTanggal($date)
    {
        $bulan = [
            "01" => "Januari",
            "02" => "Februari",
            "03" => "Maret",
            "04" => "April",
            "05" => "Mei",
            "06" => "Juni",
            "07" => "Juli",
            "08" => "Agustus",
            "09" => "September",
            "10" => "Oktober",
            "11" => "November",
            "12" => "Desember"
        ];

        $bagian = explode("-", $date);
        return $bagian[2] . " " . $bulan[$bagian[1]] . " " . $bagian[0];
    }

    function getNamaBulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }

    function dataTahun()
    {
        $ci = &get_instance();
        $ci->load->database();

        $query = $ci->db->query("
            SELECT YEAR(tanggal) AS year 
            FROM t_logs 
            WHERE tanggal <> '0000-00-00' 
            GROUP BY YEAR(tanggal) 
            ORDER BY YEAR(tanggal) DESC
        ");

        return $query->result_array();
    }
}
