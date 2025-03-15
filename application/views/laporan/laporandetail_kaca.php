<?php
$dateNow = date('Y-m-d');
$tglawal = date('Y-m-01');
$tgl_awal = !empty($_REQUEST['tgl_awal']) ? $_REQUEST['tgl_awal'] : $tglawal;
$tgl_akhir = !empty($_REQUEST['tgl_akhir']) ? $_REQUEST['tgl_akhir'] : $dateNow;
$metode_pembayaran = !empty($_REQUEST['metode_pembayaran']) ? $_REQUEST['metode_pembayaran'] : '*';
$customer = !empty($_REQUEST['customer']) ? $_REQUEST['customer'] : '*';
?>

<style>
    .tablePrint {
        display: none;
    }

    @media print {

        .container-fluid,
        #accordionSidebar,
        .footer {
            display: none;
        }

        .tablePrint {
            display: block;
        }
    }
</style>


<!-- Begin Page Content -->
<div class="container-fluid">
     <div class="card shadow mb-4">
         <div class="card-body">
         <form class="row g-3 pt-3" action="<?= base_url('Laporandetail_kaca/filterData') ?>" method="post">
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
                    <select id="customer" name="customer" class="form-select">
                        <option value="*" <?= $customer == '*' ? 'selected' : '' ?>>Semua Customer</option>
                        <?php
                        $getCustomer = $this->db->query("SELECT * FROM t_customer")->result();
                        foreach ($getCustomer as $gc) { ?>
                            <option value="<?= $gc->id_customer ?>" <?= $customer == $gc->id_customer ? 'selected' : '' ?>><?= $gc->nama_customer ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-success" type="submit">Tampilkan</button>
                </div>
            </form>

                <div class="mt-4">
                <a class="btn btn-primary" onclick="window.print()">Print</a>
                    <a href="<?= base_url('Laporandetail_kaca/export?tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&metode_pembayaran='.$metode_pembayaran.'&customer='.$customer) ?>" class="btn btn-success">Export</a>
                </div>
                
             <div class="table-responsive mt-4">
                 <table class="table table-bordered" id="dataTable-data" width="100%">
                     <thead>
                         <tr>
                             <td width="14%" style="text-align: center;">No Transaksi </td>
                             <td width="12%" style="text-align: center;">Tanggal</td>
                             <td width="12"  style="text-align: center;">Customer</td>
                             <td width="10"  style="text-align: center;">Kode</td>
                             <td width="16"  style="text-align: center;">Nama Barang</td>
                             <td width="16"  style="text-align: center;">Panjang</td>
                             <td width="16"  style="text-align: center;">Lebar</td>
                             <td width="16"  style="text-align: center;">Stok</td>
                             <td width="12"  style="text-align: center;">Harga Satuan</td>
                             <td width="8"  style="text-align: center;">Harga /m2</td>
                             <td width="10"  style="text-align: center;">Jumlah</td>
                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            $no = 1;
                            foreach ($laporandetail_kaca as $ldk) { ?>
                             <tr>
                                 <td style="text-align: center;"><?= $ldk->no_invoice ?></td>
                                 <td style="text-align: center;"><?= $ldk->tgl_jual?></td>
                                 <td style="text-align: center;"><?= $ldk->nama_customer?></td>
                                 <td style="text-align: center;"><?= $ldk->id_barang?> </td>
                                 <td style="text-align: center;"><?= $ldk->nama_barang?></td>
                                 <td style="text-align: center;"><?= $ldk->panjang?></td>
                                 <td style="text-align: center;"><?= $ldk->lebar?></td>
                                 <td style="text-align: center;"><?= $ldk->stok?></td>
                                 <td style="text-align: center;"><?= $ldk->harga_jual?></td>
                                 <td style="text-align: center;"><?= $ldk->harga_permeter?></td>
                                 <td style="text-align: center;"><?= $ldk->jumlah?></td>
                             </tr>
                         <?php } ?>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>
 </div>