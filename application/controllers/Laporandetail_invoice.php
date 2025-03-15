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
        $tgl_awal =  date('Y-m-01');
        $tgl_akhir =  date('Y-m-d');

        $data['laporandetail_invoice'] = $this->db->query("SELECT d.*, i.no_invoice, i.tgl_jual, i.id_customer FROM t_invoice_detail AS d JOIN t_invoice AS i ON i.id_invoice = d.id_invoice WHERE i.jenis_invoice='0' AND i.tgl_jual BETWEEN '$tgl_awal' AND '$tgl_akhir'")->result();

        $this->template->load('template/template', 'laporan/laporandetail_invoice', $data);
    }


    public function filterData()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $no_invoice = $this->input->post('no_invoice');

        if ($no_invoice == '*') {
            $nt = "";
        } else {
            $nt = "AND i.id_invoice = '$no_invoice'";
        }

        $data['title'] = 'Laporan Detail Invoice';
        $data['laporandetail_invoice'] = $this->db->query("SELECT d.*, i.no_invoice, i.tgl_jual, i.id_customer FROM t_invoice_detail AS d JOIN t_invoice AS i ON i.id_invoice = d.id_invoice WHERE i.jenis_invoice='0' AND i.tgl_jual BETWEEN '$tgl_awal' AND '$tgl_akhir' $nt")->result();

        $this->template->load('template/template', 'laporan/laporandetail_invoice', $data);
    }

    public function export()
    {
        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $no_invoice = $this->input->get('no_invoice');

        if ($no_invoice == '*') {
            $nt = "";
        } else {
            $nt = "AND i.id_invoice = '$no_invoice'";
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan data ke spreadsheet
        $sheet->setCellValue('A1', 'No Invoice');
        $sheet->setCellValue('B1', 'Tanggal Jual');
        $sheet->setCellValue('C1', 'Customer');
        $sheet->setCellValue('D1', 'Kode Barang');
        $sheet->setCellValue('E1', 'Nama Barang');
        $sheet->setCellValue('F1', 'Stok');
        $sheet->setCellValue('G1', 'Harga Jual');
        $sheet->setCellValue('H1', 'Diskon (%)');
        $sheet->setCellValue('I1', 'Diskon');
        $sheet->setCellValue('J1', 'Jumlah');

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
        $data = $this->db->query("SELECT d.*, i.no_invoice, i.tgl_jual, i.id_customer FROM t_invoice_detail AS d JOIN t_invoice AS i ON i.id_invoice = d.id_invoice WHERE i.jenis_invoice='0' AND i.tgl_jual BETWEEN '$tgl_awal' AND '$tgl_akhir' $nt")->result_array();

        // Memasukkan data ke dalam sheet
        $row = 2;
        $diskon = 0;
        $total = 0;
        foreach ($data as $data) {
            $diskon += $data['diskon_nominal'];
            $total += $data['jumlah'];

            $customer = $this->db->query("SELECT nama_customer FROM t_customer WHERE id_customer = ?", [$data['id_customer']])->row()->nama_customer;

            $kodeBrg = $this->db->query("SELECT kode_barang FROM t_stok WHERE id = ?", [$data['id_barang']])->row()->kode_barang;

            $sheet->setCellValue('A' . $row, $data['no_invoice']);
            $sheet->setCellValue('B' . $row, $data['tgl_jual']);
            $sheet->setCellValue('C' . $row, $customer);
            $sheet->setCellValue('D' . $row, $kodeBrg);
            $sheet->setCellValue('E' . $row, $data['nama_barang']);
            $sheet->setCellValue('F' . $row, $data['stok']);
            $sheet->setCellValue('G' . $row, $data['harga_jual']);
            $sheet->setCellValue('H' . $row, $data['diskon_persen']);
            $sheet->setCellValue('I' . $row, $data['diskon_nominal']);
            $sheet->setCellValue('J' . $row, $data['jumlah']);
            $row++;
        }
        // Total
        $sheet->mergeCells("A$row:H$row");
        $sheet->setCellValue("A$row", "Total");
        $sheet->setCellValue("I$row", ($diskon));
        $sheet->setCellValue("J$row", ($total));

        $sheet->getStyle("A$row:J$row")->getFont()->setBold(true);
        $sheet->getStyle("A$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Simpan file Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
        $filename = 'laporan-detail-invoice.xls';

        ob_end_clean();

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");

        $writer->save('php://output');
        exit;
    }
}
