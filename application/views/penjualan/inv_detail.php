<?php
$customer = $this->db->query("SELECT nama_customer FROM t_customer WHERE id_customer = $data->id_customer")->row()->nama_customer;

?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <table>
                <tr>
                    <td colspan="2">
                        No Invoice
                    </td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?= $data->no_invoice ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        Customer
                    </td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?= $customer ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        Tanggal Jual
                    </td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?= formatTanggal($data->tgl_jual) ?></td>
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
                        Subtotal
                    </td>
                    <td>&nbsp;:&nbsp;</td>
                    <td>Rp <?= formatPrice($data->subtotal) ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        Ongkir
                    </td>
                    <td>&nbsp;:&nbsp;</td>
                    <td>Rp <?= formatPrice($data->ongkir) ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        Total
                    </td>
                    <td>&nbsp;:&nbsp;</td>
                    <td>Rp <?= formatPrice($data->total) ?></td>
                </tr>
            </table>

            <div class="row table-responsive mt-4">
                <table class="table table-bordered" id="tabelDetail" width="100%">
                    <thead>
                        <tr>
                            <td width="5%" style="text-align: center; background-color:#3b5998; color:#fff;">No</td>
                            <td width="13%" style="text-align: center; background-color:#3b5998; color:#fff;">Kode </td>
                            <td width="23%" style="text-align: center; background-color:#3b5998; color:#fff;">Nama Barang</td>
                            <td width="10" style="text-align: center; background-color:#3b5998; color:#fff;">Stok</td>
                            <td width="13" style="text-align: center; background-color:#3b5998; color:#fff;">Harga Jual</td>
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
                                <td style="text-align: right;"><?= formatPrice($r->harga_jual) ?></td>
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
    <a href="<?= base_url('penjualan') ?>" class="btn btn-danger">Kembali</a>

</div>