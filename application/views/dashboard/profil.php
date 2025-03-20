<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <div class="alert alert-warning">
                <h6 align="center"><i class="icon fa fa-info"></i> Perhatian!</h6>
                <small>Kolom dengan tanda [*] harus diisi</small>
                <br><small>Password minimal 5 karakter</small>
                <br><small>Password harus mengandung setidaknya 1 huruf kapital</small>
                <br><small> Password harus mengandung minimal 1 angka</small>
                <br><small> Password harus mengandung minimal 1 karakter khusus ( _ atau - atau !)</small>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header">
            <p class="m-0">Profil</p>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?= base_url('profil/editProfil/' . $user->id_user) ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama_user" class="form-label">Nama *</label>
                            <?php if ($user->id_user == '1') { ?>
                                <input type="text" class="form-control" id="nama_user" name="nama_user" value="<?= $user->nama_user ?>" readonly>
                            <?php } else { ?>
                                <input type="text" class="form-control" id="nama_user" name="nama_user" value="<?= $user->nama_user ?>">
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username *</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $user->username ?>">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password *</label>
                            <input type="text" class="form-control" id="password" name="password" value="<?= $user->password ?>">
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <img src="<?= base_url('assets/img/user/' . $user->image) ?>" class="img-fluid" style="max-width:90%;">
                                </div>
                                <div class="col-10 mt-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('message')) { ?>
    <script>
        var message = "<?= $this->session->flashdata('message') ?>";
        if (message == 'berhasil ubah') {
            Swal.fire({
                title: "Profil berhasil diubah!",
                icon: "success",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'karakter kurang') {
            Swal.fire({
                title: "Password minimal 5 karakter!",
                icon: "warning",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'required') {
            Swal.fire({
                title: "Kolom dengan tanda [*] harus diisi!",
                icon: "warning",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'kapital') {
            Swal.fire({
                title: "Password harus mengandung setidaknya 1 huruf kapital!",
                icon: "warning",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'angka') {
            Swal.fire({
                title: "Password harus mengandung minimal 1 angka!",
                icon: "warning",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'karakter khusus') {
            Swal.fire({
                title: "Password harus mengandung minimal 1 karakter khusus ( _ atau - atau !)",
                icon: "warning",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'menu') {
            Swal.fire({
                title: "Minimal ada 1 menu yang dipilih!",
                icon: "warning",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'error') {
            Swal.fire({
                title: "Terjadi kesalahan!",
                text: 'Silahkan inputkan ulang, username dan password tidak boleh kosong!',
                icon: "error",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        }
    </script>
<?php } ?>