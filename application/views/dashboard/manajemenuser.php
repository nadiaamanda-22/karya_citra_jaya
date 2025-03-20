<?php
$levelUser = $this->session->userdata('level');
$loginUser = $this->session->userdata('id_user');
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if ($levelUser == '0' || $levelUser == '1') { ?>
                <a href="<?= base_url('Manajemenuser/addManajemenUser') ?>" class="btn btn-primary">Tambah</a>
            <?php } ?>

            <div class="table-responsive mt-4">
                <table class="table table-bordered" id="dataTable-data" width="100%">
                    <thead>
                        <tr>
                            <td width="8%" style="text-align: center;"><i class="bi bi-circle"></i></td>
                            <td style="text-align: center;">Nama</td>
                            <td width="20%" style="text-align: center;">Username</td>
                            <td width="20%" style="text-align: center;">Level</td>
                            <?php if ($levelUser == '0') { ?>
                                <td width="10%" style="text-align: center;"> <i class="bi bi-gear-fill mr-2"></i></td>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($user as $r) {
                            if ($r->level == '0') {
                                $level = "Add/Edit/Delete";
                            } else if ($r->level == '1') {
                                $level = 'Add';
                            } else {
                                $level = 'Read';
                            }
                        ?>
                            <tr>
                                <td style="text-align: center;"><?= $no++ ?></td>
                                <td><?= $r->nama_user ?></td>
                                <td style="text-align: center;"><?= $r->username ?></td>
                                <td style="text-align: center;"><?= $level ?></td>
                                <?php if ($levelUser == '0') { ?>
                                    <td style="text-align: center;">
                                        <?php if ($loginUser == '1') { ?>
                                            <a href="<?= base_url('manajemenuser/editView/' . $r->id_user) ?>" style="color: #3b5998;" title="Edit" class="mr-2"><i class="bi bi-pencil-square"></i></a>
                                        <?php } ?>
                                        <?php if ($r->id_user != '1') { ?>
                                            <a href="#" style="color: #3b5998;" title="Hapus" class="tombolHapus" data-id="<?= $r->id_user ?>"><i class="bi bi-trash3-fill" disabled></i></a>
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
                    url: "<?= base_url('manajemenuser/hapusData') ?>",
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