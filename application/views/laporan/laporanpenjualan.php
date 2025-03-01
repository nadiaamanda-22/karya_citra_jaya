<?php
$dateNow = date('Y-m-d');
$tgl_awal = !empty($_REQUEST['tgl_awal']) ? $_REQUEST['tgl_awal'] : $dateNow;
$tgl_akhir = !empty($_REQUEST['tgl_akhir']) ? $_REQUEST['tgl_akhir'] : $dateNow;
$metode_pembayaran = !empty($_REQUEST['metode_pembayaran']) ? $_REQUEST['metode_pembayaran'] : '*';
$customer = !empty($_REQUEST['customer']) ? $_REQUEST['customer'] : '*';
$jenis_invoice = !empty($_REQUEST['jenis_invoice']) ? $_REQUEST['jenis_invoice'] : '*';
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="row g-3 pt-3" action="<?= base_url('Laporanpenjualan/filterData') ?>" method="post">
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" value="<?= $tgl_awal ?>">
                </div>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="tgl_akhir" value="<?= $tgl_akhir ?>">
                </div>
                <div class="col-sm-2">
                    <select id="metode_pembayaran" name="metode_pembayaran" class="form-select">
                        <option value="*" <?= $metode_pembayaran == '*' ? 'selected' : '' ?>>Semua Pembayaran</option>
                        <option value="tunai" <?= $metode_pembayaran == 'tunai' ? 'selected' : '' ?>>Tunai</option>
                        <option value="nontunai" <?= $metode_pembayaran == 'nontunai' ? 'selected' : '' ?>>Non Tunai</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select id="customer" name="customer" class="form-select">
                        <option value="*" <?= $customer == '*' ? 'selected' : '' ?>>Semua Customer</option>
                        <?php 
                        $getCustomer = $this->db->query("SELECT * FROM t_customer")->result();
                        foreach ($getCustomer as $gc) { ?>
                            <option value="<?= $gc->id_customer ?>" <?= $customer == $gc->id_customer ? 'selected' : '' ?>>
                                <?= $gc->customer ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select id="jenis_invoice" name="jenis_invoice" class="form-select">
                        <option value="*" <?= $jenis_invoice == '*' ? 'selected' : '' ?>>Semua Jenis Invoice</option>
                        <option value="invoice" <?= $jenis_invoice == 'invoice' ? 'selected' : '' ?>>Invoice</option>
                        <option value="invoicekaca" <?= $jenis_invoice == 'invoicekaca' ? 'selected' : '' ?>>Invoice Kaca</option>
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
                             <td width="10%" style="text-align: center;">No Inovice </td>
                             <td width="8%" style="text-align: center;">Tanggal</td>
                             <td width="12"  style="text-align: center;">Customer</td>
                             <td width="8"  style="text-align: center;">Subtotal</td>
                             <td width="8"  style="text-align: center;">Diskon</td>
                             <td width="8"  style="text-align: center;">Ongkir</td>
                             <td width="8"  style="text-align: center;">Total</td>
                             <td width="10"  style="text-align: center;">Status Pembayaran</td>
                             <td width="8"  style="text-align: center;">Hutang</td>
                             <td width="14"  style="text-align: center;">Metode Pembayaran</td>
                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            $no = 1;
                            foreach ($laporanpenjualan as $lp) { ?>
                             <tr>
                                 <td style="text-align: center;"><?= $lp->no_invoice ?></td>
                                 <td style="text-align: center;"><?= $lp->id_customer?></td>
                                 <td style="text-align: center;"><?= $lp->id_supplier?> </td>
                                 <td style="text-align: center;"><?= $lp->subtotal?></td>
                                 <td style="text-align: center;"><?= $lp->diskon?></td>
                                 <td style="text-align: center;"><?= $lp->total?></td>
                                 <td style="text-align: center;"><?= $lp->status_pembayaran?></td>
                                 <td style="text-align: center;"><?= $lp->hutang?></td>
                                 <td style="text-align: center;"><?= $lp->metode_pembayaran?></td>
                             </tr>
                         <?php } ?>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>
 </div>