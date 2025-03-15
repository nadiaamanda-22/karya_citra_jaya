<?php
$dateNow = date('Y-m-d');
$tglawal = date('Y-m-01');
$tgl_awal = !empty($_REQUEST['tgl_awal']) ? $_REQUEST['tgl_awal'] : $tglawal;
$tgl_akhir = !empty($_REQUEST['tgl_akhir']) ? $_REQUEST['tgl_akhir'] : $dateNow;
$no_invoice = !empty($_REQUEST['no_invoice']) ? $_REQUEST['no_invoice'] : '*';
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
                    <select id="no_invoice" name="no_invoice" class="form-select">
                        <option value="*" <?= $no_invoice == '*' ? 'selected' : '' ?>>Semua Transaksi</option>
                        <?php
                        $getTransaksi = $this->db->query("SELECT id_invoice, no_invoice FROM t_invoice WHERE jenis_invoice='1'")->result();
                        foreach ($getTransaksi as $gs) { ?>
                            <option value="<?= $gs->id_invoice ?>" <?= $no_invoice == $gs->id_invoice ? 'selected' : '' ?>>
                                <?= $gs->no_invoice ?>
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
                <a href="<?= base_url("Laporandetail_kaca/export?tgl_awal=$tgl_awal&tgl_akhir=$tgl_akhir&no_invoice=$no_invoice") ?>" class="btn btn-success">Export</a>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered" id="dataTable-data" width="100%">
                    <thead>
                        <tr>
                            <td width="10%" style="text-align: center;">No Invoice </td>
                            <td width="6%" style="text-align: center;">Tanggal Jual</td>
                            <td width="12" style="text-align: center;">Customer</td>
                            <td width="8" style="text-align: center;">Kode Barang</td>
                            <td width="13" style="text-align: center;">Nama Barang</td>
                            <td width="6" style="text-align: center;">Stok</td>
                            <td width="6" style="text-align: center;">Panjang</td>
                            <td width="6" style="text-align: center;">Lebar</td>
                            <td width="8" style="text-align: center;">Harga Per Meter</td>
                            <td width="8" style="text-align: center;">Harga Jual</td>
                            <td width="4" style="text-align: center;">Diskon (%)</td>
                            <td width="8" style="text-align: center;">Diskon</td>
                            <td width="8" style="text-align: center;">Jumlah</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalDiskon = 0;
                        $total = 0;
                        foreach ($laporandetail_kaca as $r) {
                            $totalDiskon += $r->diskon_nominal;
                            $total += $r->jumlah;

                            $customer = $this->db->query("SELECT nama_customer FROM t_customer WHERE id_customer='$r->id_customer'")->row()->nama_customer;

                            $kodeBrg = $this->db->query("SELECT kode_barang FROM t_stok WHERE id='$r->id_barang'")->row()->kode_barang;
                        ?>
                            <tr>
                                <td style="text-align: center;"><?= $r->no_invoice ?></td>
                                <td style="text-align: center;"><?= formatTanggal($r->tgl_jual) ?></td>
                                <td><?= $customer; ?></td>
                                <td style="text-align: center;"><?= $kodeBrg ?></td>
                                <td><?= $r->nama_barang ?></td>
                                <td style="text-align: center;"><?= $r->stok ?> </td>
                                <td style="text-align: center;"><?= $r->panjang ?> </td>
                                <td style="text-align: center;"><?= $r->lebar ?> </td>
                                <td style="text-align: right;"><?= formatPrice($r->harga_permeter) ?></td>
                                <td style="text-align: right;"><?= formatPrice($r->harga_jual) ?></td>
                                <td style="text-align: center;"><?= $r->diskon_persen ?></td>
                                <td style="text-align: right;"><?= formatPrice($r->diskon_nominal) ?></td>
                                <td style="text-align: right;"><?= formatPrice($r->jumlah) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="11" style="background-color: #3b5998; color:#fff; text-align:center">Total</td>
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
        <h4 style="font-weight: bold;">Laporan Detail Invoice Kaca</h4>
        <p class="mb-5">Periode : <?= formatTanggal($tgl_awal) ?> - <?= formatTanggal($tgl_akhir) ?></p>
        <table class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <td id="headerTabel" width="10%" style="text-align: center;">No Invoice </td>
                    <td id="headerTabel" width="6%" style="text-align: center;">Tanggal Jual</td>
                    <td id="headerTabel" width="12" style="text-align: center;">Customer</td>
                    <td id="headerTabel" width="13" style="text-align: center;">Nama Barang</td>
                    <td id="headerTabel" width="6" style="text-align: center;">Stok</td>
                    <td id="headerTabel" width="6" style="text-align: center;">Satuan</td>
                    <td id="headerTabel" width="8" style="text-align: center;">Harga Per Meter</td>
                    <td id="headerTabel" width="8" style="text-align: center;">Harga Jual</td>
                    <td id="headerTabel" width="4" style="text-align: center;">Diskon (%)</td>
                    <td id="headerTabel" width="8" style="text-align: center;">Diskon</td>
                    <td id="headerTabel" width="8" style="text-align: center;">Jumlah</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalDiskon = 0;
                $total = 0;
                foreach ($laporandetail_kaca as $r) {
                    $totalDiskon += $r->diskon_nominal;
                    $total += $r->jumlah;

                    $customer = $this->db->query("SELECT nama_customer FROM t_customer WHERE id_customer='$r->id_customer'")->row()->nama_customer;
                ?>
                    <tr>
                        <td style="text-align: center;"><?= $r->no_invoice ?></td>
                        <td style="text-align: center;"><?= formatTanggal($r->tgl_jual) ?></td>
                        <td><?= $customer; ?></td>
                        <td><?= $r->nama_barang ?></td>
                        <td style="text-align: center;"><?= $r->stok ?> </td>
                        <td style="text-align: center;"><?= $r->panjang ?> X <?= $r->lebar ?></td>
                        <td style="text-align: right;"><?= formatPrice($r->harga_permeter) ?></td>
                        <td style="text-align: right;"><?= formatPrice($r->harga_jual) ?></td>
                        <td style="text-align: center;"><?= $r->diskon_persen ?></td>
                        <td style="text-align: right;"><?= formatPrice($r->diskon_nominal) ?></td>
                        <td style="text-align: right;"><?= formatPrice($r->jumlah) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td id="headerTabel" colspan="9" style="text-align:center">Total</td>
                    <td style="text-align: right;"><?= formatPrice($totalDiskon) ?></td>
                    <td style="text-align: right;"><?= formatPrice($total) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>