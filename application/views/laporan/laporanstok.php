<?php
$id_kelompok_terpilih = isset($_POST['id_kelompok']) ? $_POST['id_kelompok'] : '*';
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


<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="row g-3 pt-3" action="<?= base_url('Laporanstok/filterData') ?>" method="post">
                <div class="col-sm-3">
                    <select id="id_kelompok" name="id_kelompok" class="form-select">
                        <option value="*" <?= ($id_kelompok_terpilih == '*') ? 'selected' : '' ?>>Semua Kelompok Barang</option>
                        <?php
                        $getKelompokbarang = $this->db->query("SELECT * FROM t_kelompok_barang")->result();
                        foreach ($getKelompokbarang as $gkb) { ?>
                            <option value="<?= $gkb->id_kelompok ?>" <?= ($gkb->id_kelompok == $id_kelompok_terpilih) ? 'selected' : '' ?>>
                                <?= $gkb->nama_kelompok ?>
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
                <?php if ($id_kelompok_terpilih == '*') {
                    $sendFilterKelompok = '';
                } else {
                    $sendFilterKelompok = $id_kelompok_terpilih;
                } ?>
                <a href="<?= base_url("laporanstok/export/$sendFilterKelompok") ?>" class="btn btn-success">Export</a>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered" id="dataTable-data" width="100%">
                    <thead>
                        <tr>
                            <td width="16%" style="text-align: center;">Kode Barang </td>
                            <td width="28%" style="text-align: center;">Nama Barang</td>
                            <td width="24" style="text-align: center;">Kelompok Barang</td>
                            <td width="8" style="text-align: center;">Jumlah Stok</td>
                            <td width="10" style="text-align: center;">Harga Beli</td>
                            <td width="10" style="text-align: center;">Harga /m2</td>
                            <td width="10" style="text-align: center;">Harga Jual</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($laporanstok as $ls) { ?>
                            <tr>
                                <td style="text-align: center;"><?= $ls->kode_barang ?></td>
                                <td style="text-align: left;"><?= $ls->nama_barang ?></td>
                                <td style="text-align: left;"><?= $ls->nama_kelompok ?></td>
                                <td style="text-align: center;"><?= $ls->stok ?> <?= $ls->satuan ?></td>
                                <td style="text-align: right;"><?= formatPrice($ls->harga_beli) ?></td>
                                <td style="text-align: right;"><?= formatPrice($ls->harga_permeter) ?></td>
                                <td style="text-align: right;"><?= formatPrice($ls->harga_jual) ?></td>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row" style="background-color: #fff;">
    <div class="col-12 tablePrint">
        <h4 style="font-weight: bold;" class="mb-5">Laporan Stok Barang</h4>
        <table class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <td id="headerTabel" width="11%" style="text-align: center;">Kode Barang </td>
                    <td id="headerTabel" width="25%" style="text-align: center;">Nama Barang</td>
                    <td id="headerTabel" width="15%" style="text-align: center;">Kelompok Barang</td>
                    <td id="headerTabel" width="10%" style="text-align: center;">Jumlah Stok</td>
                    <td id="headerTabel" width="13%" style="text-align: center;">Harga Beli</td>
                    <td id="headerTabel" width="13%" style="text-align: center;">Harga /m2</td>
                    <td id="headerTabel" width="13%" style="text-align: center;">Harga Jual</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($laporanstok as $ls) { ?>
                    <tr>
                        <td style="text-align: center;"><?= $ls->kode_barang ?></td>
                        <td style="text-align: left;"><?= $ls->nama_barang ?></td>
                        <td style="text-align: left;"><?= $ls->nama_kelompok ?></td>
                        <td style="text-align: center;"><?= $ls->stok ?> <?= $ls->satuan ?></td>
                        <td style="text-align: right;"><?= formatPrice($ls->harga_beli) ?></td>
                        <td style="text-align: right;"><?= formatPrice($ls->harga_permeter) ?></td>
                        <td style="text-align: right;"><?= formatPrice($ls->harga_jual) ?></td>
                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>