<?php
$dateNow = date('Y-m-d');
$tglawal = date('Y-m-01');
$tgl_awal = !empty($_REQUEST['tgl_awal']) ? $_REQUEST['tgl_awal'] : $tglawal;
$tgl_akhir = !empty($_REQUEST['tgl_akhir']) ? $_REQUEST['tgl_akhir'] : $dateNow;
$no_transaksi = !empty($_REQUEST['no_transaksi']) ? $_REQUEST['no_transaksi'] : '*';
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
            <form class="row g-3 pt-3" action="<?= base_url('Laporandetailpembelian_barang/filterData') ?>" method="post">
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" value="<?= $tgl_awal ?>">
                </div>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="tgl_akhir" value="<?= $tgl_akhir ?>">
                </div>
                <div class="col-sm-3">
                    <select id="no_transaksi" name="no_transaksi" class="form-select">
                        <option value="*" <?= $no_transaksi == '*' ? 'selected' : '' ?>>Semua Transaksi</option>
                        <?php
                        $getTransaksi = $this->db->query("SELECT id_pembelian, no_transaksi FROM t_pembelian_barang")->result();
                        foreach ($getTransaksi as $gs) { ?>
                            <option value="<?= $gs->id_pembelian ?>" <?= $no_transaksi == $gs->id_pembelian ? 'selected' : '' ?>>
                                <?= $gs->no_transaksi ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-info" type="submit">Tampilkan</button>
                </div>
            </form>

            <div class="mt-4">
                <a class="btn btn-primary" onclick="window.print()">Print</a>
                <a href="<?= base_url("Laporandetailpembelian_barang/exportData?tgl_awal=$tgl_awal&tgl_akhir=$tgl_akhir&no_transaksi=$no_transaksi") ?>" class="btn btn-success">Export</a>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered" id="dataTable-data" width="100%">
                    <thead>
                        <tr>
                            <td width="14%" style="text-align: center;">No Transaksi </td>
                            <td width="12%" style="text-align: center;">Tanggal</td>
                            <td width="12" style="text-align: center;">Supplier</td>
                            <td width="8" style="text-align: center;">Kode Barang</td>
                            <td width="15" style="text-align: center;">Nama Barang</td>
                            <td width="8" style="text-align: center;">Stok</td>
                            <td width="10" style="text-align: center;">Harga Beli</td>
                            <td width="4" style="text-align: center;">Diskon (%)</td>
                            <td width="8" style="text-align: center;">Diskon</td>
                            <td width="14" style="text-align: center;">Jumlah</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalDiskon = 0;
                        $total = 0;

                        foreach ($laporandetailpembelian_barang as $ldpb) {
                            $totalDiskon += $ldpb->diskon_nominal;
                            $total += $ldpb->jumlah;

                            $supplier = $this->db->query("SELECT supplier FROM t_supplier WHERE id_supplier='$ldpb->id_supplier'")->row()->supplier;

                            $kodeBrg = $this->db->query("SELECT kode_barang FROM t_stok WHERE id='$ldpb->id_barang'")->row()->kode_barang;
                        ?>
                            <tr>
                                <td style="text-align: center;"><?= $ldpb->no_transaksi ?></td>
                                <td style="text-align: center;"><?= formatTanggal($ldpb->tgl_pembelian) ?></td>
                                <td><?= $supplier; ?></td>
                                <td style="text-align: center;"><?= $kodeBrg ?></td>
                                <td><?= $ldpb->nama_barang ?></td>
                                <td style="text-align: center;"><?= $ldpb->stok ?></td>
                                <td style="text-align: right;"><?= formatPrice($ldpb->harga_beli) ?></td>
                                <td style="text-align: center;"><?= $ldpb->diskon_persen ?></td>
                                <td style="text-align: right;"><?= formatPrice($ldpb->diskon_nominal) ?></td>
                                <td style="text-align: right;"><?= formatPrice($ldpb->jumlah) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8" style="background-color: #3b5998; color:#fff; text-align:center">Total</td>
                            <td style="text-align: right;"><?= formatPrice($totalDiskon) ?></td>
                            <td style="text-align: right;"><?= formatPrice($total) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row" style="background-color: #fff;">
    <div class="col-12 tablePrint">
        <h4 style="font-weight: bold;">Laporan Detail Pembelian Barang</h4>
        <p class="mb-5">Periode : <?= formatTanggal($tgl_awal) ?> - <?= formatTanggal($tgl_akhir) ?></p>
        <table class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <td id="headerTabel" width="14%" style="text-align: center;">No Transaksi </td>
                    <td id="headerTabel" width="12%" style="text-align: center;">Tanggal</td>
                    <td id="headerTabel" width="12" style="text-align: center;">Supplier</td>
                    <td id="headerTabel" width="8" style="text-align: center;">Kode Barang</td>
                    <td id="headerTabel" width="15" style="text-align: center;">Nama Barang</td>
                    <td id="headerTabel" width="8" style="text-align: center;">Stok</td>
                    <td id="headerTabel" width="10" style="text-align: center;">Harga Beli</td>
                    <td id="headerTabel" width="4" style="text-align: center;">Diskon (%)</td>
                    <td id="headerTabel" width="8" style="text-align: center;">Diskon</td>
                    <td id="headerTabel" width="14" style="text-align: center;">Jumlah</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalDiskon = 0;
                $total = 0;

                foreach ($laporandetailpembelian_barang as $ldpb) {
                    $totalDiskon += $ldpb->diskon_nominal;
                    $total += $ldpb->jumlah;

                    $supplier = $this->db->query("SELECT supplier FROM t_supplier WHERE id_supplier='$ldpb->id_supplier'")->row()->supplier;

                    $kodeBrg = $this->db->query("SELECT kode_barang FROM t_stok WHERE id='$ldpb->id_barang'")->row()->kode_barang;
                ?>
                    <tr>
                        <td style="text-align: center;"><?= $ldpb->no_transaksi ?></td>
                        <td style="text-align: center;"><?= formatTanggal($ldpb->tgl_pembelian) ?></td>
                        <td><?= $supplier; ?></td>
                        <td style="text-align: center;"><?= $kodeBrg ?></td>
                        <td><?= $ldpb->nama_barang ?></td>
                        <td style="text-align: center;"><?= $ldpb->stok ?></td>
                        <td style="text-align: right;"><?= formatPrice($ldpb->harga_beli) ?></td>
                        <td style="text-align: center;"><?= $ldpb->diskon_persen ?></td>
                        <td style="text-align: right;"><?= formatPrice($ldpb->diskon_nominal) ?></td>
                        <td style="text-align: right;"><?= formatPrice($ldpb->jumlah) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td id="headerTabel" colspan="8" style="text-align:center">Total</td>
                    <td style="text-align: right;"><?= formatPrice($totalDiskon) ?></td>
                    <td style="text-align: right;"><?= formatPrice($total) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>