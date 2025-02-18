 <!-- Begin Page Content -->
 <div class="container-fluid">
     <div class="card shadow mb-4">
         <div class="card-header py-3">
             <p class="m-0">Edit Stok Barang</p>
         </div>
         <div class="card-body">
             <div class="row">
                 <div class="col-md-12">
                     <form action="<?= base_url('stokbarang/editData/' . $stokbarang->id) ?>" method="post">
                     <div class="mb-3">
                             <label for="kodebarang" class="form-label">Kode Barang *</label>
                             <input type="text" class="form-control" id="stokbarang" name="kode_barang" value="<?= $stokbarang->kode_barang ?>">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Kode Barang harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-3">
                             <label for="namabarang" class="form-label">Nama Barang *</label>
                             <input type="text" class="form-control" id="stokbarang" name="nama_barang" value="<?= $stokbarang->nama_barang ?>">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Nama Barang harus diisi!</small>
                             <?php endif; ?>
                         </div>
                       
                         <div class="mb-3">
                             <label for="kelompokbarang" class="form-label">Kelompok Barang *</label>
                                <select name="id_kelompok" id="stokbarang" class="form-control" required>
                                    <option value="">--Pilih--</option>
                                        <?php foreach($kelompokbarang as $value) : ?>
                                            <option value=" <?= $value->id_kelompok ?>" <?php if ($stokbarang->id_kelompok==$value->id_kelompok){?>selected=""<?php } ?>> <?=$value->nama_kelompok?>
                                        <?php endforeach ?>
                                    </option>
                                </select>
                         </div>
                         <div class="row align-items-start">
                                <div class="col">
                                    <label for="jumlahstok" class="form-label">Jumlah Stok *</label>
                                        <input type="text" class="form-control" id="stokbarang" name="stok" value="<?= $stokbarang->stok ?>">
                                        <?php if ($this->session->flashdata('message', 'error')): ?>
                                            <small class="text-danger">Jumlah Stok harus diisi!</small>
                                        <?php endif; ?>
                                </div>
                                <div class="col">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="text" class="form-control" id="stokbarang" name="satuan" value="<?= $stokbarang->satuan ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="hargabeli" class="form-label">Harga Beli *</label>
                                        <input type="text" class="form-control" id="stokbarang" name="harga_beli" value="<?= $stokbarang->harga_beli ?>">
                                        <?php if ($this->session->flashdata('message', 'error')): ?>
                                            <small class="text-danger">Harga Beli harus diisi!</small>
                                        <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="hargajual" class="form-label">Harga Jual *</label>
                                        <input type="text" class="form-control" id="stokbarang" name="harga_jual" value="<?= $stokbarang->harga_jual ?>">
                                        <?php if ($this->session->flashdata('message', 'error')): ?>
                                            <small class="text-danger">Harga Jual harus diisi!</small>
                                        <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="hargapermeter" class="form-label">Harga Per meter </label>
                                    <input type="text" class="form-control" id="stokbarang" name="harga_permeter" value="<?= $stokbarang->harga_permeter ?>">
                                </div>
                                <div class="mb-5">
                                    <small>[*] Kolom harus diisi</small>
                                </div>
                                <div class="mb-3">
                                <a href="<?= base_url('stokbarang') ?>" class="btn btn-danger">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                                    
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>