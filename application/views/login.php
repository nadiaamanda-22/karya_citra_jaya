<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Karya Citra Jaya</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <!-- CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body style="background-color: #3b5998;">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Sign in</h1>
                                    </div>
                                    <form action="<?= base_url('login/login') ?>" method="POST">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control form-control-user"
                                                id="username" name="username">
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Password</label>
                                            <input type="password" class="form-control form-control-user"
                                                id="password" name="password">
                                        </div>
                                        <button class="btn btn-user btn-block" type="submit" style="background-color: #3b5998;color:#fff;">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>

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
            } else if (message == 'gagal_login') {
                Swal.fire({
                    title: "Terjadi kesalahan!",
                    text: "Username atau password tidak sesuai!",
                    icon: "error",
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: "Ya",
                    confirmButtonColor: "#3b5998",
                });
            } else if (message == 'required') {
                Swal.fire({
                    title: "Terjadi kesalahan",
                    text: "Username atau password tidak boleh kosong!",
                    icon: "error",
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: "Ya",
                    confirmButtonColor: "#3b5998",
                });
            }
        </script>
    <?php } ?>

</body>

</html>