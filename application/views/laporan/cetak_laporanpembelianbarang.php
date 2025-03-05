<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<h2 style="text-align: center;"><?= $title ?></h2>

<table>
    <thead>
        <tr>
            <th>No Transaksi</th>
            <th>Tanggal</th>
            <th>Supplier</th>
            <th>Subtotal</th>
            <th>Diskon</th>
            <th>Total</th>
            <th>Status Pembayaran</th>
            <th>Hutang</th>
            <th>Metode Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($laporanpembelianbarang as $pb) { 
            $supplier = $this->db->query("SELECT supplier FROM t_supplier WHERE id_supplier = $pb->id_supplier")->row()->supplier;
            $sp = ($pb->status_pembayaran == 'lunas') ? 'Lunas' : 'Belum Lunas';
            $mp = ($pb->metode_pembayaran == 'tunai') ? 'Tunai' : 'Non Tunai';
            // Hitung subtotal
            $subtotal = $pb->total + $pb->diskon;
        ?>
        <tr>
            <td><?= $pb->no_transaksi ?></td>
            <td><?= date('d-m-Y', strtotime($pb->tgl_pembelian)) ?></td>
            <td><?= $supplier ?></td>
            <td><?= number_format($subtotal, 0, ',', '.') ?></td>
            <td><?= number_format($pb->diskon, 0, ',', '.') ?></td>
            <td><?= number_format($pb->total, 0, ',', '.') ?></td>
            <td><?= $sp ?></td>
            <td><?= number_format($pb->hutang, 0, ',', '.') ?></td>
            <td><?= $mp ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>


<div style="text-align: center; margin-top: 20px;">
    <button class="btn-print" onclick="window.print()">Print</button>
</div>

</body>
</html>
