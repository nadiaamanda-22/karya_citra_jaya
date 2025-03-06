<?php
$dateNow = date('Y-m-d');
$tgl_awal = !empty($_REQUEST['tgl_awal']) ? $_REQUEST['tgl_awal'] : $dateNow;
$tgl_akhir = !empty($_REQUEST['tgl_akhir']) ? $_REQUEST['tgl_akhir'] : $dateNow;
$metode_pembayaran = !empty($_REQUEST['metode_pembayaran']) ? $_REQUEST['metode_pembayaran'] : '*';
$status_pembayaran = !empty($_REQUEST['status_pembayaran']) ? $_REQUEST['status_pembayaran'] : '*';
$customer = !empty($_REQUEST['customer']) ? $_REQUEST['customer'] : '*';
$jenis_invoice = isset($_REQUEST['jenis_invoice']) ? $_REQUEST['jenis_invoice'] : '*';
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <a href="<?= base_url('penjualan/addView') ?>" class="btn btn-primary">Tambah Invoice</a>
            <a href="<?= base_url('penjualan/addViewKaca') ?>" class="btn btn-primary">Tambah Invoice Kaca</a>

            <form class="row g-3 pt-3" action="<?= base_url('penjualan/filterData') ?>" method="post">
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
                        <option value="*" selected>Semua Customer</option>
                        <?php $getCus = $this->db->query("SELECT * FROM t_customer")->result();
                        foreach ($getCus as $gs) { ?>
                            <option value="<?= $gs->id_customer ?>" <?= $customer == $gs->id_customer ? 'selected' : '' ?>><?= $gs->nama_customer ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select id="jenis_invoice" name="jenis_invoice" class="form-select">
                        <option value="*" selected>Semua Jenis Invoice</option>
                        <option value="0" <?= $jenis_invoice == '0' ? 'selected' : '' ?>>Invoice Biasa</option>
                        <option value="1" <?= $jenis_invoice == '1' ? 'selected' : '' ?>>Invoice Kaca</option>
                    </select>
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-success" type="submit">Tampilkan</button>
                </div>
            </form>

            <div class="table-responsive mt-4">
                <table class="table table-bordered" id="dataTable-data" width="100%">
                    <thead>
                        <tr>
                            <td width="3%" style="text-align: center;"><i class="bi bi-circle"></i></td>
                            <td width="10%" style="text-align: center;">No Invoice </td>
                            <td width="8%" style="text-align: center;">Jenis Invoice </td>
                            <td width="8%" style="text-align: center;">Tanggal Jual</td>
                            <td width="17" style="text-align: center;">Customer</td>
                            <td width="11" style="text-align: center;">Metode Pembayaran</td>
                            <td width="11" style="text-align: center;">Status Pembayaran</td>
                            <td width="7%" style="text-align: center;">Hutang</td>
                            <td width="7%" style="text-align: center;">Subtotal</td>
                            <td width="7%" style="text-align: center;">Ongkir</td>
                            <td width="7%" style="text-align: center;">Total</td>
                            <td width="4%" style="text-align: center;"><i class="bi bi-gear-fill mr-2"></i></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $totalHutang = 0;
                        $totalSubtotal = 0;
                        $totalOngkir = 0;
                        $totalTotal = 0;
                        foreach ($invoice as $pb) {
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
                                <td style="text-align: center;"><?= $no++ ?></td>
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
                                <td style="text-align: center;">
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="<?= base_url('penjualan/detailData/' . $pb->id_invoice) ?>" style="color: #3b5998;" title="Detail" class="mr-2"><i class="bi bi-eye-fill"></i></a>
                                        </div>
                                        <div class="col-6">
                                            <a href="<?= base_url('pembelianbarang/detailData/' . $pb->id_invoice) ?>" style="color: #3b5998;" title="Nota Invoice" class="mr-2"><i class="bi bi-printer-fill"></i></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <?php if ($pb->jenis_invoice == '0') { ?>
                                                <a href="<?= base_url('penjualan/editView/' . $pb->id_invoice) ?>" style="color: #3b5998;" title="Edit" class="mr-2"><i class="bi bi-pencil-square"></i></a>
                                            <?php } else { ?>
                                                <a href="<?= base_url('penjualan/editKacaView/' . $pb->id_invoice) ?>" style="color: #3b5998;" title="Edit" class="mr-2"><i class="bi bi-pencil-square"></i></a>
                                            <?php } ?>
                                        </div>
                                        <div class="col-6">
                                            <a href="#" style="color: #3b5998;" title="Hapus" class="tombolHapus" data-id="<?= $pb->id_invoice ?>"><i class="bi bi-trash3-fill"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" style="background-color: #3b5998; color:#fff; text-align:center">Total</td>
                            <td style="text-align: right;"><?= formatPrice($totalHutang) ?></td>
                            <td style="text-align: right;"><?= formatPrice($totalSubtotal) ?></td>
                            <td style="text-align: right;"><?= formatPrice($totalOngkir) ?></td>
                            <td style="text-align: right;"><?= formatPrice($totalTotal) ?></td>
                            <td style="background-color: #3b5998;"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('message')) { ?>
    <script>
        var message = "<?= $this->session->flashdata('message') ?>";
        if (message == 'berhasil tambah') {
            Swal.fire({
                title: "Data berhasil ditambah!",
                icon: "success",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'berhasil ubah') {
            Swal.fire({
                title: "Data berhasil diubah!",
                icon: "success",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'melebihi_batas') {
            Swal.fire({
                title: "Transaksi bulan ini melebihi batas!",
                icon: "error",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else {
            Swal.fire({
                title: "Terjadi kesalahan",
                text: "Silahkan ulangi proses!",
                icon: "error",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        }
    </script>
<?php } ?>

<script>
    $('.tombolHapus').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        console.log(id)

        Swal.fire({
            title: "Apakah kamu yakin?",
            text: "Data yang sudah terhapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3b5998",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('penjualan/hapusData') ?>",
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response == 'berhasil') {
                            Swal.fire({
                                title: "Data berhasil dihapus!",
                                icon: "success",
                                showDenyButton: false,
                                showCancelButton: false,
                                confirmButtonText: "Ya",
                                confirmButtonColor: "#3b5998",
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    }
                });
            }
        });
    })
</script>