 <?php
    $selectedMenu = array_column($menu_user, 'id_menu');
    ?>

 <!-- Begin Page Content -->
 <div class="container-fluid">
     <div class="card shadow mb-4">
         <div class="card-header py-3">
             <p class="m-0">Edit User</p>
         </div>
         <div class="card-body">
             <div class="row">
                 <div class="col-md-12">
                     <form action="<?= base_url('manajemenuser/editData/' . $user->id_user) ?>" method="post" enctype="multipart/form-data">
                         <div class="mb-3">
                             <label for="nama_user" class="form-label">Nama *</label>
                             <input type="text" class="form-control" id="nama_user" name="nama_user" value="<?= $user->nama_user ?>">
                             <?php if ($this->session->flashdata('message', 'error')): ?>
                                 <small class="text-danger">Nama harus diisi!</small>
                             <?php endif; ?>
                         </div>
                         <div class="mb-3">
                             <div class="row">
                                 <div class="col-6">
                                     <label for="username" class="form-label">Username *</label>
                                     <input type="text" class="form-control" id="username" name="username" value="<?= $user->username ?>">
                                     <?php if ($this->session->flashdata('message', 'error')): ?>
                                         <small class="text-danger">Username harus diisi!</small>
                                     <?php endif; ?>
                                 </div>

                                 <div class="col-6">
                                     <label for="password" class="form-label">Password *</label>
                                     <input type="text" class="form-control" id="password" name="password" value="<?= $user->password ?>">
                                     <?php if ($this->session->flashdata('message', 'error')): ?>
                                         <small class="text-danger">Password harus diisi!</small>
                                     <?php endif; ?>
                                 </div>
                             </div>
                         </div>
                         <div class="mb-3">
                             <div class="row">
                                 <div class="col-6">
                                     <label for="level" class="form-label">Level</label>
                                     <select class="form-select mb-3" name="level" id="level">
                                         <option value="0" <?= $user->level == '0' ? 'selected' : '' ?>>Add/Edit/Delete</option>
                                         <option value="1" <?= $user->level == '1' ? 'selected' : '' ?>>Add</option>
                                         <option <?= $user->level == '2' ? 'selected' : '' ?>>Read</option>
                                     </select>
                                 </div>

                                 <div class="col-6">
                                     <label for="role" class="form-label">Role</label>
                                     <select class="form-select mb-3" name="role" id="role" onchange="selectRole(this)">
                                         <option value="1" <?= $user->role == '1' ? 'selected' : '' ?>>Not Admin</option>
                                         <option value="0" <?= $user->role == '0' ? 'selected' : '' ?>>Admin</option>
                                     </select>
                                 </div>
                             </div>
                         </div>
                         <div class="mb-3">
                             <label for="image" class="form-label">Image</label>
                             <div class="row">
                                 <div class="col-2">
                                     <img src="<?= base_url('assets/img/user/' . $user->image) ?>" class="img-fluid" style="max-width:70%;">
                                 </div>
                                 <div class="col-10">
                                     <input type="file" class="form-control" id="image" name="image">
                                 </div>
                             </div>
                             <div class="mt-4">
                                 <small>[*] Kolom harus diisai</small>
                             </div>
                             <div class="mt-3">
                                 <p>Hak Akses User</p>
                             </div>
                             <div class="mb-3">
                                 <div class="row">
                                     <div class="col-4">
                                         <div class="form-check">
                                             <input type="checkbox" class="form-check-input menu" id="dashboard" name="menu[]" value="10" <?= in_array(10, $selectedMenu) ? 'checked' : '' ?>>
                                             <label class="form-check-label" for="dashboard">Dashboard</label>
                                         </div>
                                         <div class="form-check">
                                             <input type="checkbox" class="form-check-input menu" id="invoice" name="menu[]" value="11" <?= in_array(11, $selectedMenu) ? 'checked' : '' ?>>
                                             <label class="form-check-label" for="invoice">Invoice</label>
                                         </div>
                                         <div class="form-check">
                                             <input type="checkbox" class="form-check-input menu" id="stok_barang" name="menu[]" value="1" <?= in_array(1, $selectedMenu) ? 'checked' : '' ?>>
                                             <label class="form-check-label" for="stok_barang">Stok Barang</label>
                                         </div>
                                         <div class="form-check">
                                             <input type="checkbox" class="form-check-input menu" id="kelompok_barang" name="menu[]" value="2" <?= in_array(2, $selectedMenu) ? 'checked' : '' ?>>
                                             <label class="form-check-label" for="kelompok_barang">Kelompok Barang</label>
                                         </div>
                                     </div>

                                     <div class="col-4">
                                         <div class="form-check">
                                             <input type="checkbox" class="form-check-input menu" id="pembelian_barang" name="menu[]" value="3" <?= in_array(3, $selectedMenu) ? 'checked' : '' ?>>
                                             <label class="form-check-label" for="pembelian_barang">Pembelian Barang</label>
                                         </div>
                                         <div class="form-check">
                                             <input type="checkbox" class="form-check-input menu" id="customer" name="menu[]" value="4" <?= in_array(4, $selectedMenu) ? 'checked' : '' ?>>
                                             <label class="form-check-label" for="customer">Customer</label>
                                         </div>
                                         <div class="form-check">
                                             <input type="checkbox" class="form-check-input menu" id="supplier" name="menu[]" value="5" <?= in_array(5, $selectedMenu) ? 'checked' : '' ?>>
                                             <label class="form-check-label" for="supplier">Supplier</label>
                                         </div>
                                         <div class="form-check">
                                             <input type="checkbox" class="form-check-input menu" id="rekening" name="menu[]" value="6" <?= in_array(6, $selectedMenu) ? 'checked' : '' ?>>
                                             <label class="form-check-label" for="rekening">Rekening Barang</label>
                                         </div>
                                     </div>
                                     <div class="col-4">
                                         <div class="form-check">
                                             <input type="checkbox" class="form-check-input menu" id="lap_invoice" name="menu[]" value="7" <?= in_array(7, $selectedMenu) ? 'checked' : '' ?>>
                                             <label class="form-check-label" for="lap_invoice">Laporan Invoice</label>
                                         </div>
                                         <div class="form-check">
                                             <input type="checkbox" class="form-check-input menu" id="lap_pembelian" name="menu[]" value="8" <?= in_array(8, $selectedMenu) ? 'checked' : '' ?>>
                                             <label class="form-check-label" for="lap_pembelian">Laporan Pembelian Barang</label>
                                         </div>
                                         <div class="form-check">
                                             <input type="checkbox" class="form-check-input menu" id="lap_stok" name="menu[]" value="9" <?= in_array(9, $selectedMenu) ? 'checked' : '' ?>>
                                             <label class="form-check-label" for="lap_stok">Laporan Stok Barang</label>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="row">
                                 <div class="md-12">
                                     <div class="checkAll" style="text-align: left; padding:10px;">
                                         <button name="cmdselectall" type="button" onClick="checkAll()" class="btn btn-secondary"><span class="fa fa-check-square">&nbsp;</span>Pilih Semua</button> &nbsp;
                                         <button name="cmddeselect" type="button" onClick="uncheckAll()" class="btn btn-secondary reset"><span class="fa fa-square-o">&nbsp;</span>Reset</button>
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

     function selectRole(selectValue) {
         var role = selectValue.value;
         if (role == '0') {
             $('.menu').prop("checked", true);
             $('.reset').prop('disabled', true);
         } else {
             $('.menu').prop("checked", false);
             $('.reset').prop('disabled', false);
         }
     }
 </script>