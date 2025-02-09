 <!-- Begin Page Content -->
 <div class="container-fluid">
     <div class="card shadow mb-4">
         <div class="card-body">
             <a href="<?= base_url('kelompokbarang/addView') ?>" class="btn btn-primary">Tambah</a>
             <div class="table-responsive mt-4">
                 <table class="table table-bordered" id="dataTable-data" width="100%">
                     <thead>
                         <tr>
                             <td width="8%" style="text-align: center;"><i class="bi bi-circle"></i></td>
                             <td width="22%" style="text-align: center;">Kode</td>
                             <td width="62%" style="text-align: center;">Kelompok Barang</td>
                             <td width="8%" style="text-align: center;"> <i class="bi bi-gear-fill mr-2"></i></td>
                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            $no = 1;
                            foreach ($kelompokbarang as $kb) {
                            ?>
                             <tr>
                                 <td style="text-align: center;"><?= $no++ ?></td>
                                 <td style="text-align: center;"><?= $kb->kode_kelompok ?></td>
                                 <td><?= $kb->nama_kelompok ?></td>
                                 <td style="text-align: center;">
                                     <a href="<?= base_url('kelompokbarang/editView/' . $kb->id_kelompok) ?>" style="color: #3b5998;" title="Edit" class="mr-2"><i class="bi bi-pencil-square"></i></a>
                                     <a href="#" style="color: #3b5998;" title="Hapus" class="tombolHapus" data-id="<?= $kb->id_kelompok ?>"><i class="bi bi-trash3-fill"></i></a>
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
                     url: "<?= base_url('kelompokbarang/hapusData') ?>",
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