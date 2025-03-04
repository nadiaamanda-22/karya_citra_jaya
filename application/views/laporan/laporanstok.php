<?php
$id_kelompok_terpilih = isset($_POST['id_kelompok']) ? $_POST['id_kelompok'] : '*';
$stok_terpilih = isset($_POST['stok']) ? $_POST['stok'] : '*';
?>

<div class="container-fluid">
     <div class="card shadow mb-4">
         <div class="card-body">
         <form class="row g-3 pt-3" action="<?= base_url('Laporanstok/filterData') ?>" method="post">
            <div class="col-sm-3">
                <select id="id_kelompok" name="id_kelompok" class="form-select">
                    <option value="*" <?= ($id_kelompok_terpilih == '*') ? 'selected' : '' ?>>Semua Kelompok Barang</option>
                    <?php 
                    $getKelompokbarang = $this->db->query("SELECT * FROM t_kelompok_barang")->result();
                    foreach ($getKelompokbarang as $gkb) { ?>
                        <option value="<?= $gkb->id_kelompok ?>" <?= ($gkb->id_kelompok == $id_kelompok_terpilih) ? 'selected' : '' ?>>
                            <?= $gkb->nama_kelompok ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-sm-3">
                <select id="stok" name="stok" class="form-select">
                    <option value="*" <?= ($stok_terpilih == '*') ? 'selected' : '' ?>>Semua Stok</option>
                    <option value="0" <?= ($stok_terpilih == '0') ? 'selected' : '' ?>>Stok 0</option>
                    <option value="1" <?= ($stok_terpilih == '1') ? 'selected' : '' ?>>Stok Tersedia</option>
                </select>
            </div>

            <div class="col-sm-2">
                <button class="btn btn-info" type="submit">Tampilkan</button>
            </div>
        </form>

            <div class="mt-4">
                <a class="btn btn-primary" onclick="printLaporan()">Print</a>
                <a class="btn btn-success">Export</a>
            </div>
                
             <div class="table-responsive mt-4">
                 <table class="table table-bordered" id="dataTable-data" width="100%">
                     <thead>
                         <tr>
                             <td width="16%" style="text-align: center;">Kode Barang </td>
                             <td width="28%" style="text-align: center;">Nama Barang</td>
                             <td width="24"  style="text-align: center;">Kelompok Barang</td>
                             <td width="8"  style="text-align: center;">Jumlah Stok</td>
                             <td width="10"  style="text-align: center;">Harga Beli</td>
                             <td width="10"  style="text-align: center;">Harga /m2</td>
                             <td width="10"  style="text-align: center;">Harga Jual</td>
                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            $no = 1;
                            foreach ($laporanstok as $ls) { ?>
                             <tr>
                                 <td style="text-align: center;"><?= $ls->kode_barang ?></td>
                                 <td style="text-align: left;"><?= $ls->nama_barang ?></td>
                                 <td style="text-align: left;"><?= $ls->nama_kelompok?></td>
                                 <td style="text-align: center;"><?= $ls->stok?> <?= $ls->satuan?></td>
                                 <td style="text-align: right;"><?= formatPrice($ls->harga_beli) ?></td>
                                 <td style="text-align: right;"><?= formatPrice($ls->harga_permeter) ?></td>
                                 <td style="text-align: right;"><?= formatPrice($ls->harga_jual) ?></td>
                         <?php } ?>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>
 </div>