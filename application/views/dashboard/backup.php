<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <a href="<?= base_url('backup/backupProses') ?>" class="btn btn-primary">
                <i class="bi bi-cloud-arrow-down"></i> Backup
            </a>

            <button type="button" class="btn btn-warning ml-2" data-bs-toggle="modal" data-bs-target="#restoreModal">
                <i class="bi bi-arrow-clockwise"></i> Restore
            </button>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="restoreModalLabel">Restore Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('backup/restoreProses') ?>" enctype="multipart/form-data" method="post">
                    <div class="mb-3">
                        <label for="database" class="form-label">Silahkan upload database (dalam format sql)</label>
                        <input type="file" class="form-control" id="database" name="database">
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Restore</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('message')) { ?>
    <script>
        var message = "<?= $this->session->flashdata('message') ?>";
        if (message == 'berhasil') {
            Swal.fire({
                title: "Restore berhasil!",
                icon: "success",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'null') {
            Swal.fire({
                title: "Terjadi kesalahan",
                text: "Tidak ada data yang di input!",
                icon: "warning",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else if (message == 'formatted') {
            Swal.fire({
                title: "Terjadi kesalahan",
                text: "Format harus berupa .sql",
                icon: "warning",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        } else {
            Swal.fire({
                title: "Restore gagal!",
                icon: "error",
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Ya",
                confirmButtonColor: "#3b5998",
            });
        }
    </script>
<?php } ?>