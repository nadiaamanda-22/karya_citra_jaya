 <!-- Begin Page Content -->
 <div class="container-fluid">
     <div class="card shadow mb-4">
         <div class="card-header py-3">
             <p class="m-0">Tambah Pembelian Barang</p>
         </div>
         <div class="card-body">
             <div class="row">
                 <div class="col-md-9">
                     <form action="<?= base_url('pembelianbarang/addData') ?>" method="post">
                         <div class="mb-3">
                             <label for="pembelianbarang" class="form-label">Supplier *</label>
                             <input type="text" class="form-control" id="pembelianbarang" name="id_supplier">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Supplier harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="row align-items-start">
                                <div class="col">
                                    <label for="pembelianbarang" class="form-label">Tanggal *</label>
                                    <input type="date" class="form-control" id="pembelianbarang" name="tgl_pembelian">
                                </div>
                                <div class="col">
                                    <label for="stokbarang" class="form-label">Jatuh Tempo</label>
                                    <input type="date" class="form-control" id="pembelianbarang" name="jatuh_tempo">
                                </div>
                            </div>
                            <div class="row align-items-start pt-3">
                                <div class="col">
                                    <label for="pembelianbarang" class="form-label">Term</label>
                                    <input type="text" class="form-control" id="pembelianbarang" name="tgl_pembelian">
                                </div>
                                <div class="col">
                                    <label for="pembelianbarang" class="form-label">Status Pembayaran</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option >Lunas</option>
                                        <option >Belum Lunas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row align-items-start pt-3">
                            <div class="col">
                                    <label for="pembelianbarang" class="form-label">Metode Pembayaran</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option >Cash</option>
                                        <option >Transfer</option>
                                        <option >Debit</option>
                                    </select>
                                </div>
                            </div>
                         <div class="mb-5">
                             <small>[*] Kolom harus diisi</small>
                         </div>
                         <p>Silahkan Masukkan Barang</p>
                        
                         <div class="row g-3 pb-3">
                            <div class="col-sm">
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Kode Barang | Nama Barang">
                            </div>
                            <div class="col-sm">
                                <a href="#" class="btn btn-primary">Enter</a>
                            </div>
                        </div>
                        
                         <a href="<?= base_url('stokbarang') ?>" class="btn btn-danger">Batal</a>
                         <button type="submit" class="btn btn-primary">Simpan</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>