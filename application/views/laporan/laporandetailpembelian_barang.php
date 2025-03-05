<?php
$dateNow = date('Y-m-d');
$tglawal = date('Y-m-01');
$tgl_awal = !empty($_REQUEST['tgl_awal']) ? $_REQUEST['tgl_awal'] : $tglawal;
$tgl_akhir = !empty($_REQUEST['tgl_akhir']) ? $_REQUEST['tgl_akhir'] : $dateNow;
$metode_pembayaran = !empty($_REQUEST['metode_pembayaran']) ? $_REQUEST['metode_pembayaran'] : '*';
$supplier = !empty($_REQUEST['supplier']) ? $_REQUEST['supplier'] : '*';
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="row g-3 pt-3" action="<?= base_url('Laporandetailpembelian_barang/filterData') ?>" method="post">
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" value="<?= $tgl_awal ?>">
                </div>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="tgl_akhir" value="<?= $tgl_akhir ?>">
                </div>
                <div class="col-sm-3">
                    <select id="metode_pembayaran" name="metode_pembayaran" class="form-select">
                        <option value="*" <?= $metode_pembayaran == '*' ? 'selected' : '' ?>>Semua Pembayaran</option>
                        <option value="tunai" <?= $metode_pembayaran == 'tunai' ? 'selected' : '' ?>>Tunai</option>
                        <option value="nontunai" <?= $metode_pembayaran == 'nontunai' ? 'selected' : '' ?>>Non Tunai</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select id="supplier" name="supplier" class="form-select">
                        <option value="*" <?= $supplier == '*' ? 'selected' : '' ?>>Semua Supplier</option>
                        <?php
                        $getSupplier = $this->db->query("SELECT * FROM t_supplier")->result();
                        foreach ($getSupplier as $gs) { ?>
                            <option value="<?= $gs->id_supplier ?>" <?= $supplier == $gs->id_supplier ? 'selected' : '' ?>>
                                <?= htmlspecialchars($gs->supplier) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-success" type="submit">Tampilkan</button>
                </div>
            </form>
                
                <div class="mt-4">
                    <a href="<?= base_url('Laporanpembelianbarang/printData') ?>?tgl_awal=<?= $tgl_awal ?>&tgl_akhir=<?= $tgl_akhir ?>&metode_pembayaran=<?= $metode_pembayaran ?>&supplier=<?= $supplier ?>" 
                    class="btn btn-primary" 
                    target="_blank">
                    Print
                    </a>
                </div>
                <div class="mt-4">
                    <a class="btn btn-primary" onclick="printLaporan()">Print</a>
                    <a class="btn btn-success">Export</a>
                </div>
                
             <div class="table-responsive mt-4">
                 <table class="table table-bordered" id="dataTable-data" width="100%">
                     <thead>
                         <tr>
                             <td width="14%" style="text-align: center;">No Transaksi </td>
                             <td width="12%" style="text-align: center;">Tanggal</td>
                             <td width="12"  style="text-align: center;">Supplier</td>
                             <td width="8"  style="text-align: center;">Kode</td>
                             <td width="10"  style="text-align: center;">Nama Barang</td>
                             <td width="8"  style="text-align: center;">Stok</td>
                             <td width="10"  style="text-align: center;">Harga Beli</td>
                             <td width="4"  style="text-align: center;">Diskon (%)</td>
                             <td width="8"  style="text-align: center;">Diskon</td>
                             <td width="14"  style="text-align: center;">Jumlah</td>
                         </tr>
                     </thead>
                     <tbody>
                        <?php
                            $no = 1;
                            $totalStok = 0;
                            $totalDiskon = 0;
                            $total = 0;
                            foreach ($laporandetailpembelian_barang as $ldpb) {
                        ?>
                             <tr>
                                 <td style="text-align: center;"><?= $ldpb->no_transaksi ?></td>
                                 <td style="text-align: center;"><?= formatTanggal($lpb->tgl_pembelian) ?></td>
                                 <td style="text-align: center;"><?= $ldpb->id_supplier?> </td>
                                 <td style="text-align: center;"><?= $ldpb->id_barang ?></td>
                                 <td style="text-align: center;"><?= $ldpb->nama_barang ?></td>
                                 <td style="text-align: center;"><?= $ldpb->stok?></td>
                                 <td style="text-align: center;"><<?= formatPrice($ldpb->harga_beli) ?></td>
                                 <td style="text-align: center;"><?= $ldpb->diskon_persen ?></td>
                                 <td style="text-align: center;"><<?= formatPrice($ldpb->diskon_nominal) ?></td>
                                 <td style="text-align: center;"><?= $ldpb->jumlah ?></td>
                             </tr>
                         <?php } ?>
                     </tbody>   
                     <tfoot>
                        <tr>
                            <td colspan="5" style="background-color: #3b5998; color:#fff; text-align:center">Total</td>
                            <td style="text-align: right;"><?= formatPrice($totalStok) ?></td>
                            <td style="background-color: #3b5998;"></td>
                            <td style="background-color: #3b5998;"></td>
                            <td style="text-align: right;"><?= formatPrice($totalDiskon) ?></td>
                            <td style="text-align: right;"><?= formatPrice($total) ?></td>        
                        </tr>
                    </tfoot>
                 </table>
             </div>
         </div>
     </div>
 </div>