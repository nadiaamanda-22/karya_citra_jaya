<?php
$templateImport = '';
$templateImport = "<a href='" . base_url() . "assets/template/template_import_stok.xlsx' class='t-green-1'><i>Download Template</i></a>";
$level = $this->session->userdata('level');
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-5">
        <div class="card-body">
            <div id="formImport" class="row mb-3">
                <div class="col-6">
                    <p style='background: #3b5998; margin: 0; padding: 10px 20px; color: #fff;'>Import Data</p>
                    <div class="full pad-1em-2 hide-mode" align="left" style='border: 1px solid #ddd;padding: 10px 20px;background: #ecf0f1;'>
                        <div class="full clearfix border-a pad-1em gray">
                            <div class="free-1em clearfix">&nbsp;</div>
                            <form action="<?= base_url('stokbarang/importStok') ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                <div class='row m-bottom-10'>
                                    <div class='col-12'>
                                        <input class="form-control" type="file" id="file_stok" name="file_stok" accept=".xlsx">
                                        <button type="button" class="btn btn-secondary btnClose mt-4">Close</button>
                                        <span class='input-group-addon mt-4'><button type="submit" name="Submit" value="Upload" class="btn btn-success mt-4"><span class="fa fa-arrow-up">&nbsp;</span> Upload</button></span>
                                    </div>
                                </div>
                                <p class="mt-3">
                                    <?= $templateImport ?>
                                </p>
                            </form>
                        </div>
                        <div class="free-1em clearfix">&nbsp;</div>
                    </div>
                </div>
            </div>

            <?php if ($level == '0' || $level == '1') { ?>
                <a href="<?= base_url('stokbarang/addView') ?>" class="btn btn-primary">Tambah</a>
                <a class="btn btn-success" id="importData">Import</a>
            <?php } ?>

            <div class="table-responsive mt-4">
                <table class="table table-bordered" id="dataTable-data" width="100%">
                    <thead>
                        <tr>
                            <td width="4%" style="text-align: center;"><i class="bi bi-circle"></i></td>
                            <td width="10%" style="text-align: center;">Kode Barang </td>
                            <td width="25%" style="text-align: center;">Nama Barang</td>
                            <td width="20" style="text-align: center;">Kelompok Barang</td>
                            <td width="8" style="text-align: center;">Jumlah Stok</td>
                            <td width="10" style="text-align: center;">Harga Beli</td>
                            <td width="10" style="text-align: center;">Harga Jual</td>
                            <td width="10" style="text-align: center;">Harga Per Meter</td>
                            <?php if ($level == '0') { ?>
                                <td width="8%" style="text-align: center;"><i class="bi bi-gear-fill mr-2"></i></td>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($stokbarang as $sb) { ?>
                            <tr>
                                <td style="text-align: center;"><?= $no++ ?></td>
                                <td style="text-align: center;"><?= $sb->kode_barang ?></td>
                                <td><?= $sb->nama_barang ?></td>
                                <td><?= $sb->nama_kelompok ?></td>
                                <td style="text-align: center;"><?= $sb->stok ?> <?= $sb->satuan ?></td>
                                <td style="text-align: right;"><?= formatPrice($sb->harga_beli) ?></td>
                                <td style="text-align: right;"><?= formatPrice($sb->harga_jual) ?></td>
                                <td style="text-align: right;"><?= formatPrice($sb->harga_permeter) ?></td>

                                <?php if ($level == '0') { ?>
                                    <td style="text-align: center;">
                                        <a href="<?= base_url('stokbarang/editView/' . $sb->id) ?>" style="color: #3b5998;" title="Edit" class="mr-2"><i class="bi bi-pencil-square"></i></a>
                                        <?php $cekStok = $this->db->query("SELECT id_barang FROM t_pembelian_barang_detail WHERE id_barang = '$sb->id'");
                                        $cekStokk = $this->db->query("SELECT id_barang FROM t_invoice_detail WHERE id_barang = '$sb->id'");
                                        $cekStokkk = $this->db->query("SELECT id_barang FROM t_invoice_detail_kaca WHERE id_barang = '$sb->id'");
                                        if ($cekStok->num_rows() > 0 || $cekStokk->num_rows() > 0 || $cekStokkk->num_rows() > 0) { ?>
                                            <a href="#" style="color: #3b5998;" title="Hapus" class="tombolHapusV"><i class="bi bi-trash3-fill"></i></a>
                                        <?php } else { ?>
                                            <a href="#" style="color: #3b5998;" title="Hapus" class="tombolHapus" data-id="<?= $sb->id ?>"><i class="bi bi-trash3-fill"></i></a>
                                        <?php } ?>
                                    </td>
                                <?php } ?>

                            </tr>
                        <?php } ?>
                    </tbody>
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
        } else if (message == 'file kosong') {
            Swal.fire({
                title: "Silahkan upload file!",
                icon: "warning",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'format tidak sesuai') {
            Swal.fire({
                title: "Format tidak sesuai! Silahkan pilih format .xlsx",
                icon: "warning",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'no data') {
            Swal.fire({
                title: "Data kosong!",
                icon: "warning",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'required') {
            Swal.fire({
                title: "Salah satu data pada excel kosong! Silahkan lengkapi data.",
                icon: "error",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'berhasil import') {
            Swal.fire({
                title: "Import data berhasil!",
                icon: "success",
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
    $('#formImport').hide();

    $('.tombolHapus').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

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
                    url: "<?= base_url('stokbarang/hapusData') ?>",
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

    $('.tombolHapusV').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Barang ini tidak bisa dihapus!",
            text: "Barang sudah terdaftar pada pembelian barang atau penjualan",
            icon: "warning",
            showDenyButton: false,
            showCancelButton: false,
            confirmButtonText: "Ya",
            confirmButtonColor: "#3b5998",
        }).then((result) => {
            location.reload();
        });
    })

    $('#importData').on('click', function() {
        $('#formImport').show();
    })

    $('.btnClose').on('click', function() {
        $('#formImport').hide();
    })
</script>