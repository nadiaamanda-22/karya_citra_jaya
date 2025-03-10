<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- template -->
    <title>Cetak Invoice</title>
    <link rel="icon" type="image/png" sizes="50x26" href="<?= base_url('assets/img/logo.png'); ?>">
    <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/') ?>css/custome.css" rel="stylesheet" type="text/css">

    <!-- CDN -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .card {
            width: 1056px;
            height: 750px;
            background: white;
            border-radius: 0%;
            padding: 3% 8% 3% 8%;
            font-size: 13px;
        }

        .header {
            font-family: 'Roboto';
            font-weight: bold;
        }

        #headerTbl {
            background-color: #D9D9D9 !important;
        }
    </style>
</head>

<body id="page-top">
    <!-- <div class="container"> -->
    <div class="card">
        <div class="card-body">
            <div class="row header mb-2">
                <h6 class="text-danger">KARYA CITRA JAYA</h6>
            </div>

            <div class="row headerToko">
                <div class="col-6">
                    <p>Jl. Raya Sukahati / Pemda No. 5B (Depan Bengkel Honda) Sukahati, Cibinong-Bogor
                        <br>Telp : 021-87917212
                        <br>Hp : 0812 1378 1355 - 081293124402
                    </p>
                </div>
                <div class="col-6" align="right">
                    <table>
                        <tr>
                            <td colspan="2">
                                No Invoice
                            </td>
                            <td>&nbsp;&nbsp;:&nbsp;</td>
                            <td class="text-right">001/INV/24120001</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Tanggal
                            </td>
                            <td>&nbsp;&nbsp;:&nbsp;</td>
                            <td class="text-right">10 Maret 2025</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Kepada
                            </td>
                            <td>&nbsp;&nbsp;:&nbsp;</td>
                            <td class="text-right">Customer A</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr style="background-color: #424649;" class="mt-2">

            <div class="row dataInv mt-2">
                <table class="table table-sm table-bordered" width="100%">
                    <thead>
                        <tr>
                            <td width="10%" id="headerTbl" style="text-align: center;">No</td>
                            <td width=" 40%" id="headerTbl">Nama Barang</td>
                            <td width="14" id="headerTbl" style="text-align: center;">Qty</td>
                            <td width="17" id="headerTbl" style="text-align: right;">Harga Jual</td>
                            <td width="17" id="headerTbl" style="text-align: right;">Jumlah</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center;">1</td>
                            <td>Kaca A</td>
                            <td style="text-align: center;">10</td>
                            <td style="text-align: right;">100.000</td>
                            <td style="text-align: right;">1.000.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row mt-5">
                <div class="col-6">
                    <hr style="background-color: #424649; height:3px;">
                </div>
            </div>

            <div class="row total">
                <div class="col-6">
                    <p>BCA : 98912397 an Admin</p>
                    <p>
                        Alamat :
                        <br>
                        Bogor, Indonesia
                    </p>
                </div>
                <div class="col-6" align="right">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td id="headerTbl" colspan="2">
                                &nbsp;Subtotal
                            </td>
                            <td id="headerTbl">&nbsp;&nbsp;:&nbsp;</td>
                            <td id="headerTbl" class="text-right">1.000.000&nbsp;</td>
                        </tr>
                        <tr>
                            <td id="headerTbl" colspan="2">
                                &nbsp;Diskon
                            </td>
                            <td id="headerTbl">&nbsp;&nbsp;:&nbsp;</td>
                            <td id="headerTbl" class="text-right">&nbsp;</td>
                        </tr>
                        <tr>
                            <td id="headerTbl" colspan="2">
                                &nbsp;Ongkir
                            </td>
                            <td id="headerTbl">&nbsp;&nbsp;:&nbsp;</td>
                            <td id="headerTbl" class="text-right">10.000&nbsp;</td>
                        </tr>
                        <tr>
                            <td id="headerTbl" colspan="2">
                                &nbsp;Total
                            </td>
                            <td id="headerTbl">&nbsp;&nbsp;:&nbsp;</td>
                            <td id="headerTbl" class="text-right">1.010.000&nbsp;</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row ttd mt-5">
                <div class="col-6">
                    <p>Tanda Terima</p>
                    <br><br><br>
                    <hr style="background-color: #424649; height:1px; width:270px;">
                </div>

                <div class="col-6" align="right">
                    <p style="text-align: center; margin-left:-60px;">Hormat Kami</p>
                    <br><br><br>
                    <hr style="background-color: #424649; height:1px; width:270px;">
                </div>
            </div>

        </div>
    </div>
    <!-- </div> -->


    <!-- CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-price-format/2.2.0/jquery.priceformat.min.js"></script>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>