<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <p class="m-0">Pengaturan</p>
                </div>
                <div class="col-6 text-right">
                    <a href="<?= base_url('Nohandphone') ?>" class="btn btn-dark">Setting No Handphone</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?= base_url('pengaturan/updatePengaturan') ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama_toko" class="form-label">Nama Toko *</label>
                            <input type="text" class="form-control" id="nama_toko" name="nama_toko" value="<?= $pengaturan->nama_toko ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">No Telp *</label>
                            <input type="text" class="form-control" id="pengaturan" name="no_telp" value="<?= $pengaturan->no_telp ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No Hp *</label>
                            <select id="id_no_hp" name="id_no_hp[]" class="form-control select2" multiple="multiple">
                                <?php
                                $selected_values = explode(',', $pengaturan->id_no_hp ?? '');
                                $getNoHp = $this->db->query("SELECT * FROM t_no_hp")->result();
                                foreach ($getNoHp as $gb) { ?>
                                    <option value="<?= $gb->id ?>" <?= in_array($gb->id, $selected_values ?? []) ? 'selected' : '' ?>><?= $gb->no_hp ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class=" mb-3">
                            <label for="alamat" class="form-label">Alamat *</label>
                            <textarea name="alamat" id="alamat" class="form-control"><?= $pengaturan->alamat ?? '' ?></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <img src="<?= isset($pengaturan->ttd) ? base_url('assets/img/setting/' . $pengaturan->ttd) : base_url('assets/img/setting/no-image.jpg') ?>" class="img-fluid" style="max-width:90%;">
                                </div>
                                <div class="col-10 mt-3">
                                    <label for="ttd" class="form-label">Tanda Tangan</label>
                                    <input type="file" class="form-control" id="ttd" name="ttd">
                                </div>
                            </div>
                            <div class="mt-3 mb-3">
                                <div class="row">
                                    <div class="col-2">
                                        <img src="<?= isset($pengaturan->stempel) ? base_url('assets/img/setting/' . $pengaturan->stempel) : base_url('assets/img/setting/no-image.jpg') ?>" class="img-fluid" style="max-width:90%;">
                                    </div>
                                    <div class="col-10 mt-3">
                                        <label for="stempel" class="form-label">Stempel</label>
                                        <input type="file" class="form-control" id="stempel " name="stempel">
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-start">
                                <div class="col">
                                    <label for="copy_print" class="form-label">Copy Print</label>
                                    <select class="form-select" name="copy_print">
                                        <option value="0" <?= ($pengaturan->copy_nota ?? '') == '0' ? 'selected' : '' ?>>Enable</option>
                                        <option value="1" <?= ($pengaturan->copy_nota ?? '') == '1' ? 'selected' : '' ?>>Disable</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="max_detail_input" class="form-label">Max Detail Input *</label>
                                    <input type="text" class="form-control" id="pengaturan" name="max_detail_input" value="<?= $pengaturan->max_detail_input ?? '' ?>">
                                </div>
                            </div>
                            <div class="mb-3 py-4">
                                <small>[*] Kolom harus diisi</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php if ($this->session->flashdata('message')) { ?>
        <script>
            var message = "<?= $this->session->flashdata('message') ?>";
            if (message == 'berhasil ubah') {
                Swal.fire({
                    title: "Data berhasil diubah!",
                    icon: "success",
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: "Ya",
                    confirmButtonColor: "#3b5998",
                });
            } else if (message == 'data kosong') {
                Swal.fire({
                    title: "Terjadi kesalahan!",
                    text: "Kolom [*] harus diisi",
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
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Silahkan pilih no handphone",
                allowClear: true
            });
        });
    </script>