<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
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