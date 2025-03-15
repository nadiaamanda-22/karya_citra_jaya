<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;


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
        $tgl =  date('Y-m-d');
        $tglawal =  date('Y-m-01');
          
        $this->db->select('t_pembelian_barang.tgl_pembelian, t_pembelian_barang_detail.*, t_supplier.supplier');
        $this->db->from('t_pembelian_barang_detail');
        $this->db->join('t_pembelian_barang', 't_pembelian_barang.no_transaksi = t_pembelian_barang_detail.no_transaksi', 'left');
        $this->db->join('t_supplier', 't_pembelian_barang.id_supplier = t_supplier.id_supplier', 'left'); // JOIN ke supplier
            
        $data['laporandetailpembelian_barang'] = $this->db->get()->result();
        $this->template->load('template/template', 'laporan/laporandetailpembelian_barang', $data);
    }
        
//         echo "<pre>";
// var_dump($data['laporandetailpembelian_barang']);
// echo "</pre>";
// die();

     
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

    $this->db->select('t_pembelian_barang.tgl_pembelian, t_pembelian_barang_detail.*, t_supplier.supplier');
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

    $data['title'] = 'Laporan Detail Pembelian Barang';
    $data['laporandetailpembelian_barang'] = $this->db->get()->result();

    $this->template->load('template/template', 'laporan/laporandetailpembelian_barang', $data);
}

    

    public function printData()
    {
        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $metode_pembayaran = $this->input->get('metode_pembayaran');
        $supplier = $this->input->get('supplier');
  
        $this->db->select('t_pembelian_barang.tgl_pembelian, t_pembelian_barang_detail.*, t_supplier.supplier');
        $this->db->from('t_pembelian_barang_detail');
        $this->db->join('t_pembelian_barang', 't_pembelian_barang.no_transaksi = t_pembelian_barang_detail.no_transaksi', 'left');
        $this->db->join('t_supplier', 't_pembelian_barang.id_supplier = t_supplier.id_supplier', 'left');
            

        if ($metode_pembayaran !== '*') {
            $this->db->where('metode_pembayaran', $metode_pembayaran);
        }

        if ($supplier !== '*') {
            $this->db->where('t_pembelian_barang.id_supplier', $supplier);
        }

        $data['title'] = 'Cetak Laporan Pembelian Barang';
        $data['laporandetailpembelian_barang'] = $this->db->get()->result();

        $this->load->view('laporan/laporandetailpembelian_barang', $data);
    }

    public function exportData()
    {
      
        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $metode_pembayaran = $this->input->get('metode_pembayaran');
        $supplier = $this->input->get('supplier');

        if (empty($tgl_awal)) {
            $tgl_awal = date('Y-m-01'); 
        }
        if (empty($tgl_akhir)) {
            $tgl_akhir = date('Y-m-d');
        }

        $this->db->select('t_pembelian_barang_detail.*, t_pembelian_barang.tgl_pembelian, t_supplier.supplier');
        $this->db->from('t_pembelian_barang_detail');
        $this->db->join('t_pembelian_barang', 't_pembelian_barang.no_transaksi = t_pembelian_barang_detail.no_transaksi', 'left');
        $this->db->join('t_supplier', 't_pembelian_barang.id_supplier = t_supplier.id_supplier', 'left');
        $this->db->where('t_pembelian_barang.tgl_pembelian >=', $tgl_awal);
        $this->db->where('t_pembelian_barang.tgl_pembelian <=', $tgl_akhir);
        
        if ($metode_pembayaran != '*') {
            $this->db->where('t_pembelian_barang.metode_pembayaran', $metode_pembayaran);
        }

        if ($supplier != '*') {
            $this->db->where('t_supplier.id_supplier', $supplier);
        }

        $laporandetailpembelian_barang = $this->db->get()->result();

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
        $sheet->getStyle('A1:G1')->applyFromArray($styleArray);

        $data = $this->db->query("SELECT * FROM t_pembelian_barang detail JOIN t_pembelian_barang ON t_pembelian_barang.id_pembelian = t_pembelian_barang_detail.id_pembelian_detail")->result_array();
        $row = 2;
        foreach ($laporandetailpembelian_barang as $data) {
            $sheet->setCellValue('A' . $row, $data->no_transaksi);
            $sheet->setCellValue('B' . $row, $data->tgl_pembelian);
            $sheet->setCellValue('C' . $row, $data->supplier); 
            $sheet->setCellValue('D' . $row, $data->id_barang);
            $sheet->setCellValue('E' . $row, $data->nama_barang);
            $sheet->setCellValue('F' . $row, $data->stok);
            $sheet->setCellValue('G' . $row, $data->harga_beli);
            $sheet->setCellValue('H' . $row, $data->diskon_persen);
            $sheet->setCellValue('I' . $row, $data->diskon_nominal);
            $sheet->setCellValue('J' . $row, $data->jumlah);
            $row++;
        }

        // Simpan file Excel
        $filename = 'Laporan_Detail_Pembelian_Barang_' . date('Ymd') . '.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    

}

?>