<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;


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
        $tgl =  date('Y-m-d');
        $tglawal =  date('Y-m-01');
        $data['laporanpembelianbarang'] = $this->db->where('tgl_pembelian', $tgl);
        $data['laporanpembelianbarang'] = $this->db->get("t_pembelian_barang")->result();
    
        echo "<pre>";
print_r($data['laporanpembelianbarang']);
echo "</pre>";
exit();
        $this->template->load('template/template', 'laporan/laporanpembelianbarang', $data);
    }

    public function filterData()
{
    $tgl_awal = $this->input->post('tgl_awal');
    $tgl_akhir = $this->input->post('tgl_akhir');
    $metode_pembayaran = $this->input->post('metode_pembayaran');
    $supplier = $this->input->post('supplier');

    if (empty($tgl_awal)) {
        $tgl_awal = date('Y-m-01');
    }
    if (empty($tgl_akhir)) {
        $tgl_akhir = date('Y-m-d');
    }

    $this->db->select('
        t_pembelian_barang.tgl_pembelian, 
        t_pembelian_barang.no_transaksi, 
        t_pembelian_barang.metode_pembayaran,
        t_supplier.supplier,
        t_pembelian_barang_detail.*'
    );
    $this->db->from('t_pembelian_barang_detail');
    $this->db->join('t_pembelian_barang', 't_pembelian_barang.no_transaksi = t_pembelian_barang_detail.no_transaksi', 'left');
    $this->db->join('t_supplier', 't_pembelian_barang.id_supplier = t_supplier.id_supplier', 'left');
    $this->db->where('t_pembelian_barang.tgl_pembelian >=', $tgl_awal);
    $this->db->where('t_pembelian_barang.tgl_pembelian <=', $tgl_akhir);

    if ($metode_pembayaran !== '*') {
        $this->db->where('t_pembelian_barang.metode_pembayaran', $metode_pembayaran);
    }

    if ($supplier !== '*') {
        $this->db->where('t_pembelian_barang.id_supplier', $supplier);
    }

    $query = $this->db->get();
    $data['laporandetailpembelian_barang'] = $query->result();

    $query = $this->db->last_query();
    echo "<pre>$query</pre>";
    exit();
    

    $data['title'] = 'Laporan Detail Pembelian Barang';
    $this->template->load('template/template', 'laporan/laporandetailpembelian_barang', $data);
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


    public function exportData()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

   
        $sheet->setCellValue('A1', 'No Transaksi');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Supplier');
        $sheet->setCellValue('D1', 'Metode Pembayaran');
        $sheet->setCellValue('E1', 'Status Pembayaran');
        $sheet->setCellValue('F1', 'Hutang');
        $sheet->setCellValue('H1', 'Total');

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


        $sheet->getStyle('A1:I1')->applyFromArray($styleArray);

        //get data dr database
        $laporanpembelianbarang = $this->db->query("SELECT * FROM t_pembelian_barang")->result_array();
        
        // Masukkan data ke dalam sheet
        $row = 2;
        foreach ($laporanpembelianbarang as $lpb) {
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

        // Simpan sebagai file Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
        $filename = 'laporan_pembelian_barang.xls';

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

?>