<!-- Begin Page Content -->
<div class="container-fluid">
     <div class="card shadow mb-4">
         <div class="card-header">
            <div class=" position-absolute top-0 end-0">
         <a href="<?= base_url('Nohandphone') ?>" class="btn btn-dark">Setting No.Handphone</a> 
         </div>
             <p class="m-0">Pengaturan</p>
         </div>
         
         <div class="card-body">
             <div class="row">
                 <div class="col-md-9">
                     <form action="<?= base_url('pengaturan') ?>" method="post">
                         <div class="mb-3">
                             <label for="nama_toko" class="form-label">Nama *</label>
                             <input type="text" class="form-control" id="pengaturan" name="nama_toko">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Nama harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-3">
                             <label for="no_telp" class="form-label">No Telp *</label>
                             <input type="text" class="form-control" id="pengaturan" name="no_telp">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">No Handphone harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-3">
                             <label for="no_hp" class="form-label">No Hp *</label>
                             <input type="text" class="form-control" id="pengaturan" name="no_hp">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">No Handphone harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-3">
                             <label for="alamat" class="form-label">Alamat *</label>
                             <input type="text" class="form-control" id="cpengaturan" name="alamat">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Alamat harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-3">
                             <label for="ttd" class="form-label">Tanda Tangan</label>
                             <input type="file" class="form-control" id="ttd" name="ttd">
                         </div>
                         <div class="mb-3">
                             <label for="alamat" class="form-label">Stempel</label>
                             <input type="file" class="form-control" id="customer" name="stempel">
                         </div>
                         <div class="row align-items-start">
                            <div class="col">
                             <label for="alamat" class="form-label">Copy Print</label>
                             <select class="form-select" aria-label="Default select example">
                            <option selected>Pilih</option>
                                <option value="1">Enable</option>
                                <option value="2">Disable</option>
                            </select>
                            </div>
                            <div class="col">
                            <label for="alamat" class="form-label">Format Price</label>
                            <select class="form-select" aria-label="Default select example">
                            <option selected>Pilih</option>
                                <option value="1">Desimal</option>
                                <option value="2">Pecahan</option>
                            </select>
                            </div>
                            </div>
                         <div class="mb-3 py-4">
                             <small>[*] Kolom harus diisi</small>
                         </div>
                         
                         <a href="<?= base_url('customer') ?>" class="btn btn-danger">Batal</a>
                         <button type="submit" class="btn btn-primary">Simpan</button>
                     </form>
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
