<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Laporandetail_invoice extends CI_Controller
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
        $data['title'] = 'Laporan Detail Invoice';
        $tgl = date('Y-m-d');
    
        $data['laporandetail_invoice'] = $this->db->select('t_invoice_detail.*, t_invoice.*, t_customer.nama_customer')
            ->from('t_invoice_detail')
            ->join('t_invoice', 't_invoice_detail.id_invoice = t_invoice.id_invoice', 'left')
            ->join('t_customer', 't_invoice.id_customer = t_customer.id_customer', 'left')
            ->get()
            ->result();
    
        $this->template->load('template/template', 'laporan/laporandetail_invoice', $data);
    }
    

    public function filterData()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $metode_pembayaran = $this->input->post('metode_pembayaran');
        $customer = $this->input->post('customer');
        $jenis_invoice = $this->input->post('jenis_invoice');
    
        $this->db->select('t_invoice_detail.*, t_invoice.*, t_customer.nama_customer');
        $this->db->from('t_invoice_detail');
        $this->db->join('t_invoice', 't_invoice_detail.id_invoice = t_invoice.id_invoice', 'left');
        $this->db->join('t_customer', 't_invoice.id_customer = t_customer.id_customer', 'left');
        $this->db->where('tgl_jual >=', $tgl_awal);
        $this->db->where('tgl_jual <=', $tgl_akhir);
    
        if ($metode_pembayaran != '*') {
            $this->db->where('t_invoice.metode_pembayaran', $metode_pembayaran);
        }
        if ($customer != '*') {
            $this->db->where('t_invoice.id_customer', $customer);
        }
        if ($jenis_invoice != '*') {
            $this->db->where('t_invoice.jenis_invoice', $jenis_invoice);
        }
    
        $data['title'] = 'Laporan Detail Invoice';
        $data['laporandetail_invoice'] = $this->db->get()->result();
    
        $this->template->load('template/template', 'laporan/laporandetail_invoice', $data);
    }
    
    
    public function printData()
    {
        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $metode_pembayaran = $this->input->get('metode_pembayaran');
        $supplier = $this->input->get('supplier');

        $mp = ($metode_pembayaran == '*') ? "" : "AND metode_pembayaran = '$metode_pembayaran'";
        $s = ($supplier == '*') ? "" : "AND id_supplier = '$supplier'";

        $data['laporanpembelianbarang'] = $this->db->query("SELECT * FROM t_pembelian_barang WHERE tgl_pembelian BETWEEN '$tgl_awal' AND '$tgl_akhir' $mp $s")->result();
        $data['title'] = 'Cetak Laporan Pembelian Barang';


        $this->load->view('laporan/laporanpembelianbarang', $data);
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
        $data = $this->db->query("SELECT t_invoice.*, t_customer.nama_customer, SUM(t_invoice_detail.diskon_nominal) AS diskon_nominal FROM t_invoice LEFT JOIN t_customer ON t_customer.id_customer = t_invoice.id_customer LEFT JOIN t_invoice_detail ON t_invoice.id_invoice = t_invoice_detail.id_invoice
                                    GROUP BY t_invoice.id_invoice")->result_array();

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

        $writer = new Xls($spreadsheet);
        $filename = 'laporan-penjualan-' . date('Ymd') . '.xls';

        
        ob_end_clean();

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$filename");   
        header("Pragma: no-cache");
        header("Expires: 0");

        $writer->save('php://output');
        exit;
    }


}
?>
