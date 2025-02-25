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
}
