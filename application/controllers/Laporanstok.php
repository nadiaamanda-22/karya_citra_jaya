<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Laporanstok extends CI_Controller
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
        $data['title'] = 'Laporan Stok';
        $data['laporanstok'] = $this->db->select('*')->from('t_stok')->join('t_kelompok_barang', 't_stok.id_kelompok = t_kelompok_barang.id_kelompok')->get()->result();
        $this->template->load('template/template', 'laporan/laporanstok', $data);
    }
    public function filterData()
    {
        $data['title'] = 'Laporan Stok';
        $id_kelompok = $this->input->post('id_kelompok');

        $this->db->select('*');
        $this->db->from('t_stok');
        $this->db->join('t_kelompok_barang', 't_stok.id_kelompok = t_kelompok_barang.id_kelompok');

        if ($id_kelompok !== '*') {
            $this->db->where('t_stok.id_kelompok', $id_kelompok);
        }

        $data['laporanstok'] = $this->db->get()->result();
        $this->template->load('template/template', 'laporan/laporanstok', $data);
    }

    public function export()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan data ke spreadsheet
        $sheet->setCellValue('A1', 'Kode Barang');
        $sheet->setCellValue('B1', 'Nama Barang');
        $sheet->setCellValue('C1', 'Kelompok Barang');
        $sheet->setCellValue('D1', 'Jumlah Stok');
        $sheet->setCellValue('E1', 'Harga Beli');
        $sheet->setCellValue('F1', 'Harga Permeter');
        $sheet->setCellValue('G1', 'Harga jual');

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
        $sheet->getStyle('A1:G1')->applyFromArray($styleArray);

        //get data dari database
        $filterKelompok = $this->uri->segment(3);
        if ($filterKelompok == '') {
            $fk = '';
        } else {
            $fk = "WHERE t_kelompok_barang.id_kelompok = '$filterKelompok'";
        }
        $data = $this->db->query("SELECT * FROM t_stok JOIN t_kelompok_barang ON t_kelompok_barang.id_kelompok = t_stok.id_kelompok $fk")->result_array();

        // Memasukkan data ke dalam sheet
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item['kode_barang']);
            $sheet->setCellValue('B' . $row, $item['nama_barang']);
            $sheet->setCellValue('C' . $row, $item['nama_kelompok']);
            $sheet->setCellValue('D' . $row, $item['stok'] . ' ' . $item['satuan']);
            $sheet->setCellValue('E' . $row, $item['harga_beli']);
            $sheet->setCellValue('F' . $row, $item['harga_permeter']);
            $sheet->setCellValue('G' . $row, $item['harga_jual']);
            $row++;
        }

        // Simpan sebagai file Excel
        $writer = new Xls($spreadsheet);
        $filename = 'data_export.xlsx';

        // Bersihkan output buffer sebelum mengirim file
        ob_end_clean();

        // Set header agar file terunduh sebagai Excel
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=laporan-stok.xls"); //ganti nama sesuai keperluan
        header("Pragma: no-cache");
        header("Expires: 0");

        $writer->save('php://output');
        exit;
    }
}
