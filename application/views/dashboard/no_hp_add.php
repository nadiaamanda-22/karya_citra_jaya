 <!-- Begin Page Content -->
 <div class="container-fluid">
     <div class="card shadow mb-4">
         <div class="card-header py-3">
             <p class="m-0">Tambah No Handphone</p>
         </div>
         <div class="card-body">
             <div class="row">
                 <div class="col-md-9">
                     <form action="<?= base_url('Nohandphone/addData') ?>" method="post">
                         <div class="mb-3">
                             <label for="no_hp" class="form-label">No Handphone *</label>
                             <input type="text" class="form-control numeric-only" id="no_hp" name="no_hp">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">No Handphone harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-5">
                             <small>[*] Kolom harus diisi</small>
                         </div>
                         <a href="<?= base_url('nohandphone') ?>" class="btn btn-danger">Batal</a>
                         <button type="submit" class="btn btn-primary">Simpan</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>