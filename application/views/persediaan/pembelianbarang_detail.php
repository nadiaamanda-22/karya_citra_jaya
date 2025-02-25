<?php
$supplier = $this->db->query("SELECT supplier FROM t_supplier WHERE id_supplier = $data->id_supplier")->row()->supplier;

?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <table>
                        <tr>
                            <td colspan="2">
                                No Transaksi
                            </td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= $data->no_transaksi ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Supplier
                            </td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= $supplier ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Tanggal
                            </td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= formatTanggal($data->tgl_pembelian) ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Jatuh Tempo
                            </td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= formatTanggal($data->jatuh_tempo) ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Term <small class="text-danger">(hari)</small>
                            </td>
                            <td>&nbsp;:&nbsp;</td>
                            <td><?= $data->term ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Total
                            </td>
                            <td>&nbsp;:&nbsp;</td>
                            <td>Rp <?= formatPrice($data->total) ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row table-responsive mt-4">
                <table class="table table-bordered" id="tabelDetail" width="100%">
                    <thead>
                        <tr>
                            <td width="5%" style="text-align: center; background-color:#3b5998; color:#fff;">No</td>
                            <td width="13%" style="text-align: center; background-color:#3b5998; color:#fff;">Kode </td>
                            <td width="23%" style="text-align: center; background-color:#3b5998; color:#fff;">Nama Barang</td>
                            <td width="10" style="text-align: center; background-color:#3b5998; color:#fff;">Stok</td>
                            <td width="13" style="text-align: center; background-color:#3b5998; color:#fff;">Harga Beli</td>
                            <td width="10" style="text-align: center; background-color:#3b5998; color:#fff;">Diskon (%)</td>
                            <td width="13" style="text-align: center; background-color:#3b5998; color:#fff;">Diskon</td>
                            <td width="13" style="text-align: center; background-color:#3b5998; color:#fff;">Jumlah</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($detail as $r) {
                            $stok = $this->db->query("SELECT * FROM t_stok WHERE id = '$r->id_barang'")->row();
                        ?>
                            <tr>
                                <td style="text-align: center;"><?= $no++ ?></td>
                                <td style="text-align: center;"><?= $stok->kode_barang ?></td>
                                <td><?= $r->nama_barang ?></td>
                                <td style="text-align: center;"><?= $r->stok ?> </td>
                                <td style="text-align: right;"><?= formatPrice($r->harga_beli) ?></td>
                                <td style="text-align: center;"><?= $r->diskon_persen ?></td>
                                <td style="text-align: right;"><?= formatPrice($r->diskon_nominal) ?></td>
                                <td style="text-align: right;"><?= formatPrice($r->jumlah) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <a href="<?= base_url('Pembelianbarang') ?>" class="btn btn-danger">Kembali</a>

</div>