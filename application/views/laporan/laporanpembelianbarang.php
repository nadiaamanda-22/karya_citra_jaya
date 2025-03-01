<?php
$dateNow = date('Y-m-d');
$tgl_awal = !empty($_REQUEST['tgl_awal']) ? $_REQUEST['tgl_awal'] : $dateNow;
$tgl_akhir = !empty($_REQUEST['tgl_akhir']) ? $_REQUEST['tgl_akhir'] : $dateNow;
$metode_pembayaran = !empty($_REQUEST['metode_pembayaran']) ? $_REQUEST['metode_pembayaran'] : '*';
$supplier = !empty($_REQUEST['supplier']) ? $_REQUEST['supplier'] : '*';
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="row g-3 pt-3" action="<?= base_url('Laporanpembelianbarang/filterData') ?>" method="post">
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" value="<?= $tgl_awal ?>">
                </div>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="tgl_akhir" value="<?= $tgl_akhir ?>">
                </div>
                <div class="col-sm-3">
                    <select id="metode_pembayaran" name="metode_pembayaran" class="form-select">
                        <option value="*" selected>Semua Pembayaran</option>
                        <option value="tunai" <?= $metode_pembayaran == 'tunai' ? 'selected' : '' ?>>Tunai</option>
                        <option value="nontunai" <?= $metode_pembayaran == 'nontunai' ? 'selected' : '' ?>>Non Tunai</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select id="supplier" name="supplier" class="form-select">
                        <option value="*" selected>Semua Supplier</option>
                        <?php $getSupplier = $this->db->query("SELECT * FROM t_supplier")->result();
                        foreach ($getSupplier as $gs) { ?>
                            <option value="<?= $gs->id_supplier ?>" <?= $supplier == $gs->id_supplier ? 'selected' : '' ?>><?= $gs->supplier ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-success" type="submit">Tampilkan</button>
                </div>
            </form>

                <div class="mt-4">
                    <a class="btn btn-primary">Print</a>
                    <a class="btn btn-success">Export</a>
                </div>
                
             <div class="table-responsive mt-4">
                 <table class="table table-bordered" id="dataTable-data" width="100%">
                     <thead>
                         <tr>
                             <td width="10%" style="text-align: center;">No Transaksi </td>
                             <td width="8%" style="text-align: center;">Tanggal</td>
                             <td width="12"  style="text-align: center;">Supplier</td>
                             <td width="8"  style="text-align: center;">Subtotal</td>
                             <td width="8"  style="text-align: center;">Diskon</td>
                             <td width="8"  style="text-align: center;">Total</td>
                             <td width="10"  style="text-align: center;">Status Pembayaran</td>
                             <td width="8"  style="text-align: center;">Hutang</td>
                             <td width="14"  style="text-align: center;">Metode Pembayaran</td>
                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            $no = 1;
                            foreach ($laporanpembelianbarang as $lpb) { ?>
                             <tr>
                                 <td style="text-align: center;"><?= $lpb->no_transaksi ?></td>
                                 <td style="text-align: center;"><?= $lpb->tgl_pembelian?></td>
                                 <td style="text-align: center;"><?= $lpb->id_supplier?> </td>
                                 <td style="text-align: center;"><?= $lpb->total?></td>
                                 <td style="text-align: center;"><?= $lpb->diskon?></td>
                                 <td style="text-align: center;"><?= $lpb->total?></td>
                                 <td style="text-align: center;"><?= $lpb->status_pembayaran?></td>
                                 <td style="text-align: center;"><?= $lpb->hutang?></td>
                                 <td style="text-align: center;"><?= $lpb->metode_pembayaran?></td>
                             </tr>
                         <?php } ?>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>
 </div>