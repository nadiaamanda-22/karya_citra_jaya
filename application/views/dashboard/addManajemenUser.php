 <!-- Begin Page Content -->
 <div class="container-fluid">
     <div class="row">
         <div class="col-6">
             <div class="alert alert-warning">
                 <h6 align="center"><i class="icon fa fa-info"></i> Perhatian!</h6>
                 <small>Kolom dengan tanda [*] harus diisi</small>
                 <br><small>Password minimal 5 karakter</small>
                 <br><small>Password harus mengandung setidaknya 1 huruf kapital</small>
                 <br><small> Password harus mengandung minimal 1 angka</small>
                 <br><small> Password harus mengandung minimal 1 karakter khusus ( _ atau - atau !)</small>
                 <br><small> Minimal ada 1 menu yang dipilih</small>
             </div>
         </div>
     </div>
     <div class="card shadow mb-4">
         <div class="card-header py-3">
             <p class="m-0">Tambah User</p>
         </div>
         <div class="card-body">
             <div class="row">
                 <div class="col-md-12">
                     <form action="<?= base_url('manajemenuser/addUser') ?>" method="post" enctype="multipart/form-data">
                         <div class="mb-3">
                             <label for="nama_user" class="form-label">Nama *</label>
                             <input type="text" class="form-control" id="nama_user" name="nama_user">
                         </div>
                         <div class="mb-3">
                             <div class="row">
                                 <div class="col-6">
                                     <label for="username" class="form-label">Username *</label>
                                     <input type="text" class="form-control" id="username" name="username">
                                 </div>

                                 <div class="col-6">
                                     <label for="password" class="form-label">Password *</label>
                                     <input type="text" class="form-control" id="password" name="password">
                                 </div>
                             </div>
                         </div>
                         <div class="mb-3">
                             <div class="row">
                                 <div class="col-6">
                                     <label for="level" class="form-label">Level</label>
                                     <select class="form-select mb-3" name="level" id="level">
                                         <option value="0">Add/Edit/Delete</option>
                                         <option value="1">Add</option>
                                         <option value="2">Read</option>
                                     </select>
                                 </div>

                                 <div class="col-6">
                                     <label for="role" class="form-label">Role</label>
                                     <select class="form-select mb-3" name="role" id="role">
                                         <option value="1">Not Admin</option>
                                         <option value="0">Admin</option>
                                     </select>
                                 </div>
                             </div>
                         </div>
                         <div class="mb-3">
                             <label for="image" class="form-label">Image</label>
                             <input type="file" class="form-control" id="image" name="image">
                         </div>
                         <div class="mb-3 mt-5">
                             <p>Hak Akses User</p>
                         </div>
                         <div class="mb-3">
                             <div class="row">
                                 <div class="col-4">
                                     <div class="form-check">
                                         <input type="checkbox" class="form-check-input menu" id="dashboard" name="menu[]" value="1">
                                         <label class="form-check-label" for="dashboard">Dashboard</label>
                                     </div>
                                     <div class="form-check">
                                         <input type="checkbox" class="form-check-input menu" id="invoice" name="menu[]" value="2">
                                         <label class="form-check-label" for="invoice">Invoice</label>
                                     </div>
                                     <div class="form-check">
                                         <input type="checkbox" class="form-check-input menu" id="stok_barang" name="menu[]" value="3">
                                         <label class="form-check-label" for="stok_barang">Stok Barang</label>
                                     </div>
                                     <div class="form-check">
                                         <input type="checkbox" class="form-check-input menu" id="kelompok_barang" name="menu[]" value="4">
                                         <label class="form-check-label" for="kelompok_barang">Kelompok Barang</label>
                                     </div>
                                 </div>

                                 <div class="col-4">
                                     <div class="form-check">
                                         <input type="checkbox" class="form-check-input menu" id="pembelian_barang" name="menu[]" value="5">
                                         <label class="form-check-label" for="pembelian_barang">Pembelian Barang</label>
                                     </div>
                                     <div class="form-check">
                                         <input type="checkbox" class="form-check-input menu" id="customer" name="menu[]" value="6">
                                         <label class="form-check-label" for="customer">Customer</label>
                                     </div>
                                     <div class="form-check">
                                         <input type="checkbox" class="form-check-input menu" id="supplier" name="menu[]" value="7">
                                         <label class="form-check-label" for="supplier">Supplier</label>
                                     </div>
                                     <div class="form-check">
                                         <input type="checkbox" class="form-check-input menu" id="rekening" name="menu[]" value="8">
                                         <label class="form-check-label" for="rekening">Rekening Barang</label>
                                     </div>
                                 </div>
                                 <div class="col-4">
                                     <div class="form-check">
                                         <input type="checkbox" class="form-check-input menu" id="lap_invoice" name="menu[]" value="9">
                                         <label class="form-check-label" for="lap_invoice">Laporan Invoice</label>
                                     </div>
                                     <div class="form-check">
                                         <input type="checkbox" class="form-check-input menu" id="lap_pembelian" name="menu[]" value="10">
                                         <label class="form-check-label" for="lap_pembelian">Laporan Pembelian Barang</label>
                                     </div>
                                     <div class="form-check">
                                         <input type="checkbox" class="form-check-input menu" id="lap_stok" name="menu[]" value="11">
                                         <label class="form-check-label" for="lap_stok">Laporan Stok Barang</label>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="row">
                             <div class="md-12">
                                 <div class="checkAll" style="text-align: left; padding:10px;">
                                     <button name="cmdselectall" type="button" onClick="checkAll()" class="btn btn-secondary"><span class="fa fa-check-square">&nbsp;</span>Pilih Semua</button> &nbsp;
                                     <button name="cmddeselect" type="button" onClick="uncheckAll()" class="btn btn-secondary"><span class="fa fa-square-o">&nbsp;</span>Reset</button>
                                 </div>
                             </div>
                         </div>


                         <div class="mt-5">
                             <a href="<?= base_url('manajemenuser') ?>" class="btn btn-danger">Batal</a>
                             <button type="submit" class="btn btn-primary">Simpan</button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <?php if ($this->session->flashdata('message')) { ?>
     <script>
         var message = "<?= $this->session->flashdata('message') ?>";
         if (message == 'karakter kurang') {
             Swal.fire({
                 title: "Password minimal 5 karakter!",
                 icon: "warning",
                 showDenyButton: false,
                 showCancelButton: false,
                 confirmButtonText: "Ya",
                 confirmButtonColor: "#3b5998",
             });
         } else if (message == 'required') {
             Swal.fire({
                 title: "Kolom dengan tanda [*] harus diisi!",
                 icon: "warning",
                 showDenyButton: false,
                 showCancelButton: false,
                 confirmButtonText: "Ya",
                 confirmButtonColor: "#3b5998",
             });
         } else if (message == 'kapital') {
             Swal.fire({
                 title: "Password harus mengandung setidaknya 1 huruf kapital!",
                 icon: "warning",
                 showDenyButton: false,
                 showCancelButton: false,
                 confirmButtonText: "Ya",
                 confirmButtonColor: "#3b5998",
             });
         } else if (message == 'angka') {
             Swal.fire({
                 title: "Password harus mengandung minimal 1 angka!",
                 icon: "warning",
                 showDenyButton: false,
                 showCancelButton: false,
                 confirmButtonText: "Ya",
                 confirmButtonColor: "#3b5998",
             });
         } else if (message == 'karakter khusus') {
             Swal.fire({
                 title: "Password harus mengandung minimal 1 karakter khusus ( _ atau - atau !)",
                 icon: "warning",
                 showDenyButton: false,
                 showCancelButton: false,
                 confirmButtonText: "Ya",
                 confirmButtonColor: "#3b5998",
             });
         } else if (message == 'menu') {
             Swal.fire({
                 title: "Minimal ada 1 menu yang dipilih!",
                 icon: "warning",
                 showDenyButton: false,
                 showCancelButton: false,
                 confirmButtonText: "Ya",
                 confirmButtonColor: "#3b5998",
             });
         } else if (message == 'warning') {
             Swal.fire({
                 title: "Username dan password tidak diperbolehkan!",
                 icon: "warning",
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
     $(document).ready(function() {
         $('.menu').change(function() {
             if ($(this).is(":checked")) {
                 $(this).val(); // Jika diceklis, nilainya adalah id_menu
             } else {
                 $(this).val(0); // Jika tidak diceklis, ubah menjadi 0
             }
         });
     });

     function checkAll() {
         $(".menu").prop("checked", true);
     }

     function uncheckAll() {
         $(".menu").prop("checked", false);
     }
 </script>