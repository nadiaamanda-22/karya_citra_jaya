 <!-- Begin Page Content -->
 <div class="container-fluid">
     <div class="card shadow mb-4">
         <div class="card-header py-3">
             <p class="m-0">Edit Rekening</p>
         </div>
         <div class="card-body">
             <div class="row">
                 <div class="col-md-9">
                     <form action="<?= base_url('rekening/editData/' . $rekening->id_rekening) ?>" method="post">
                         <div class="mb-3">
                             <label for="rekening" class="form-label">Rekening *</label>
                             <input type="text" class="form-control" id="rekening" name="rekening" value="<?= $rekening->rekening ?>">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Rekening harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-5">
                             <small>[*] Kolom harus diisi</small>
                         </div>
                         <a href="<?= base_url('rekening') ?>" class="btn btn-danger">Batal</a>
                         <button type="submit" class="btn btn-primary">Simpan</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>