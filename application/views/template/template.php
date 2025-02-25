<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- template -->
    <title><?= $title ?></title>
    <link rel="icon" type="image/png" sizes="50x26" href="<?= base_url('assets/img/logo.png'); ?>">
    <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/') ?>css/custome.css" rel="stylesheet" type="text/css">

    <!-- CDN -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.min.css">

    <!-- CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav warna-utama sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-2" style="font-family: Arial, Helvetica, sans-serif;">Karya Citra Jaya</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <?php
            $idUser = $this->session->userdata('id_user');
            $getMenu = $this->db->query("SELECT id_menu FROM t_user_menu WHERE id_user = '$idUser'")->result_array();
            foreach ($getMenu as $mn) {
                $menu[] = $mn['id_menu'];
            }

            if (in_array(10, $menu)) { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= base_url('Dashboard') ?>">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span></a>
                </li>
            <?php }

            if (in_array(11, $menu)) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <i class="bi bi-basket3-fill"></i>
                        <span>Invoice</span></a>
                </li>
            <?php }

            if (!empty(array_intersect([1, 2, 3], $menu))) { ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#listPersediaan"
                        aria-expanded="true" aria-controls="listPersediaan">
                        <i class="bi bi-boxes"></i>
                        <span>Persediaan</span>
                    </a>
                    <div id="listPersediaan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <?php if (in_array(1, $menu)) { ?>
                                <a class="collapse-item" href="<?= base_url('Stokbarang') ?>">Stok Barang</a>
                            <?php }

                            if (in_array(2, $menu)) { ?>
                                <a class="collapse-item" href="<?= base_url('Kelompokbarang') ?>">Kelompok Barang</a>
                            <?php }

                            if (in_array(3, $menu)) { ?>
                                <a class="collapse-item" href="<?= base_url('Pembelianbarang') ?>">Pembelian Barang</a>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php }

            if (!empty(array_intersect([4, 5, 6], $menu))) { ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#listAdministrasi"
                        aria-expanded="true" aria-controls="listAdministrasi">
                        <i class="bi bi-card-list"></i>
                        <span>Administrasi</span>
                    </a>
                    <div id="listAdministrasi" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <?php if (in_array(4, $menu)) { ?>
                                <a class="collapse-item" href="<?= base_url('Customer') ?>">Customer</a>
                            <?php }

                            if (in_array(5, $menu)) { ?>
                                <a class="collapse-item" href="<?= base_url('Supplier') ?>">Supplier</a>
                            <?php }

                            if (in_array(6, $menu)) { ?>
                                <a class="collapse-item" href="<?= base_url('Rekening') ?>">Rekening</a>
                            <?php } ?>

                        </div>
                    </div>
                </li>
            <?php }

            if (!empty(array_intersect([7, 8, 9], $menu))) { ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#listLaporan"
                        aria-expanded="true" aria-controls="listLaporan">
                        <i class="bi bi-journal-bookmark"></i>
                        <span>Laporan</span>
                    </a>
                    <div id="listLaporan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <?php if (in_array(7, $menu)) { ?>
                                <a class="collapse-item" href="buttons.html">Penjualan</a>
                                <a class="collapse-item" href="cards.html">Detail Invoice</a>
                                <a class="collapse-item" href="cards.html">Detail Invoice Kaca</a>
                            <?php }

                            if (in_array(8, $menu)) { ?>
                                <a class="collapse-item" href="cards.html">Pembelian Barang</a>
                                <a class="collapse-item" href="cards.html">Detail Pembelian Barang</a>
                            <?php }

                            if (in_array(9, $menu)) { ?>
                                <a class="collapse-item" href="<?= base_url('Stokbarang') ?>">Stok Barang</a>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php } ?>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- title -->
                    <h5 class="mb-0 text-gray-800"><?= $title ?></h5>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle mr-3"
                                    src="<?= base_url('assets/img/user/' . $this->session->userdata('image')) ?>">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->session->userdata('nama_user') ?></span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url('profil') ?>">
                                    <i class="bi bi-person-fill mr-2"></i>
                                    Profile
                                </a>
                                <?php if ($this->session->userdata('role') == '0') { ?>
                                    <a class="dropdown-item" href="<?= base_url('manajemenuser') ?>">
                                        <i class="bi bi-person-plus-fill mr-2"></i>
                                        Manajemen User
                                    </a>

                                    <a class="dropdown-item" href="">
                                        <i class="bi bi-hourglass-split"></i>
                                        Logs
                                    </a>
                                <?php } ?>
                                <a class="dropdown-item" href="<?= base_url('Pengaturan') ?>">
                                    <i class="bi bi-gear-fill mr-2"></i>
                                    Pengaturan
                                </a>
                                <a class="dropdown-item" href="<?= base_url('Backup') ?>">
                                    <i class="bi bi-back mr-2"></i>
                                    Backup & Restore
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="bi bi-box-arrow-right mr-2"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <?= $contents; ?>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Karya Citra Jaya 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" untuk keluar dari sistem.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('login/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- CDN -->
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-price-format/2.2.0/jquery.priceformat.min.js"></script>

    <!-- template-->
    <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>

    <script>
        let table = new DataTable('#dataTable-data');

        $('.numeric-only').keypress(function(e) {
            var verified = (e.which == 8 || e.which == undefined || e.which == 0) ? null : String.fromCharCode(e.which).match(/[^0-9]/);
            if (verified) {
                e.preventDefault();
            }
        });

        // FORMAT PRICE
        $(".iptPrice").priceFormat({
            prefix: '', // Tanpa simbol mata uang
            thousandsSeparator: '.',
            centsLimit: 0,
            clearOnEmpty: true
        });

        function parseHarga(harga) {
            if (!harga || harga === "0") {
                return 0;
            }
            return parseInt(harga.replace(/\./g, ''), 10) || 0;
        }

        function formatHarga(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>

</body>

</html>