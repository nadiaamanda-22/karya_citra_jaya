<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;




class Laporandetail_kaca extends CI_Controller
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
        $data['title'] = 'Laporan Detail Invoice Kaca';
        $tgl =  date('Y-m-d');
        $tglawal =  date('Y-m-01');
     
        $this->db->select('t_invoice_detail_kaca.*, t_invoice.tgl_jual, t_customer.nama_customer');
        $this->db->from('t_invoice_detail_kaca');
        $this->db->join('t_invoice', 't_invoice.id_invoice = t_invoice_detail_kaca.id_invoice', 'left');
        $this->db->join('t_customer', 't_customer.id_customer = t_invoice.id_customer', 'left');
        
        $data['laporandetail_kaca'] = $this->db->get()->result();
        $this->template->load('template/template', 'laporan/laporandetail_kaca', $data);
    }

    public function filterData()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $metode_pembayaran = $this->input->post('metode_pembayaran');
        $customer = $this->input->post('customer');
    
        if (empty($tgl_awal)) {
            $tgl_awal = date('Y-m-01'); 
        }
        if (empty($tgl_akhir)) {
            $tgl_akhir = date('Y-m-d');
        }

        $this->db->select('t_invoice_detail_kaca.*, t_invoice.tgl_jual, t_customer.nama_customer');
        $this->db->from('t_invoice_detail_kaca');
        $this->db->join('t_invoice', 't_invoice.id_invoice = t_invoice_detail_kaca.id_invoice', 'left');
        $this->db->join('t_customer', 't_customer.id_customer = t_invoice.id_customer', 'left');
        $this->db->where('t_invoice.tgl_jual >=', $tgl_awal);
        $this->db->where('t_invoice.tgl_jual <=', $tgl_akhir);
    
        if ($metode_pembayaran !== '*') {
            $this->db->where('t_invoice.metode_pembayaran', $metode_pembayaran);
        }
        if ($customer !== '*') {
            $this->db->where('t_invoice.id_customer', $customer);
        }
    
        $data['title'] = 'Laporan Detail Invoice Kaca';
        $data['laporandetail_kaca'] = $this->db->get()->result();
    
        $this->template->load('template/template', 'laporan/laporandetail_kaca', $data);
    }
    

    public function printData()
    {
        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $metode_pembayaran = $this->input->get('metode_pembayaran');
        $customer = $this->input->get('customer');

        $this->db->select('t_invoice_detail_kaca.*, t_invoice.tgl_jual, t_customer.nama_customer');
        $this->db->from('t_invoice_detail_kaca');
        $this->db->join('t_invoice', 't_invoice.id_invoice = t_invoice_detail_kaca.id_invoice', 'left');
        $this->db->join('t_customer', 't_customer.id_customer = t_invoice.id_customer', 'left');
        $this->db->where('t_invoice.tgl_jual >=', $tgl_awal);
        $this->db->where('t_invoice.tgl_jual <=', $tgl_akhir);

        if ($metode_pembayaran !== '*') {
            $this->db->where('t_invoice.metode_pembayaran', $metode_pembayaran);
        }
        if ($customer !== '*') {
            $this->db->where('t_invoice.id_customer', $customer);
        }

        $data['laporandetail_kaca'] = $this->db->get()->result();

        $this->template->load('template/template', 'laporan/laporandetail_kaca', $data);
    }


    public function export()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan data ke spreadsheet
        $sheet->setCellValue('A1', 'No Invoice');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Customer');
        $sheet->setCellValue('D1', 'Subtotal');
        $sheet->setCellValue('E1', 'Diskon');
        $sheet->setCellValue('F1', 'Ongkir');
        $sheet->setCellValue('G1', 'Total');
        $sheet->setCellValue('H1', 'Status Pembayaran');
        $sheet->setCellValue('I1', 'Hutang');
        $sheet->setCellValue('J1', 'Metode Pembayaran');

        // Styling Header (warna abu-abu)
        $styleArray = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D3D3D3'], // Warna abu-abu
            ],
            'font' => [
                'bold' => true, // Membuat teks tebal
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        // Terapkan gaya ke header
        $sheet->getStyle('A1:J1')->applyFromArray($styleArray);
        //get data dari database
        $data = $this->db->query("SELECT t_invoice.*, t_customer.nama_customer FROM t_invoice LEFT JOIN t_customer ON t_customer.id_customer = t_invoice.id_customer")->result_array();

        // Memasukkan data ke dalam sheet
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item['no_invoice']);
            $sheet->setCellValue('B' . $row, $item['tgl_jual']);
            $sheet->setCellValue('C' . $row, $item['nama_customer']);
            $sheet->setCellValue('D' . $row, $item['subtotal']);
            $sheet->setCellValue('E' . $row, $item['diskon_nominal']);
            $sheet->setCellValue('F' . $row, $item['ongkir']);
            $sheet->setCellValue('G' . $row, $item['total']);
            $sheet->setCellValue('H' . $row, $item['status_pembayaran']);
            $sheet->setCellValue('I' . $row, $item['hutang']);
            $sheet->setCellValue('J' . $row, $item['metode_pembayaran']);
            $row++;
        }

        // Simpan sebagai file Excel
        $writer = new Xls($spreadsheet);
        $filename = 'laporan-detail-kaca' . date('Ymd') . '.xls';

        // Bersihkan output buffer sebelum mengirim file
        ob_end_clean();

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$filename");  
        header("Pragma: no-cache");
        header("Expires: 0");

        $writer->save('php://output');
        exit;
    }

}