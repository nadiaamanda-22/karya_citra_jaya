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
                             <label for="kode_barang" class="form-label">Kode Barang *</label>
                             <input type="hidden" name="id" id="id" value="<? $stokbarang->id ?>" />
                             <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="<?= $stokbarang->kode_barang ?>" readonly>
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Kode barang harus diisi!</small>
                             <?php endif; ?>
                             <span style='font-size:12px;color:red' id="duplicate" hidden></span>
                         </div>
                         <div class="mb-3">
                             <label for="nama_barang" class="form-label">Nama Barang *</label>
                             <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= $stokbarang->nama_barang ?>">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Nama barang harus diisi!</small>
                             <?php endif; ?>
                         </div>

                         <div class="mb-3">
                             <label for="kelompok_barang" class="form-label">Kelompok Barang *</label>
                             <select name="id_kelompok" id="kelompok_barang" class="form-select" required>
                                 <option value="">--Pilih--</option>
                                 <?php foreach ($kelompokbarang as $value) : ?>
                                     <option value=" <?= $value->id_kelompok ?>" <?php if ($stokbarang->id_kelompok == $value->id_kelompok) { ?>selected="" <?php } ?>> <?= $value->nama_kelompok ?>
                                     <?php endforeach ?>
                                     </option>
                             </select>
                         </div>
                         <div class="row align-items-start">
                             <div class="col">
                                 <label for="stok" class="form-label">Jumlah Stok *</label>
                                 <input type="text" class="form-control numeric-only" id="stok" name="stok" value="<?= $stokbarang->stok ?>">
                                 <?php if ($this->session->flashdata('message', 'error')): ?>
                                     <small class="text-danger">Jumlah stok harus diisi!</small>
                                 <?php endif; ?>
                             </div>
                             <div class="col">
                                 <label for="satuan" class="form-label">Satuan</label>
                                 <input type="text" class="form-control" id="satuan" name="satuan" value="<?= $stokbarang->satuan ?>">
                             </div>
                             <div class="mb-3">
                                 <label for="harga_beli" class="form-label">Harga Beli *</label>
                                 <input type="text" class="form-control numeric-only iptPrice" id="harga_beli" name="harga_beli" value="<?= formatPrice($stokbarang->harga_beli) ?>">
                                 <?php if ($this->session->flashdata('message', 'error')): ?>
                                     <small class="text-danger">Harga beli harus diisi!</small>
                                 <?php endif; ?>
                             </div>
                             <div class="mb-3">
                                 <label for="harga_jual" class="form-label">Harga Jual *</label>
                                 <input type="text" class="form-control numeric-only iptPrice" id="harga_jual" name="harga_jual" value="<?= formatPrice($stokbarang->harga_jual) ?>">
                                 <?php if ($this->session->flashdata('message', 'error')): ?>
                                     <small class="text-danger">Harga jual harus diisi!</small>
                                 <?php endif; ?>
                             </div>
                             <div class="mb-3">
                                 <label for="harga_permeter" class="form-label">Harga Per Meter </label>
                                 <input type="text" class="form-control numeric-only iptPrice" id="harga_permeter" name="harga_permeter" value="<?= formatPrice($stokbarang->harga_permeter) ?>">
                             </div>
                             <div class="mb-5">
                                 <small>[*] Kolom harus diisi</small>
                             </div>
                             <div class="mb-3">
                                 <a href="<?= base_url('stokbarang') ?>" class="btn btn-danger">Batal</a>
                                 <button type="submit" class="btn btn-primary btnSimpan">Simpan</button>
                             </div>

                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <script>
     $('#kode_barang').keyup(function() {
         var kodeBarang = $('#kode_barang').val();
         var idStok = $('#id').val();
         $.post("<?= base_url() ?>Stokbarang/cekKodeBarang", {
             kodeBarang: kodeBarang,
             idStok: idStok
         }, function(data) {
             if (data.st == 1) {
                 $('#duplicate').removeAttr('hidden');
                 $('#duplicate').html('Kode barang sudah ada sebelumnya!');
                 $('.btnSimpan').prop('disabled', true)
             } else {
                 $('#duplicate').attr('hidden', true);
                 $('.btnSimpan').prop('disabled', false)
             }
         }, 'json');
     });
 </script>