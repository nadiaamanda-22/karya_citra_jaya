<?php
$level = $this->session->userdata('level');
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if ($level == '0' || $level == '1') { ?>
                <a href="<?= base_url('customer/addView') ?>" class="btn btn-primary">Tambah</a>
            <?php } ?>
            <div class="table-responsive mt-4">
                <table class="table table-bordered" id="dataTable-data" width="100%">
                    <thead>
                        <tr>
                            <td width="8%" style="text-align: center;"><i class="bi bi-circle"></i></td>
                            <td width="28%" style="text-align: center;">Nama </td>
                            <td width="18%" style="text-align: center;">No Handphone</td>
                            <td width="38" style="text-align: center;">Alamat</td>
                            <?php if ($level == '0') { ?>
                                <td width="8%" style="text-align: center;"><i class="bi bi-gear-fill mr-2"></i></td>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($customer as $c) { ?>
                            <tr>
                                <td style="text-align: center;"><?= $no++ ?></td>
                                <td><?= $c->nama_customer ?></td>
                                <td style="text-align: center;"><?= $c->no_hp ?></td>
                                <td><?= $c->alamat ?></td>
                                <?php if ($level == '0') { ?>
                                    <td style="text-align: center;">
                                        <a href="<?= base_url('customer/editView/' . $c->id_customer) ?>" style="color: #3b5998;" title="Edit" class="mr-2"><i class="bi bi-pencil-square"></i></a>
                                        <a href="#" style="color: #3b5998;" title="Hapus" class="tombolHapus" data-id="<?= $c->id_customer ?>"><i class="bi bi-trash3-fill"></i></a>
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
                    url: "<?= base_url('customer/hapusData') ?>",
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