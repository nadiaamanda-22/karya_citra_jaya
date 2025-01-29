 <!-- Begin Page Content -->
 <div class="container-fluid">
     <div class="row">
         <?php $bulan = date('m'); ?>
         <p>Rekap Data Bulan <?= $this->fungsional->bulanIndonesia($bulan) . ' ' . date('Y') ?></p>
     </div>

     <!-- Content -->
     <div class="row mt-4">
         <div class="col-xl-3 col-md-6 mb-4">
             <div class="card border-left-warnaUtama shadow h-100 py-2">
                 <div class="card-body">
                     <div class="row no-gutters align-items-center">
                         <div class="col mr-2">
                             <div class="text-xs font-weight-bold text-utama text-uppercase mb-1">
                                 Total Penjualan</div>
                             <div class="h5 mb-0 font-weight-bold text-gray-800">Rp 40,000</div>
                         </div>
                         <div class="col-auto">
                             <i class="bi bi-cash-stack fa-2x text-utama"></i>

                         </div>
                     </div>
                 </div>
             </div>
         </div>

         <div class="col-xl-3 col-md-6 mb-4">
             <div class="card border-left-warnaUtama shadow h-100 py-2">
                 <div class="card-body">
                     <div class="row no-gutters align-items-center">
                         <div class="col mr-2">
                             <div class="text-xs font-weight-bold text-utama text-uppercase mb-1">
                                 Total Pembelian Barang</div>
                             <div class="h5 mb-0 font-weight-bold text-gray-800">Rp 40,000</div>
                         </div>
                         <div class="col-auto">
                             <i class="bi bi-cash-stack fa-2x text-utama"></i>

                         </div>
                     </div>
                 </div>
             </div>
         </div>

         <div class="col-xl-3 col-md-6 mb-4">
             <div class="card border-left-warnaUtama shadow h-100 py-2">
                 <div class="card-body">
                     <div class="row no-gutters align-items-center">
                         <div class="col mr-2">
                             <div class="text-xs font-weight-bold text-utama text-uppercase mb-1">
                                 Total Hutang Customer</div>
                             <div class="h5 mb-0 font-weight-bold text-gray-800">Rp 40,000</div>
                         </div>
                         <div class="col-auto">
                             <i class="bi bi-cash-stack fa-2x text-utama"></i>

                         </div>
                     </div>
                 </div>
             </div>
         </div>

         <div class="col-xl-3 col-md-6 mb-4">
             <div class="card border-left-warnaUtama shadow h-100 py-2">
                 <div class="card-body">
                     <div class="row no-gutters align-items-center">
                         <div class="col mr-2">
                             <div class="text-xs font-weight-bold text-utama text-uppercase mb-1">
                                 Total Hutang Toko</div>
                             <div class="h5 mb-0 font-weight-bold text-gray-800">Rp 40,000</div>
                         </div>
                         <div class="col-auto">
                             <i class="bi bi-cash-stack fa-2x text-utama"></i>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- End content -->
 </div>