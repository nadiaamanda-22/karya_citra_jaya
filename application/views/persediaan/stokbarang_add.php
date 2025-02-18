 <!-- Begin Page Content -->

 <head>
     <meta charset="UTF-8">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

 </head>
 <div class="container-fluid">
     <div class="card shadow mb-4">
         <div class="card-header py-3">
             <p class="m-0">Tambah Stok Barang</p>
         </div>
         <div class="card-body">
             <div class="row">
                 <div class="col-md-9">
                     <form action="<?= base_url('stokbarang/addData') ?>" method="post">
                         <div class="mb-3">
                             <label for="stokbarang" class="form-label">Kode Barang *</label>
                             <input type="text" class="form-control" id="stokbarang" name="kode_barang">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Kode barang harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-3">
                             <label for="stokbarang" class="form-label">Nama Barang *</label>
                             <input type="text" class="form-control" id="stokbarang" name="nama_barang">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Nama barang harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-3">
                             <label for="stokbarang" class="form-label">Kelompok Barang</label>
                             <select name="id_kelompok" id="stokbarang" class="form-control" required>
                                 <option value="nama_kelompok" selected disable>--Pilih Kelompok Barang--</option>
                                 <?php foreach ($kelompokbarang as $value) : ?>
                                     <option value="<?= $value->id_kelompok ?>"> <?= $value->nama_kelompok ?>
                                     <?php endforeach ?>
                                     </option>
                             </select>
                         </div>
                         <div class="row align-items-start mb-3">
                             <div class="col">
                                 <label for="stokbarang" class="form-label">Jumlah Stok *</label>
                                 <input type="text" class="form-control" id="stokbarang" name="stok" placeholder="0">
                             </div>
                             <div class="col">
                                 <label for="stokbarang" class="form-label">Satuan</label>
                                 <input type="text" class="form-control" id="stokbarang" name="satuan">
                             </div>
                         </div>
                         <div class="mb-3">
                             <label for="stokbarang" class="form-label">Harga Beli *</label>
                             <input type="text" class="form-control" id="stokbarang" name="harga_beli" placeholder="0">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Harga Beli harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-3">
                             <label for="stokbarang" class="form-label">Harga Jual *</label>
                             <input type="text" class="form-control" id="stokbarang" name="harga_jual" placeholder="0">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Harga Jual harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-3">
                             <label for="stokbarang" class="form-label">Harga Per meter </label>
                             <input type="text" class="form-control" id="stokbarang" name="harga_permeter" placeholder="0">
                         </div>
                         <div class="mb-5">
                             <small>[*] Kolom harus diisi</small>
                         </div>
                         <a href="<?= base_url('stokbarang') ?>" class="btn btn-danger">Batal</a>
                         <button type="submit" class="btn btn-primary">Simpan</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>