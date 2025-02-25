<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <a href="<?= base_url('pembelianbarang/addView') ?>" class="btn btn-primary">Tambah</a>

            <form class="row g-3 pt-3">
                <div class="col-sm-2">
                    <input type="date" class="form-control">
                </div>
                <div class="col-sm-2">
                    <input type="date" class="form-control">
                </div>
                <div class="col-sm-3">
                    <select id="inputState" class="form-select">
                        <option selected>Semua Pembayaran</option>
                        <option>Cash</option>
                        <option>Transfer</option>
                        <option>Debit</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select id="inputState" class="form-select">
                        <option selected>Semua Supplier</option>
                        <option>...</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <a class="btn btn-success">Tampilkan</a>
                </div>

            </form>

            <div class="table-responsive mt-4">
                <table class="table table-bordered" id="dataTable-data" width="100%">
                    <thead>
                        <tr>
                            <td width="4%" style="text-align: center;"><i class="bi bi-circle"></i></td>
                            <td width="11%" style="text-align: center;">No Transaksi </td>
                            <td width="10%" style="text-align: center;">Tanggal</td>
                            <td width="22" style="text-align: center;">Supplier</td>
                            <td width="11" style="text-align: center;">Metode Pembayaran</td>
                            <td width="12" style="text-align: center;">Status Pembayaran</td>
                            <td width="10" style="text-align: center;">Hutang</td>
                            <td width="10" style="text-align: center;">Total</td>
                            <td width="10%" style="text-align: center;"><i class="bi bi-gear-fill mr-2"></i></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $totalHutang = 0;
                        $total = 0;
                        foreach ($pembelianbarang as $pb) {
                            $supplier = $this->db->query("SELECT supplier FROM t_supplier WHERE id_supplier = $pb->id_supplier")->row()->supplier;
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

                            $totalHutang += $pb->hutang;
                            $total += $pb->total;
                        ?>
                            <tr>
                                <td style="text-align: center;"><?= $no++ ?></td>
                                <td><?= $pb->no_transaksi ?></td>
                                <td style="text-align: center;"><?= formatTanggal($pb->tgl_pembelian) ?></td>
                                <td><?= $supplier ?> </td>
                                <td style="text-align: center;"><?= $mp ?></td>
                                <td style="text-align: center;"><?= $sp ?></td>
                                <td style="text-align: right;"><?= formatPrice($pb->hutang) ?></td>
                                <td style="text-align: right;"><?= formatPrice($pb->total) ?></td>
                                <td style="text-align: center;">
                                    <a href="<?= base_url('pembelianbarang/detailData/' . $pb->id_pembelian) ?>" style="color: #3b5998;" title="Detail" class="mr-2"><i class="bi bi-eye-fill"></i></a>
                                    <a href="<?= base_url('pembelianbarang/editView/' . $pb->id_pembelian) ?>" style="color: #3b5998;" title="Edit" class="mr-2"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" style="color: #3b5998;" title="Hapus" class="tombolHapus" data-id="<?= $pb->id_pembelian ?>"><i class="bi bi-trash3-fill"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" style="background-color: #3b5998; color:#fff; text-align:center">Total</td>
                            <td style="text-align: right;"><?= formatPrice($totalHutang) ?></td>
                            <td style="text-align: right;"><?= formatPrice($total) ?></td>
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
                    url: "<?= base_url('pembelianbarang/hapusData') ?>",
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