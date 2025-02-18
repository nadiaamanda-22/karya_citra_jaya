<!--
echo "<pre>";
var_dump([$submit]);
die;
?> -->

<!-- Begin Page Content -->
<div class="container-fluid">
     <div class="card shadow mb-4">
         <div class="card-body">
             <a href="<?= base_url('stokbarang/addView') ?>" class="btn btn-primary">Tambah</a>
             <a class="btn btn-success">Import</a>

             <div class="table-responsive mt-4">
                 <table class="table table-bordered" id="dataTable-data" width="100%">
                     <thead>
                         <tr>
                             <td width="6%" style="text-align: center;"><i class="bi bi-circle"></i></td>
                             <td width="16%" style="text-align: center;">Kode Barang </td>
                             <td width="28%" style="text-align: center;">Nama Barang</td>
                             <td width="24"  style="text-align: center;">Kelompok Barang</td>
                             <td width="8"  style="text-align: center;">Jumlah Stok</td>
                             <td width="10"  style="text-align: center;">Harga Beli</td>
                             <td width="10"  style="text-align: center;">Harga Jual</td>
                             <td width="8%" style="text-align: center;"><i class="bi bi-gear-fill mr-2"></i></td>
                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            $no = 1;
                            foreach ($stokbarang as $sb) { ?>
                             <tr>
                                 <td style="text-align: center;"><?= $no++ ?></td>
                                 <td style="text-align: center;"><?= $sb->kode_barang ?></td>
                                 <td><?= $sb->nama_barang ?></td>
                                 <td style="text-align: center;"><?= $sb->nama_kelompok?></td>
                                 <td style="text-align: center;"><?= $sb->stok?> <?= $sb->satuan?></td>
                                 <td style="text-align: center;"><?= $sb->harga_beli?></td>
                                 <td style="text-align: center;"><?= $sb->harga_jual?></td>

                                 <td style="text-align: center;">
                                     <a href="<?= base_url('stokbarang/editView/' . $sb->id) ?>" style="color: #3b5998;" title="Edit" class="mr-2"><i class="bi bi-pencil-square"></i></a>
                                     <a href="#" style="color: #3b5998;" title="Hapus" class="tombolHapus" data-id="<?= $sb->id?>"><i class="bi bi-trash3-fill"></i></a>
                                 </td>
                             </tr>
                         <?php } ?>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>
 </div>
 <?php if ($this->session->flashdata('message')) { ?>
     <script>
         var message = "<?= $this->session->flashdata('message') ?>";
         if (message == 'berhasil tambah') {
             Swal.fire({
                 title: "Data berhasil ditambah!",
                 icon: "success",
                 showDenyButton: false,
                 showCancelButton: false,
                 confirmButtonText: "Ya",
                 confirmButtonColor: "#3b5998",
             });
         } else if (message == 'berhasil ubah') {
             Swal.fire({
                 title: "Data berhasil diubah!",
                 icon: "success",
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
     $('.tombolHapus').on('click', function(e) {
         e.preventDefault();
         var id = $(this).data('id');

         Swal.fire({
             title: "Apakah kamu yakin?",
             text: "Data yang sudah terhapus tidak dapat dikembalikan!",
             icon: "warning",
             showCancelButton: true,
             confirmButtonColor: "#3b5998",
             cancelButtonColor: "#d33",
             confirmButtonText: "Ya",
             cancelButtonText: "Batal"
         }).then((result) => {
             if (result.isConfirmed) {
                 $.ajax({
                     url: "<?= base_url('stokbarang/hapusData') ?>",
                     type: "POST",
                     data: {
                         id: id
                     },
                     dataType: "json",
                     success: function(response) {
                         if (response == 'berhasil') {
                             Swal.fire({
                                 title: "Data berhasil dihapus!",
                                 icon: "success",
                                 showDenyButton: false,
                                 showCancelButton: false,
                                 confirmButtonText: "Ya",
                                 confirmButtonColor: "#3b5998",
                             }).then((result) => {
                                 location.reload();
                             });
                         }
                     }
                 });
             }
         });
     })
 </script>
