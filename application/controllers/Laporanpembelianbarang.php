<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');


use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class Laporanpembelianbarang extends CI_Controller
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
        $data['title'] = 'Laporan Pembelian Barang';
        $tgl_awal =  date('Y-m-01');
        $tgl_akhir =  date('Y-m-d');
        $data['laporanpembelianbarang'] =  $this->db->query("SELECT * FROM t_pembelian_barang WHERE tgl_pembelian BETWEEN '$tgl_awal' AND '$tgl_akhir'")->result();

        $this->template->load('template/template', 'laporan/laporanpembelianbarang', $data);
    }

    public function filterData()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $metode_pembayaran = $this->input->post('metode_pembayaran');
        $status_pembayaran = $this->input->post('status_pembayaran');
        $supplier = $this->input->post('supplier');

        if ($metode_pembayaran == '*') {
            $mp = "";
        } else {
            $mp = "AND metode_pembayaran = '$metode_pembayaran'";
        }

        if ($status_pembayaran == '*') {
            $sp = "";
        } else {
            $sp = "AND status_pembayaran = '$status_pembayaran'";
        }

        if ($supplier == '*') {
            $spp = "";
        } else {
            $spp = "AND id_supplier = '$supplier'";
        }

        $data['title'] = 'Laporan Pembelian Barang';
        $data['laporanpembelianbarang'] = $this->db->query("SELECT * FROM t_pembelian_barang WHERE tgl_pembelian BETWEEN '$tgl_awal' AND '$tgl_akhir' $mp $sp $spp")->result();
        $this->template->load('template/template', 'laporan/laporanpembelianbarang', $data);
    }

    public function exportData()
    {

        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $metode_pembayaran = $this->input->get('metode_pembayaran');
        $status_pembayaran = $this->input->get('status_pembayaran');
        $supplier = $this->input->get('supplier');

        if ($metode_pembayaran == '*') {
            $mp = "";
        } else {
            $mp = "AND metode_pembayaran = '$metode_pembayaran'";
        }

        if ($status_pembayaran == '*') {
            $sp = "";
        } else {
            $sp = "AND status_pembayaran = '$status_pembayaran'";
        }

        if ($supplier == '*') {
            $spp = "";
        } else {
            $spp = "AND id_supplier = '$supplier'";
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No Transaksi');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Supplier');
        $sheet->setCellValue('D1', 'Metode Pembayaran');
        $sheet->setCellValue('E1', 'Status Pembayaran');
        $sheet->setCellValue('F1', 'Hutang');
        $sheet->setCellValue('G1', 'Total');

        // Styling Header (warna abu-abu)
        $styleArray = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D3D3D3'],
            ],
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];


        $sheet->getStyle('A1:G1')->applyFromArray($styleArray);

        //get data dr database
        $laporanpembelianbarang = $this->db->query("SELECT * FROM t_pembelian_barang WHERE tgl_pembelian BETWEEN '$tgl_awal' AND '$tgl_akhir' $mp $sp $spp")->result_array();

        // Masukkan data ke dalam sheet
        $row = 2;
        $totalHutang = 0;
        $total = 0;
        foreach ($laporanpembelianbarang as $lpb) {

            $totalHutang += $lpb['hutang'];
            $total += $lpb['total'];

            $supplier = $this->db->query("SELECT supplier FROM t_supplier WHERE id_supplier = ?", [$lpb['id_supplier']])->row()->supplier;
            $sheet->setCellValue('A' . $row, $lpb['no_transaksi']);
            $sheet->setCellValue('B' . $row, $lpb['tgl_pembelian']);
            $sheet->setCellValue('C' . $row, $supplier);
            $sheet->setCellValue('D' . $row, $lpb['metode_pembayaran']);
            $sheet->setCellValue('E' . $row, $lpb['status_pembayaran']);
            $sheet->setCellValue('F' . $row, $lpb['hutang']);
            $sheet->setCellValue('G' . $row, $lpb['total']);
            $row++;
        }

        // Total
        $sheet->mergeCells("A$row:E$row"); // Merge A-E sebagai keterangan total
        $sheet->setCellValue("A$row", "Total");
        $sheet->setCellValue("F$row", ($totalHutang));
        $sheet->setCellValue("G$row", ($total));

        $sheet->getStyle("A$row:G$row")->getFont()->setBold(true);
        $sheet->getStyle("A$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Simpan sebagai file Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
        $filename = 'laporan-pembelian-barang.xls';

        // Bersihkan output buffer sebelum mengirim file
        ob_end_clean();

        // Header agar file terunduh sebagai Excel
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");

        $writer->save('php://output');
        exit;
    }
}
