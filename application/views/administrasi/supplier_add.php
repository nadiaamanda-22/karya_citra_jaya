 <!-- Begin Page Content -->
 <div class="container-fluid">
     <div class="card shadow mb-4">
         <div class="card-header py-3">
             <p class="m-0">Tambah Supplier</p>
         </div>
         <div class="card-body">
             <div class="row">
                 <div class="col-md-9">
                     <form action="<?= base_url('supplier/addData') ?>" method="post">
                         <div class="mb-3">
                             <label for="supplier" class="form-label">Supplier *</label>
                             <input type="text" class="form-control" id="supplier" name="supplier">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Supplier harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-5">
                             <small>[*] Kolom harus diisai</small>
                         </div>
                         <a href="<?= base_url('supplier') ?>" class="btn btn-danger">Batal</a>
                         <button type="submit" class="btn btn-primary">Simpan</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>