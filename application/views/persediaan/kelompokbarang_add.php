 <!-- Begin Page Content -->
 <div class="container-fluid">
     <div class="card shadow mb-4">
         <div class="card-header py-3">
             <p class="m-0">Tambah Kelompok Barang</p>
         </div>
         <div class="card-body">
             <div class="row">
                 <div class="col-md-9">
                     <form action="<?= base_url('kelompokbarang/addData') ?>" method="post">
                     <div class="mb-3">
                             <label for="kelompokbarang" class="form-label">Kode Barang *</label>
                             <input type="text" class="form-control" id="kelompokbarang" name="kode_kelompok">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Kode Barang harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-3">
                             <label for="kelompokbarang" class="form-label">Kelompok Barang *</label>
                             <input type="text" class="form-control" id="kelompokbarang" name="nama_kelompok">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Nama Kelompok harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-5">
                             <small>[*] Kolom harus diisi</small>
                         </div>
                         <a href="<?= base_url('kelompokbarang') ?>" class="btn btn-danger">Batal</a>
                         <button type="submit" class="btn btn-primary">Simpan</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>