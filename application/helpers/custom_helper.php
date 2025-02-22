<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('formatPrice')) {
    function formatPrice($price)
    {
        $CI = &get_instance();
        $CI->load->database();
        $getSetting = $CI->db->query("SELECT * FROM t_pengaturan")->row();
        $formatPrice = isset($getSetting->format_price) ? $getSetting->format_price : 0;

        if ($formatPrice == 0) {
            return number_format($price, 0, ',', '.');
        } else {
            return number_format($price, 2, ',', '.');
        }
    }
}
