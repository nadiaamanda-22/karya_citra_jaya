<?php
$filterBulan = !empty($_REQUEST['filterBulan']) ? $_REQUEST['filterBulan'] : '*';
$filterTahun = !empty($_REQUEST['filterTahun']) ? $_REQUEST['filterTahun'] : '*';
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">

            <form class="row g-3 pt-3" action="<?= base_url('logs/filterData') ?>" method="post">
                <div class="col-sm-2">
                    <select id="filterBulan" name="filterBulan" class="form-select">
                        <option value="*">Semua bulan</option>
                        <?php for ($i = 1; $i <= 12; $i++):
                            $value = str_pad($i, 2, "0", STR_PAD_LEFT);
                        ?>
                            <option value="<?= $value; ?>" <?= ($filterBulan == $value) ? 'selected' : ''; ?>>
                                <?= getNamaBulan($i); ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select id="filterTahun" name="filterTahun" class="form-select">
                        <option value="*">Semua Tahun</option>
                        <?php foreach (dataTahun('t_logs', 'tanggal') as $year): ?>
                            <option value="<?= $year['year']; ?>" <?= ($filterTahun == $year['year']) ? 'selected' : ''; ?>><?= $year['year']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-success" type="submit">Tampilkan</button>
                </div>

            </form>

            <div class="table-responsive mt-4">
                <table class="table table-bordered" id="dataTable-data" width="100%">
                    <thead>
                        <tr>
                            <td width="22%" style="text-align: center;">Tanggal</td>
                            <td width="15%" style="text-align: center;">Waktu</td>
                            <td width="23%" style="text-align: center;">Username</td>
                            <td width="50%" style="text-align: center;">Keterangan</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data as $r) {
                            list($tanggal, $waktu) = explode(" ", $r->tanggal);
                        ?>
                            <tr>
                                <td style="text-align: center;"><?= formatTanggal($tanggal) ?></td>
                                <td style="text-align: center;"><?= $waktu ?></td>
                                <td style="text-align: center;"><?= $r->username ?></td>
                                <td><?= $r->keterangan ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>