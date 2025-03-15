<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');


use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class Laporandetailpembelian_barang extends CI_Controller
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
        $data['title'] = 'Laporan Detail Pembelian Barang';
        $tgl_awal =  date('Y-m-01');
        $tgl_akhir =  date('Y-m-d');

        $data['laporandetailpembelian_barang'] = $this->db->query("SELECT d.*, b.no_transaksi, b.tgl_pembelian, b.id_supplier FROM t_pembelian_barang_detail AS d JOIN t_pembelian_barang AS b ON b.id_pembelian = d.id_pembelian WHERE b.tgl_pembelian BETWEEN '$tgl_awal' AND '$tgl_akhir'")->result();

        $this->template->load('template/template', 'laporan/laporandetailpembelian_barang', $data);
    }

    public function filterData()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $no_transaksi = $this->input->post('no_transaksi');

        if ($no_transaksi == '*') {
            $nt = "";
        } else {
            $nt = "AND b.id_pembelian = '$no_transaksi'";
        }

        $data['title'] = 'Laporan Detail Pembelian Barang';
        $data['laporandetailpembelian_barang'] = $this->db->query("SELECT d.*, b.no_transaksi, b.tgl_pembelian, b.id_supplier FROM t_pembelian_barang_detail AS d JOIN t_pembelian_barang AS b ON b.id_pembelian = d.id_pembelian WHERE b.tgl_pembelian BETWEEN '$tgl_awal' AND '$tgl_akhir' $nt")->result();

        $this->template->load('template/template', 'laporan/laporandetailpembelian_barang', $data);
    }

    public function exportData()
    {

        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $no_transaksi = $this->input->get('no_transaksi');

        if ($no_transaksi == '*') {
            $nt = "";
        } else {
            $nt = "AND b.id_pembelian = '$no_transaksi'";
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No Transaksi');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Supplier');
        $sheet->setCellValue('D1', 'Kode Barang');
        $sheet->setCellValue('E1', 'Nama Barang');
        $sheet->setCellValue('F1', 'Stok');
        $sheet->setCellValue('G1', 'Harga Beli');
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

        $laporandetailpembelian_barang = $this->db->query("SELECT d.*, b.no_transaksi, b.tgl_pembelian, b.id_supplier FROM t_pembelian_barang_detail AS d JOIN t_pembelian_barang AS b ON b.id_pembelian = d.id_pembelian WHERE b.tgl_pembelian BETWEEN '$tgl_awal' AND '$tgl_akhir' $nt")->result_array();
        $row = 2;
        $diskon = 0;
        $total = 0;
        foreach ($laporandetailpembelian_barang as $data) {
            $diskon += $data['diskon_nominal'];
            $total += $data['jumlah'];

            $supplier = $this->db->query("SELECT supplier FROM t_supplier WHERE id_supplier = ?", [$data['id_supplier']])->row()->supplier;

            $kodeBrg = $this->db->query("SELECT kode_barang FROM t_stok WHERE id = ?", [$data['id_barang']])->row()->kode_barang;

            $sheet->setCellValue('A' . $row, $data['no_transaksi']);
            $sheet->setCellValue('B' . $row, $data['tgl_pembelian']);
            $sheet->setCellValue('C' . $row, $supplier);
            $sheet->setCellValue('D' . $row, $kodeBrg);
            $sheet->setCellValue('E' . $row, $data['nama_barang']);
            $sheet->setCellValue('F' . $row, $data['stok']);
            $sheet->setCellValue('G' . $row, $data['harga_beli']);
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
        $filename = 'Laporan-Detail-Pembelian-Barang.xls';

        // Bersihkan output buffer sebelum mengirim file
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
