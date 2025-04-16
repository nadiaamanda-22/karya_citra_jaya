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
         @font-face {
            font-family: 'DotMatrix';
            src: url('<?= base_url("assets/dot_matrix/DotMatrix.ttf") ?>') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @media print {
            @page {
                size: Letter; 
                margin: 0;     
            }

            body {
                margin: 0; 
            }

            .card {
                margin: auto; 
            }
        }
        body {
            font-family: 'DotMatrix', monospace;
            font-size: 14px;
        }
        .card {
            width: 950px;
            height: 640;
            background: white;
            border-radius: 0%;
            font-size: 13px;
        }

        .header {
            font-family: 'Montserrat';
            font-weight: bold;
        }

        
        .table.borderless th,
        .table.borderless td,
        .table.borderless,
        .table.borderless thead,
        .table.borderless tbody,
        .table.borderless tr {
            border: none !important;
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
                <h6 class="text-danger" style="font-size: 25px; font-weight: bold; ">KARYA CITRA JAYA</h6>
            </div>

            <div class="row headerToko"  style="font-size: 18px; font-weight: bold; ">
                <div class="col-6">
                    <p><?= $setting->alamat ?>
                        <br>Telp : <?= $setting->no_telp ?>
                        <?php $noHp = $this->db->query("SELECT GROUP_CONCAT(no_hp SEPARATOR ' - ') AS no_hp_toko FROM t_no_hp WHERE id IN ($setting->id_no_hp)")->row()->no_hp_toko ?>
                        <br><?= $noHp ?>
                    </p>
                </div>
                <div class="col-6" align="right" style="font-size: 18px; ">
                    <table>
                        <tr>
                            <td colspan="2">
                                No Invoice
                            </td>
                            <td>&nbsp;&nbsp;:&nbsp;</td>
                            <td class="text-right"><?= $inv->no_invoice ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Tanggal
                            </td>
                            <td>&nbsp;&nbsp;:&nbsp;</td>
                            <td class="text-right"><?= formatTanggal($inv->tgl_jual) ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Kepada
                            </td>
                            <td>&nbsp;&nbsp;:&nbsp;</td>
                            <?php $customer = $this->db->query("SELECT alamat, nama_customer FROM t_customer WHERE id_customer ='$inv->id_customer'")->row();
                            $alamatCus = $customer->alamat;
                            $namaCus = $customer->nama_customer;
                            ?>
                            <td class="text-right"><?= $namaCus ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- <hr style="background-color: #424649;" class="mt-2"> -->

            <div class="row dataInv mt-2" style="font-size: 18px; ">
                <table class="table table-sm table-borderless" style="font-size: 18px;" width="100%">
                    <thead style= "font-weight: bold; font-size:20px;">
                        <tr style="border-bottom: 1px solid black; border-top: 1px solid black;">
                            <td width="8%" id="headerTbl" style="text-align: center;">No</td>
                            <td width="40%" id="headerTbl">Nama Barang</td>
                            <td width="13" id="headerTbl" style="text-align: center;">Qty</td>
                            <td width="17" id="headerTbl" style="text-align: right;">Harga Jual</td>
                            <td width="17" id="headerTbl" style="text-align: right;">Jumlah</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $diskon = 0;
                        foreach ($detail as $r) {
                            $diskon += $r->diskon_nominal;
                        ?>
                            <tr>
                                <td style="text-align: center;"><?= $no++ ?></td>
                                <td><?= $r->nama_barang ?></td>
                                <td style="text-align: center;"><?= $r->stok ?></td>
                                <td style="text-align: right;"><?= formatPrice($r->harga_after_diskon) ?></td>
                                <td style="text-align: right;"><?= formatPrice($r->jumlah) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="row total">
                <div class="col-8" style="font-size: 18px; font-weight: bold; border-top: 1px solid black;">
                    <?php if ($inv->id_rekening != "0") { ?>
                        <?php $rekening = $this->db->query("SELECT rekening FROM t_rekening WHERE id_rekening ='$inv->id_rekening'")->row()->rekening; ?>
                        <p style="border-bottom: 1px solid black">Pembayaran dapat dilakukan melalui : 
                        <br><?= $rekening ?></p>
                    <?php } ?>
                    <p>
                        Alamat :
                        <br>
                        <?= $alamatCus ?>
                    </p>
                </div>
                <div class="col-4" align="right" style="font-size: 18px;">
                    <table class="table table-sm table-borderless">
                        <!-- <tr>
                            <td id="headerTbl" colspan="2">
                                &nbsp;Subtotal
                            </td>
                            <td id="headerTbl">&nbsp;&nbsp;:&nbsp;</td>
                            <td id="headerTbl" class="text-right"><?= formatPrice($inv->subtotal) ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td id="headerTbl" colspan="2">
                                &nbsp;Diskon
                            </td>
                            <td id="headerTbl">&nbsp;&nbsp;:&nbsp;</td>
                            <td id="headerTbl" class="text-right"><?= formatPrice($diskon) ?>&nbsp;</td>
                        </tr> -->
                        <tr>
                            <td id="headerTbl" colspan="2">
                                &nbsp;Ongkir
                            </td>
                            <td id="headerTbl">&nbsp;&nbsp;:&nbsp;</td>
                            <td id="headerTbl" class="text-right"><?= formatPrice($inv->ongkir) ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td id="headerTbl" colspan="2" style="font-weight: bold;">
                                &nbsp;Total
                            </td>
                            <td id="headerTbl">&nbsp;&nbsp;:&nbsp;</td>
                            <td id="headerTbl" class="text-right"><?= formatPrice($inv->total) ?>&nbsp;</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row ttd mt-3" align="center" style="font-size: 18px;">
                <div class="col-6">
                    <p>Tanda Terima</p>
                    <br> 
                    <hr style="background-color: #424649; height:1px; width:270px;">
                </div>

                <div class="col-6" align="center">
                    <p>Hormat Kami</p>
                    <?php if ($setting->ttd != 'no-image.jpg') { ?>
                        <img src="<?= base_url('assets/img/setting/' . $setting->ttd) ?>" class="img-fluid" style="max-width:30%; margin-top:-10px; margin-bottom:-25px;">
                    <?php } else { ?>
                        <br>
                    <?php } ?>
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