<?php
$dateNow = date('Y-m-d');
$tglawal = date('Y-m-01');
$tgl_awal = !empty($_REQUEST['tgl_awal']) ? $_REQUEST['tgl_awal'] : $tglawal;
$tgl_akhir = !empty($_REQUEST['tgl_akhir']) ? $_REQUEST['tgl_akhir'] : $dateNow;
$metode_pembayaran = !empty($_REQUEST['metode_pembayaran']) ? $_REQUEST['metode_pembayaran'] : '*';
$status_pembayaran = !empty($_REQUEST['status_pembayaran']) ? $_REQUEST['status_pembayaran'] : '*';
$customer = !empty($_REQUEST['customer']) ? $_REQUEST['customer'] : '*';
$jenis_invoice = !empty($_REQUEST['jenis_invoice']) ? $_REQUEST['jenis_invoice'] : '*';
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
            <form class="row g-3 pt-3" action="<?= base_url('Laporanpenjualan/filterData') ?>" method="post">
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" value="<?= $tgl_awal ?>">
                </div>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="tgl_akhir" value="<?= $tgl_akhir ?>">
                </div>
                <div class="col-sm-2">
                    <select id="metode_pembayaran" name="metode_pembayaran" class="form-select">
                        <option value="*" selected>Semua Metode Pembayaran</option>
                        <option value="tunai" <?= $metode_pembayaran == 'tunai' ? 'selected' : '' ?>>Tunai</option>
                        <option value="nontunai" <?= $metode_pembayaran == 'nontunai' ? 'selected' : '' ?>>Non Tunai</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select id="status_pembayaran" name="status_pembayaran" class="form-select">
                        <option value="*" selected>Semua Status Pembayaran</option>
                        <option value="lunas" <?= $status_pembayaran == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                        <option value="belumlunas" <?= $status_pembayaran == 'belumlunas' ? 'selected' : '' ?>>Belum Lunas</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select id="customer" name="customer" class="form-select">
                        <option value="*" <?= $customer == '*' ? 'selected' : '' ?>>Semua Customer</option>
                        <?php
                        $getCustomer = $this->db->query("SELECT * FROM t_customer")->result();
                        foreach ($getCustomer as $gc) { ?>
                            <option value="<?= $gc->id_customer ?>" <?= $customer == $gc->id_customer ? 'selected' : '' ?>>
                                <?= $gc->nama_customer ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select id="jenis_invoice" name="jenis_invoice" class="form-select">
                        <option value="*" <?= isset($jenis_invoice) && $jenis_invoice == '*' ? 'selected' : '' ?>>Semua Jenis Invoice</option>
                        <option value="0" <?= isset($jenis_invoice) && $jenis_invoice == 'invoice' ? 'selected' : '' ?>>Invoice</option>
                        <option value="1" <?= isset($jenis_invoice) && $jenis_invoice == 'invoicekaca' ? 'selected' : '' ?>>Invoice Kaca</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-info" type="submit">Tampilkan</button>
                </div>
            </form>

            <div class="mt-4">
                <a class="btn btn-primary" onclick="window.print()">Print</a>
                <a href="<?= base_url("Laporanpenjualan/export?tgl_awal=$tgl_awal&tgl_akhir=$tgl_akhir&metode_pembayaran=$metode_pembayaran&status_pembayaran=$status_pembayaran&customer=$customer&jenis_invoice=$jenis_invoice") ?>" class="btn btn-success">Export</a>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered" id="dataTable-data" width="100%">
                    <thead>
                        <tr>
                            <td width="10%" style="text-align: center;">No Invoice </td>
                            <td width="8%" style="text-align: center;">Jenis Invoice </td>
                            <td width="8%" style="text-align: center;">Tanggal Jual</td>
                            <td width="20" style="text-align: center;">Customer</td>
                            <td width="11" style="text-align: center;">Metode Pembayaran</td>
                            <td width="11" style="text-align: center;">Status Pembayaran</td>
                            <td width="8%" style="text-align: center;">Hutang</td>
                            <td width="8%" style="text-align: center;">Subtotal</td>
                            <td width="8%" style="text-align: center;">Ongkir</td>
                            <td width="8%" style="text-align: center;">Total</td>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $no = 1;
                        $totalHutang = 0;
                        $totalSubtotal = 0;
                        $totalOngkir = 0;
                        $totalTotal = 0;
                        foreach ($laporanpenjualan as $pb) {
                            $customer = $this->db->query("SELECT nama_customer FROM t_customer WHERE id_customer = $pb->id_customer")->row()->nama_customer;
                            if ($pb->status_pembayaran == 'lunas') {
                                $sp = 'Lunas';
                            } else {
                                $sp = 'Belum Lunas';
                            }

                            if ($pb->metode_pembayaran == 'tunai') {
                                $mp = 'Tunai';
                            } else {
                                $mp = 'Non Tunai';
                            }

                            if ($pb->jenis_invoice == '0') {
                                $inv = 'Invoice Biasa';
                            } else {
                                $inv = 'Invoice Kaca';
                            }

                            $totalHutang += $pb->hutang;
                            $totalSubtotal += $pb->subtotal;
                            $totalOngkir += $pb->ongkir;
                            $totalTotal += $pb->total;
                        ?>
                            <tr>
                                <td><?= $pb->no_invoice ?></td>
                                <td><?= $inv ?></td>
                                <td style="text-align: center;"><?= formatTanggal($pb->tgl_jual) ?></td>
                                <td><?= $customer ?> </td>
                                <td style="text-align: center;"><?= $mp ?></td>
                                <td style="text-align: center;"><?= $sp ?></td>
                                <td style="text-align: right;"><?= formatPrice($pb->hutang) ?></td>
                                <td style="text-align: right;"><?= formatPrice($pb->subtotal) ?></td>
                                <td style="text-align: right;"><?= formatPrice($pb->ongkir) ?></td>
                                <td style="text-align: right;"><?= formatPrice($pb->total) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" style="background-color: #3b5998; color:#fff; text-align:center">Total</td>
                            <td style="text-align: right;"><?= formatPrice($totalHutang) ?></td>
                            <td style="text-align: right;"><?= formatPrice($totalSubtotal) ?></td>
                            <td style="text-align: right;"><?= formatPrice($totalOngkir) ?></td>
                            <td style="text-align: right;"><?= formatPrice($totalTotal) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row" style="background-color: #fff;">
    <div class="col-12 tablePrint">
        <h4 style="font-weight: bold;">Laporan Penjualan</h4>
        <p class="mb-5">Periode : <?= formatTanggal($tgl_awal) ?> - <?= formatTanggal($tgl_akhir) ?></p>
        <table class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <td id="headerTabel" width="10%" style="text-align: center;">No Invoice </td>
                    <td id="headerTabel" width="8%" style="text-align: center;">Jenis Invoice </td>
                    <td id="headerTabel" width="8%" style="text-align: center;">Tanggal Jual</td>
                    <td id="headerTabel" width="20" style="text-align: center;">Customer</td>
                    <td id="headerTabel" width="11" style="text-align: center;">Metode Pembayaran</td>
                    <td id="headerTabel" width="11" style="text-align: center;">Status Pembayaran</td>
                    <td id="headerTabel" width="8%" style="text-align: center;">Hutang</td>
                    <td id="headerTabel" width="8%" style="text-align: center;">Subtotal</td>
                    <td id="headerTabel" width="8%" style="text-align: center;">Ongkir</td>
                    <td id="headerTabel" width="8%" style="text-align: center;">Total</td>

                </tr>
            </thead>
            <tbody>

                <?php
                $no = 1;
                $totalHutang = 0;
                $totalSubtotal = 0;
                $totalOngkir = 0;
                $totalTotal = 0;
                foreach ($laporanpenjualan as $pb) {
                    $customer = $this->db->query("SELECT nama_customer FROM t_customer WHERE id_customer = $pb->id_customer")->row()->nama_customer;
                    if ($pb->status_pembayaran == 'lunas') {
                        $sp = 'Lunas';
                    } else {
                        $sp = 'Belum Lunas';
                    }

                    if ($pb->metode_pembayaran == 'tunai') {
                        $mp = 'Tunai';
                    } else {
                        $mp = 'Non Tunai';
                    }

                    if ($pb->jenis_invoice == '0') {
                        $inv = 'Invoice Biasa';
                    } else {
                        $inv = 'Invoice Kaca';
                    }

                    $totalHutang += $pb->hutang;
                    $totalSubtotal += $pb->subtotal;
                    $totalOngkir += $pb->ongkir;
                    $totalTotal += $pb->total;
                ?>
                    <tr>
                        <td><?= $pb->no_invoice ?></td>
                        <td><?= $inv ?></td>
                        <td style="text-align: center;"><?= formatTanggal($pb->tgl_jual) ?></td>
                        <td><?= $customer ?> </td>
                        <td style="text-align: center;"><?= $mp ?></td>
                        <td style="text-align: center;"><?= $sp ?></td>
                        <td style="text-align: right;"><?= formatPrice($pb->hutang) ?></td>
                        <td style="text-align: right;"><?= formatPrice($pb->subtotal) ?></td>
                        <td style="text-align: right;"><?= formatPrice($pb->ongkir) ?></td>
                        <td style="text-align: right;"><?= formatPrice($pb->total) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" id="headerTabel" style="text-align:center">Total</td>
                    <td style="text-align: right;"><?= formatPrice($totalHutang) ?></td>
                    <td style="text-align: right;"><?= formatPrice($totalSubtotal) ?></td>
                    <td style="text-align: right;"><?= formatPrice($totalOngkir) ?></td>
                    <td style="text-align: right;"><?= formatPrice($totalTotal) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>