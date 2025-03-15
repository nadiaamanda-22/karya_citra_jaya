<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');


use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class Laporanpenjualan extends CI_Controller
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
        $data['title'] = 'Laporan Penjualan';
        $tgl_awal =  date('Y-m-01');
        $tgl_akhir =  date('Y-m-d');

        $data['laporanpenjualan'] =  $this->db->query("SELECT * FROM t_invoice WHERE tgl_jual BETWEEN '$tgl_awal' AND '$tgl_akhir'")->result();

        $this->template->load('template/template', 'laporan/laporanpenjualan', $data);
    }
    public function filterData()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $metode_pembayaran = $this->input->post('metode_pembayaran');
        $status_pembayaran = $this->input->post('status_pembayaran');
        $customer = $this->input->post('customer');
        $jenis_invoice = $this->input->post('jenis_invoice');

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

        if ($customer == '*') {
            $cs = "";
        } else {
            $cs = "AND id_customer = '$customer'";
        }


        if ($jenis_invoice == '*') {
            $ji = "";
        } else {
            $ji = "AND jenis_invoice = '$jenis_invoice'";
        }

        $data['title'] = 'Laporan Penjualan';
        $data['laporanpenjualan'] = $this->db->query("SELECT * FROM t_invoice WHERE tgl_jual BETWEEN '$tgl_awal' AND '$tgl_akhir' $mp $sp $ji $cs")->result();
        $this->template->load('template/template', 'laporan/laporanpenjualan', $data);
    }

    public function export()
    {

        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $metode_pembayaran = $this->input->get('metode_pembayaran');
        $status_pembayaran = $this->input->get('status_pembayaran');
        $customer = $this->input->get('customer');
        $jenis_invoice = $this->input->get('jenis_invoice');

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

        if ($customer == '*') {
            $cs = "";
        } else {
            $cs = "AND id_customer = '$customer'";
        }


        if ($jenis_invoice == '*') {
            $ji = "";
        } else {
            $ji = "AND jenis_invoice = '$jenis_invoice'";
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan data ke spreadsheet
        $sheet->setCellValue('A1', 'No Invoice');
        $sheet->setCellValue('B1', 'Jenis Invoice');
        $sheet->setCellValue('C1', 'Tanggal Jual');
        $sheet->setCellValue('D1', 'Customer');
        $sheet->setCellValue('E1', 'Metode Pembayaran');
        $sheet->setCellValue('F1', 'Status Pembayaran');
        $sheet->setCellValue('G1', 'Hutang');
        $sheet->setCellValue('H1', 'Subtotal');
        $sheet->setCellValue('I1', 'Ongkir');
        $sheet->setCellValue('J1', 'Total');

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
        $data = $this->db->query("SELECT * FROM t_invoice WHERE tgl_jual BETWEEN '$tgl_awal' AND '$tgl_akhir' $mp $sp $ji $cs")->result_array();

        // Memasukkan data ke dalam sheet
        $row = 2;
        $totalHutang = 0;
        $subtotal = 0;
        $ongkir = 0;
        $total = 0;
        foreach ($data as $item) {
            $totalHutang += $item['hutang'];
            $subtotal += $item['subtotal'];
            $ongkir += $item['ongkir'];
            $total += $item['total'];

            $customer = $this->db->query("SELECT nama_customer FROM t_customer WHERE id_customer = ?", [$item['id_customer']])->row()->nama_customer;

            if ($item['jenis_invoice'] == "0") {
                $jenisInvoice = "Invoice Biasa";
            } else {
                $jenisInvoice = "Invoice Kaca";
            }

            $sheet->setCellValue('A' . $row, $item['no_invoice']);
            $sheet->setCellValue('B' . $row, $jenisInvoice);
            $sheet->setCellValue('C' . $row, $item['tgl_jual']);
            $sheet->setCellValue('D' . $row, $customer);
            $sheet->setCellValue('E' . $row, $item['metode_pembayaran']);
            $sheet->setCellValue('F' . $row, $item['status_pembayaran']);
            $sheet->setCellValue('G' . $row, $item['hutang']);
            $sheet->setCellValue('H' . $row, $item['subtotal']);
            $sheet->setCellValue('I' . $row, $item['ongkir']);
            $sheet->setCellValue('J' . $row, $item['total']);
            $row++;
        }

        // Total
        $sheet->mergeCells("A$row:F$row");
        $sheet->setCellValue("A$row", "Total");
        $sheet->setCellValue("G$row", ($totalHutang));
        $sheet->setCellValue("H$row", ($subtotal));
        $sheet->setCellValue("I$row", ($ongkir));
        $sheet->setCellValue("J$row", ($total));

        $sheet->getStyle("A$row:G$row")->getFont()->setBold(true);
        $sheet->getStyle("A$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Simpan sebagai file Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
        $filename = 'laporan-penjualan.xls';

        ob_end_clean();

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");

        $writer->save('php://output');
        exit;
    }
}
