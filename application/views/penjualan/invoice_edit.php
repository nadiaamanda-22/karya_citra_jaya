<?php
$dateNow = date('Y-m-d');
$maxDetailInput = $this->db->select('max_detail_input')->from('t_pengaturan')->get()->row()->max_detail_input;
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <p class="m-0">Edit Invoice</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?= base_url('penjualan/editData/' . $data->id_invoice) ?>" method="post">
                        <div class="row align-items-start mb-3">
                            <div class="col-6">
                                <label for="customer" class="form-label">Customer *</label>
                                <input id="id_customer" name="id_customer" type="hidden" value="<?= $data->id_customer ?>" />
                                <?php $customer = $this->db->query("SELECT nama_customer FROM t_customer WHERE id_customer='$data->id_customer'")->row()?->nama_customer ?>
                                <input type="text" class="form-control" id="customer" name="customer" required value="<?= $customer ?>">
                            </div>
                            <div class="col-6">
                                <label for="spg" class="form-label">SPG *</label>
                                <input type="text" class="form-control" id="spg" name="spg" required value="<?= $data->spg ?>">
                            </div>
                        </div>

                        <div class="row align-items-start">
                            <div class="col">
                                <label for="tgl_jual" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tgl_jual" name="tgl_jual" value="<?= $data->tgl_jual ?>">
                            </div>
                            <div class="col">
                                <label for="jatuh_tempo" class="form-label">Jatuh Tempo</label>
                                <input type="date" class="form-control" id="jatuh_tempo" name="jatuh_tempo" value="<?= $data->jatuh_tempo ?>">
                            </div>
                        </div>
                        <div class="row align-items-start pt-3">
                            <div class="col">
                                <label for="term" class="form-label">Term <small class="text-danger">(hari)</small></label>
                                <input type="text" class="form-control" id="term" name="term" required value="<?= $data->term ?>">
                            </div>
                            <div class="col">
                                <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                                <select class="form-select" id="status_pembayaran" name="status_pembayaran">
                                    <option value="lunas" <?= $data->status_pembayaran == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                                    <option value="belumlunas" <?= $data->status_pembayaran == 'belumlunas' ? 'selected' : '' ?>>Belum Lunas</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-start pt-3">
                            <div class="col-6">
                                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                <select class="form-select" id="metode_pembayaran" name="metode_pembayaran">
                                    <option value="tunai" <?= $data->metode_pembayaran == 'tunai' ? 'selected' : '' ?>>Tunai</option>
                                    <option value="nontunai" <?= $data->metode_pembayaran == 'nontunai' ? 'selected' : '' ?>>Non Tunai (Transfer atau Debit)</option>
                                </select>
                            </div>
                            <div class="col-6 rekening">
                                <label for="id_rekening" class="form-label">Rekening Bank</label>
                                <select name="id_rekening" id="id_rekening" class="form-select">
                                    <?php
                                    $getRekening = $this->db->query("SELECT * FROM t_rekening")->result();
                                    foreach ($getRekening as $rk) : ?>
                                        <option value="<?= $rk->id_rekening ?>" <?= $data->id_rekening == $rk->id_rekening ? 'selected' : '' ?>> <?= $rk->rekening ?>
                                        <?php endforeach ?>
                                        </option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 mb-4">
                            <small>[*] Kolom harus diisi</small>
                        </div>

                        <p>Silahkan Masukkan Barang</p>
                        <div class='row m-bottom-10 table-responsive'>
                            <div class="col-12">
                                <table class="table table-bordered table-striped table-hover" width="100%">
                                    <thead>
                                        <tr align="center">
                                            <td width="5%" id="headerTabel">&nbsp;</td>
                                            <td width="10%" id="headerTabel">Kode</td>
                                            <td id="headerTabel">Nama Barang</td>
                                            <td width="9%" id="headerTabel">Stok</td>
                                            <td width="10%" id="headerTabel">Satuan</td>
                                            <td width="10%" id="headerTabel">Harga Jual</td>
                                            <td width="10%" id="headerTabel">Diskon (%)</td>
                                            <td width="10%" id="headerTabel">Diskon</td>
                                            <td width="10%" id="headerTabel">Jumlah</td>
                                        </tr>
                                    </thead>
                                    <tbody id="tableDynamic">
                                        <?php
                                        $c = 1;
                                        foreach ($detail as $dt) {
                                            $getStok = $this->db->query("SELECT * FROM t_stok WHERE id = '$dt->id_barang'")->row();
                                        ?>
                                            <tr id="rows<?= $c ?>" class="border-b rowItem">
                                                <?php if ($c == 1) { ?>
                                                    <td><button type="button" id="btn11" name="btn11" class="btn btn-sm btn-success" disabled><span class="fa fa-exclamation"></span></button></td>
                                                <?php } else { ?>
                                                    <td><button type='button' id='btn1<?= $c ?>' name='btn1<?= $c ?>' class='btn btn-sm btn-danger hapus' onClick='deleteRows(<?= $c ?>)'><span class='fa fa-trash'></span></button></td>
                                                <?php } ?>
                                                <td class="gray">
                                                    <input type="hidden" id="id_barang1<?= $c ?>" name="id_barang1<?= $c ?>" class='form-control text-center id_barang' value="<?= $dt->id_barang ?>" />
                                                    <input type="text" id="kode2<?= $c ?>" name="kode2<?= $c ?>" class='form-control text-center kode' required value="<?= $getStok->kode_barang ?>" />
                                                </td>
                                                <td class="gray">
                                                    <input type="text" id="nama_barang3<?= $c ?>" name="nama_barang3<?= $c ?>" class='form-control nama_barang' readonly value="<?= $dt->nama_barang ?>" />
                                                </td>
                                                <td class="gray">
                                                    <input type="text" id="stok4<?= $c ?>" name="stok4<?= $c ?>" class='form-control text-center stok numeric-only' placeholder="0" required onKeyUp="accSum(<?= $c ?>,1)" value="<?= $dt->stok ?>" />
                                                </td>
                                                <td class="gray">
                                                    <input type="text" id="satuan5<?= $c ?>" name="satuan5<?= $c ?>" class='form-control text-center satuan' readonly value="<?= $dt->satuan ?>" />
                                                </td>
                                                <td>
                                                    <input type="text" id="harga_jual6<?= $c ?>" name="harga_jual6<?= $c ?>" placeholder='0' class='form-control text-right harga_jual numeric-only iptPrice' required readonly value="<?= formatPrice($dt->harga_jual) ?>" />
                                                </td>

                                                <td class="gray">
                                                    <input type="text" id="diskon_persen7<?= $c ?>" name="diskon_persen7<?= $c ?>" class='form-control text-center diskon_persen numeric-only' placeholder="0" onKeyUp="dicSumPer(<?= $c ?>,1)" value="<?= $dt->diskon_persen ?>" />
                                                </td>
                                                <td class=" gray">
                                                    <input type="text" id="diskon_nominal8<?= $c ?>" name="diskon_nominal8<?= $c ?>" class='form-control text-right diskon_nominal numeric-only iptPrice' placeholder="0" onKeyUp="dicSum(<?= $c ?>,1)" value="<?= formatPrice($dt->diskon_nominal) ?>" />
                                                </td>
                                                <td class="gray">
                                                    <input type="text" id="jumlah9<?= $c ?>" name="jumlah9<?= $c ?>" class='form-control text-right jumlah' placeholder="0" readonly value="<?= formatPrice($dt->jumlah) ?>" />
                                                </td>
                                            </tr>
                                        <?php
                                            $c++;
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>
                                                <button type="button" id="plus-content" class="btn btn-sm btn-primary" style='width: 100%'><span class="fa fa-plus"></span></button>
                                            </td>
                                            <td colspan="5">&nbsp;</td>
                                            <td>SUBTOTAL</td>
                                            <td class="gray">
                                                <input type="text" id="subtotal" name="subtotal" class='form-control text-right' readonly placeholder="0" value="<?= formatPrice($data->subtotal) ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="6">&nbsp;</td>
                                            <td>ONGKIR</td>
                                            <td class="gray">
                                                <input type="text" id="ongkir" name="ongkir" class='form-control text-right iptPrice numeric-only' placeholder="0" value="<?= formatPrice($data->ongkir) ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="6">&nbsp;</td>
                                            <td>TOTAL</td>
                                            <td class="gray">
                                                <input type="text" id="total" name="total" class='form-control text-right' readonly placeholder="0" value="<?= formatPrice($data->total) ?>" />
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <input type="hidden" id="rowsCount" value="<?= (isset($c) ? $c - 1 : "1") ?>" readonly />
                                    <script>
                                        var rowsDels = <?= (isset($c) ? $c - 1 : "1") ?>;
                                    </script>

                                </table>
                            </div>
                        </div>

                        <a href="<?= base_url('penjualan') ?>" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary btnSimpan">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#customer").focus();

    <?php if ($data->id_rekening == 0) { ?>
        $(".rekening").hide();
    <?php } else { ?>
        $(".rekening").show();
    <?php } ?>

    $(document).ready(function() {
        $("#customer").autocomplete({
            source: "<?= base_url() ?>penjualan/searchCustomer",
            minLength: 1,
            select: function(evt, ui) {
                $('#id_customer').val(ui.item.id_customer);
                $('#customer').val(ui.item.customer);
            }
        });

        $("#tgl_jual, #jatuh_tempo").change(function() {
            var tglJual = new Date($("#tgl_jual").val());
            var jatuhTempo = new Date($("#jatuh_tempo").val());

            if (tglJual > jatuhTempo) {
                alert("Tanggal jual tidak boleh lebih dari jatuh tempo!");
                $("#tgl_jual").val($("#jatuh_tempo").val());
                $("#term").val('0');
            } else {
                $("#term").val(DateDiff(new Date(tglJual), new Date(jatuhTempo)));
            }

        });

        $("#term").keyup(function() {
            var daysToAdd = $("#term").val();
            if (daysToAdd != "") {
                var startdate = new Date($("#tgl_jual").val());
                startdate.setDate(startdate.getDate() + parseInt(daysToAdd));
                $("#jatuh_tempo").val(startdate.yyyymmdd());
            }
        });

        $('#metode_pembayaran').on('change', function() {
            var mp = $("#metode_pembayaran").val();
            if (mp == 'nontunai') {
                $(".rekening").show();
            } else {
                $(".rekening").hide();
            }
        });

        $("#kode21").autocomplete({
            source: "<?= base_url() ?>penjualan/searchBarang",
            minLength: 1,
            select: function(evt, ui) {
                var id = ui.item.id_barang;
                var stok = ui.item.stok;
                var harga_jual = ui.item.harga_jual;

                $.post('<?= base_url() ?>penjualan/validasiStok', {
                    id: id
                }, function(e) {
                    var st = e;
                    if (st == 0) {
                        alert('Tidak dapat melakukan transaksi dengan barang ini. Stok barang ini adalah 0!');
                        $("#plus-content").prop('disabled', true);
                        $(".btnSimpan").prop('disabled', true);
                        return false;
                    } else {
                        $('#nama_barang31').val(ui.item.nama_barang);
                        $('#id_barang11').val(id);
                        $('#satuan51').val(ui.item.satuan);
                        $('#harga_jual61').val(formatHarga(harga_jual));
                        $('#diskon_nominal81').val(0);
                        $('#diskon_persen71').val(0);
                        $('#stok41').focus();
                        totalGen();
                        $("#plus-content").prop('disabled', false);
                        $(".btnSimpan").prop('disabled', false);
                    }
                }, 'json');
            }
        });

        $("#plus-content").click(function(event) {
            for (rowstats = 2; rowstats <= <?= $maxDetailInput ?>; rowstats++) {
                console.log('baris ke: ' + rowstats)
                if ($('#stok4' + rowstats).length == 0) {
                    $('#tableDynamic').append(
                        "<tr id='rows" + rowstats + "' class='border-b rowItem'>" +
                        "<td><button type='button' id='btn1" + rowstats + "' name='btn1" + rowstats + "' class='btn btn-sm btn-danger hapus' onClick='deleteRows(" + rowstats + ")' style='padding: 5px 7px'><span class='fa fa-trash'></span></button></td>" +

                        "<td class='gray'>" +
                        "<input type='hidden' id='id_barang1" + rowstats + "' name='id_barang1" + rowstats + "' class='form-control text-center id_barang' /><input type='text' id='kode2" + rowstats + "' name='kode2" + rowstats + "' class='form-control text-center kode' required/>" +
                        "</td>" +

                        "<td><input type='text' id='nama_barang3" + rowstats + "' name='nama_barang3" + rowstats + "' class='form-control nama_barang' readonly/></td>" +

                        "<td><input type='text' id='stok4" + rowstats + "' name='stok4" + rowstats + "' class='form-control text-center stok numeric-only' onKeyUp='accSum(" + rowstats + ",1)' required placeholder='0' autocomplete='off'/></td>" +

                        "<td><input type='text' id='satuan5" + rowstats + "' name='satuan5" + rowstats + "' class='form-control text-center satuan' readonly/></td>" +

                        "<td><input type='text' id='harga_jual6" + rowstats + "' name='harga_jual6" + rowstats + "' class='form-control text-right harga_jual numeric-only iptPrice' readonly placeholder='0' required/></td>" +

                        "<td><input type='text' id='diskon_persen7" + rowstats + "' name='diskon_persen7" + rowstats + "' class='form-control text-center diskon_persen numeric-only' onKeyUp='dicSumPer(" + rowstats + ",1)' placeholder='0'/></td>" +

                        "<td><input type='text' id='diskon_nominal8" + rowstats + "' name='diskon_nominal8" + rowstats + "' class='form-control text-right diskon_nominal numeric-only iptPrice' onKeyUp='dicSum(" + rowstats + ",1)' placeholder='0'/></td>" +

                        "<td class='gray'><input type='text' id='jumlah9" + rowstats + "' name='jumlah9" + rowstats + "' placeholder='0' class='form-control text-right jumlah' readonly/></td>" +
                        "</tr>"
                    )
                    $('#kode2' + rowstats).focus();
                    break;
                }
            }

            //autocomplete
            $("#kode2" + rowstats).autocomplete({
                source: "<?= base_url() ?>penjualan/searchBarang",
                minLength: 1,
                select: function(evt, ui) {
                    var cekValidasi = validasiInput(ui.item.value, rowstats)
                    if (cekValidasi == 0) {
                        var id = ui.item.id_barang;
                        var stok = ui.item.stok;
                        var harga_jual = ui.item.harga_jual;

                        $.post('<?= base_url() ?>penjualan/validasiStok', {
                            id: id
                        }, function(e) {
                            var st = e;
                            if (st == 0) {
                                alert('Tidak dapat melakukan transaksi dengan barang ini. Stok barang ini adalah 0!');
                                $("#plus-content").prop('disabled', true);
                                $(".btnSimpan").prop('disabled', true);
                                return false;
                            } else {
                                $('#id_barang1' + rowstats).val(id);
                                $('#nama_barang3' + rowstats).val(ui.item.nama_barang);
                                $('#satuan5' + rowstats).val(ui.item.satuan);
                                $('#harga_jual6' + rowstats).val(formatHarga(harga_jual));
                                $('#diskon_nominal8' + rowstats).val(0);
                                $('#diskon_persen7' + rowstats).val(0);
                                $('#stok4' + rowstats).focus();
                                totalGen();
                                $("#plus-content").prop('disabled', false);
                                $(".btnSimpan").prop('disabled', false);
                            }
                        }, 'json');
                    } else {
                        alert('Kode barang tidak boleh double!');
                        $("#plus-content").prop('disabled', true);
                        $(".btnSimpan").prop('disabled', true);
                        return false;
                    }

                }
            });
            //end autocomplete

            // FORMAT PRICE
            $(".iptPrice").priceFormat({
                prefix: '', // Tanpa simbol mata uang
                thousandsSeparator: '.',
                centsLimit: 0,
                clearOnEmpty: true
            });

            //numeric only
            $('.numeric-only').keypress(function(e) {
                var verified = (e.which == 8 || e.which == undefined || e.which == 0) ? null : String.fromCharCode(e.which).match(/[^0-9]/);
                if (verified) {
                    e.preventDefault();
                }
            });

            if ($("#rowsCount").val() >= rowsDels) {
                rowsDels = parseInt($("#rowsCount").val());
                rowsDels = rowsDels + 1;
            } else {
                rowsDels = parseInt($("#rowsCount").val());
                rowsDels = rowsDels + 1;
            }

            $("#rowsCount").val(rowsDels);
            if (rowsDels == <?= $maxDetailInput ?>) {
                $("#plus-content").hide();
            }

            // var rows = parseInt($("#rowsCount").val());
            // $("#rowsCount").val(rows + 1);
            // if ((rows + 1) == <?= $maxDetailInput ?>) {
            //     $("#plus-content").hide();
            // }
        })

        $('#ongkir').on('keyup', function() {
            totalGen();
        })
    })

    function validasiInput(ui, row) {
        var data = 0;
        for (i = 0; i < row; i++) {
            var already = $($("#kode2" + i)).val();
            if (already == ui && i != row) {
                data += 1;
            }
        }
        return data
    }

    function deleteRows(row) {
        var rows = parseInt($("#rowsCount").val());
        $('#rows' + row).remove();
        $("#rowsCount").val(rows - 1);

        if ((rows - 1) < <?= $maxDetailInput ?>) {
            $("#plus-content").show();
        }

        var subtotal = 0;
        for (r = 1; r <= <?= $maxDetailInput ?>; r++) {
            if ($('#stok4' + r).length != 0) {
                jumlah = parseHarga($("#jumlah9" + r).val());
                subtotal += Number(jumlah);
            }
        }
        subtotal = Math.round(subtotal);
        $("#subtotal").val(formatHarga(subtotal));

        totalGen();

        var i = 1;
        $('.rowItem').each(function() {
            var hapus = $(this).find('.hapus');
            var id_barang = $(this).find('.id_barang');
            var kode = $(this).find('.kode');
            var nama_barang = $(this).find('.nama_barang');
            var stok = $(this).find('.stok');
            var satuan = $(this).find('.satuan');
            var harga_jual = $(this).find('.harga_jual');
            var diskon_persen = $(this).find('.diskon_persen');
            var diskon_nominal = $(this).find('.diskon_nominal');
            var jumlah = $(this).find('.jumlah');

            hapus.attr('id', 'btn1' + i);
            id_barang.attr('id', 'id_barang1' + i);
            kode.attr('id', 'kode2' + i);
            nama_barang.attr('id', 'nama_barang3' + i);
            stok.attr('id', 'stok4' + i);
            satuan.attr('id', 'satuan5' + i);
            harga_jual.attr('id', 'harga_jual6' + i);
            diskon_persen.attr('id', 'diskon_persen7' + i);
            diskon_nominal.attr('id', 'diskon_nominal8' + i);
            jumlah.attr('id', 'jumlah9' + i);

            hapus.attr('name', 'btn1' + i);
            id_barang.attr('name', 'id_barang1' + i);
            kode.attr('name', 'kode2' + i);
            nama_barang.attr('name', 'nama_barang3' + i);
            stok.attr('name', 'stok4' + i);
            satuan.attr('name', 'satuan5' + i);
            harga_jual.attr('name', 'harga_jual6' + i);
            diskon_persen.attr('name', 'diskon_persen7' + i);
            diskon_nominal.attr('name', 'diskon_nominal8' + i);
            jumlah.attr('name', 'jumlah9' + i);

            stok.attr('onKeyUp', 'accSum(' + i + ',1)');
            harga_jual.attr('onKeyUp', 'accSum(' + i + ',2)');
            i++;
        })
    }

    function accSum(row) {
        setTimeout(() => {
            var stok = $("#stok4" + row).val();
            var harga_jual = parseHarga($("#harga_jual6" + row).val()) || '';
            var diskon_nominal = parseHarga($("#diskon_nominal8" + row).val());

            if (diskon_nominal > harga_jual) {
                alert("Diskon tidak boleh melebihi harga beli!");
                $("#diskon_nominal8" + row).val(0);
                $("#diskon_persen7" + row).val(0);
                jumlah = stok * harga_jual;
            } else {
                var diskonPersen = (diskon_nominal / harga_jual) * 100;
                $("#diskon_persen7" + row).val(Math.round(diskonPersen));
                jumlah = stok * harga_jual - diskon_nominal;
            }

            $("#jumlah9" + row).val(formatHarga(jumlah));
            totalGen();
        }, 100);
    }

    function dicSum(row, stat) {
        setTimeout(() => {
            var stok = $("#stok4" + row).val();
            var harga_jual = parseHarga($("#harga_jual6" + row).val());
            var diskon_nominal = parseHarga($("#diskon_nominal8" + row).val());

            if (diskon_nominal >= harga_jual) {
                alert("Diskon tidak boleh melebihi harga jual!");
                $("#diskon_nominal8" + row).val(0);
                $("#diskon_persen7" + row).val(0);
                jumlah = stok * harga_jual;
            } else {
                var diskonPersen = (diskon_nominal / harga_jual) * 100;
                $("#diskon_persen7" + row).val(Math.round(diskonPersen));
                jumlah = stok * harga_jual - diskon_nominal;
            }

            $("#jumlah9" + row).val(formatHarga(jumlah));
            totalGen();
            return false;
        }, 100);
    }

    function dicSumPer(row, stat) {
        setTimeout(() => {
            var stok = $("#stok4" + row).val();
            var harga_jual = parseHarga($("#harga_jual6" + row).val());
            var diskonPersen = parseFloat($("#diskon_persen7" + row).val()) || 0;

            var diskon_nominal = (diskonPersen / 100) * harga_jual;
            $("#diskon_nominal8" + row).val(formatHarga(diskon_nominal));

            if (diskon_nominal >= harga_jual) {
                alert("Diskon tidak boleh melebihi harga jual!");
                $("#diskon_nominal8" + row).val(0);
                $("#diskon_persen7" + row).val(0);
                jumlah = stok * harga_jual;
            } else {
                var diskonPersen = (diskon_nominal / harga_jual) * 100;
                $("#diskon_persen7" + row).val(Math.round(diskonPersen));
                jumlah = stok * harga_jual - diskon_nominal;
            }

            $("#jumlah9" + row).val(formatHarga(jumlah));
            totalGen();
            return false;
        }, 100);
    }

    function totalGen() {
        e = $("#rowsCount").val();
        $("#subtotal").val(0);
        $("#total").val(0);
        var subtotal = 0;
        for (r = 1; r <= e; r++) {
            var jumlah = parseHarga($("#jumlah9" + r).val());
            subtotal += Number(jumlah);
        }
        subtotal = Math.round(subtotal);
        $("#subtotal").val(formatHarga(subtotal));

        var ongkir = parseHarga($("#ongkir").val()) || '';
        total = subtotal + ongkir;
        $('#total').val(formatHarga(total));

    }

    function DateDiff(date1, date2) {
        return (date2.getTime() - date1.getTime()) / (1000 * 60 * 60 * 24); //mengembalikan jumlah hari
    }

    Date.prototype.yyyymmdd = function() {

        var yyyy = this.getFullYear().toString();
        var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based         
        var dd = this.getDate().toString();

        return yyyy + '-' + (mm[1] ? mm : "0" + mm[0]) + '-' + (dd[1] ? dd : "0" + dd[0]);
    };
</script>