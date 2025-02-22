 <div class="container-fluid">
     <div class="card shadow mb-4">
         <div class="card-header py-3">
             <p class="m-0">Tambah Stok Barang</p>
         </div>
         <div class="card-body">
             <div class="row">
                 <div class="col-md-12">
                     <form action="<?= base_url('stokbarang/addData') ?>" method="post">
                         <div class="mb-3">
                             <label for="kode_barang" class="form-label">Kode Barang *</label>
                             <input type="hidden" name="id" id="id" value="" />
                             <input type="text" class="form-control" id="kode_barang" name="kode_barang">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Kode barang harus diisi!</small>
                             <?php endif; ?>
                             <span style='font-size:12px;color:red' id="duplicate" hidden></span>
                         </div>
                         <div class="mb-3">
                             <label for="nama_barang" class="form-label">Nama Barang *</label>
                             <input type="text" class="form-control" id="nama_barang" name="nama_barang">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Nama barang harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-3">
                             <label for="kelompok_barang" class="form-label">Kelompok Barang</label>
                             <select name="id_kelompok" id="kelompok_barang" class="form-control">
                                 <?php foreach ($kelompokbarang as $value) : ?>
                                     <option value="<?= $value->id_kelompok ?>"> <?= $value->nama_kelompok ?>
                                     <?php endforeach ?>
                                     </option>
                             </select>
                         </div>
                         <div class="row align-items-start mb-3">
                             <div class="col">
                                 <label for="stok" class="form-label">Jumlah Stok *</label>
                                 <input type="text" class="form-control numeric-only" id="stok" name="stok" placeholder="0" maxlength="4">
                                 <?php if ($this->session->flashdata('message', 'error')): ?>
                                     <small class="text-danger">Jumlah stok harus diisi!</small>
                                 <?php endif; ?>
                             </div>
                             <div class="col">
                                 <label for="satuan" class="form-label">Satuan</label>
                                 <input type="text" class="form-control" id="satuan" name="satuan">
                             </div>
                         </div>
                         <div class="mb-3">
                             <label for="harga_beli" class="form-label">Harga Beli *</label>
                             <input type="text" class="form-control numeric-only iptPrice" id="harga_beli" name="harga_beli" placeholder="0">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Harga beli harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-3">
                             <label for="harga_jual" class="form-label">Harga Jual *</label>
                             <input type="text" class="form-control numeric-only iptPrice" id="harga_jual" name="harga_jual" placeholder="0">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Harga jual harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-3">
                             <label for="harga_permeter" class="form-label">Harga Per meter </label>
                             <input type="text" class="form-control numeric-only iptPrice" id="harga_permeter" name="harga_permeter" placeholder="0">
                         </div>
                         <div class="mb-5">
                             <small>[*] Kolom harus diisi</small>
                         </div>
                         <a href="<?= base_url('stokbarang') ?>" class="btn btn-danger">Batal</a>
                         <button type="submit" class="btn btn-primary btnSimpan">Simpan</button>
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