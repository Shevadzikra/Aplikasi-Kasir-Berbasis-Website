<?php
include '../config.php';
session_start();

if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role_id'] == 1 ) {
        header("location:../login");
    }
} else {
    header("location:./kasir/");
}

$id_trx = $_GET['idtrx'];

$data = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_transaksi='$id_trx'");
$trx = mysqli_fetch_assoc($data);

$detail = mysqli_query($koneksi, "SELECT transaksi_detail.*, barang.nama 
FROM `transaksi_detail` INNER JOIN barang ON transaksi_detail.id_barang=barang.id_barang 
WHERE transaksi_detail.id_transaksi='$id_trx'");

// Hitung total diskon, netto, dan jumlah barang yang dipesan
$total_diskon = 0;
$total_netto = 0;
$total_jumlah_barang = 0; // Variabel untuk total jumlah barang
while ($row = mysqli_fetch_assoc($detail)) {
    $total_diskon += $row['diskon'];
    $total_netto += $row['netto'];
    $total_jumlah_barang += $row['qty']; // Tambahkan qty ke total jumlah barang
}
// Reset pointer result set
mysqli_data_seek($detail, 0);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kasir Selesai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            border: 1px solid black;
            margin: 0;
            padding: 0 1mm 0 1mm;
            width: 70mm; /* Lebar struk */
            font-size: 12px;
            color: #333;
        }

        @page {
            size: 70mm auto; /* Ukuran kertas */
            margin: 0;
        }

        @media print {
            #cetakButton {
                display: none; /* Sembunyikan tombol saat dicetak */
            }
        }

        .struk {
            text-align: center;
        }

        .struk h2 {
            font-size: 16px;
            margin: 5px 0;
        }

        .struk p {
            margin: 3px 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        table td {
            font-size: 12px;
            padding: 3px 0;
        }

        table td:last-child {
            text-align: right;
        }

        hr {
            border: 0;
            border-top: 1px solid black;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="struk">
        <!-- Header Struk -->
        <h2>Senyum Media</h2>
        <p>Jl Kalimantan No 7 Jember</p>
        <p>Telp WA 0331-32 : 333 / 0811 356 0100</p>
        <p>CV. SENYUMINDO MEDIATAMA</p>
        <p>NPWP : 01.618.135.1-651.000</p>
        <hr>

        <!-- Informasi Transaksi -->
        <p>CUST UMUM</p>
        <hr>
        <p>#<?= $trx['nomor'] ?> | <?= date('d-m-Y H:i:s', strtotime($trx['tanggal_waktu'])) ?> Kasir: <?= $trx['nama'] ?></p>
        <hr>

        <!-- Detail Barang -->
        <table border="1">
            <?php while ($row = mysqli_fetch_array($detail)) { ?>
                <tr>
                    <td style="text-align: left;"><?= $row['id_barang'] ?></td>
                    <td style="text-align: left;"><?= $row['nama'] ?></td>
                </tr>
                <tr>
                    <td><?= $row['qty'] ?> PCS x</td>
                    <td><?= number_format($row['harga']) ?></td>
                    <td><?= number_format($row['total']) ?></td>
                </tr>
                <tr>
                    <td colspan="2">Diskon</td>
                    <td><?= number_format($row['diskon']) ?></td>
                </tr>
                <tr>
                    <td colspan="2">Netto</td>
                    <td><?= number_format($row['netto']) ?></td>
                </tr>
            <?php } ?>
            <tr><td colspan="3"><hr></td></tr>
            <tr>
                <td class="total_jumlah_pesanan"><?= $total_jumlah_barang ?></td>
                <td colspan="1">Total</td>
                <td><?= number_format($trx['total']) ?></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="1">Total Diskon</td>
                <td><?= number_format($total_diskon) ?></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="1">Total Netto</td>
                <td><?= number_format($total_netto) ?></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="1">Bayar</td>
                <td><?= number_format($trx['bayar']) ?></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="1">Donasi</td>
                <td><?= number_format($trx['donasi']) ?></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="1">Kembali</td>
                <td><?= number_format($trx['kembali']) ?></td>
            </tr>
        </table>

        <!-- Footer Struk -->
        <hr>
        <div style="text-align: left; border: 1px solid black;">
            <p style="font-size: 10px;">Barang yang sudah dibeli tidak bisa</p>
            <p style="font-size: 10px;">ditukarkan/dikembalikan. Kecuali ada perjanjian lebih</p>
            <p style="font-size: 10px;">dahulu</p>
        </div>
        <div style="text-align: left; border: 1px solid black; margin-top: 3px; font-weight: bold;">
            <p style="font-size: 10px;">Komplin / Keluhan Pelanggan:</p>
            <p style="font-size: 10px;">Whatsapp: 08113560100</p>
            <p style="font-size: 10px;">(Foto Struk+Barang)</p>
            <p style="font-size: 10px;">Instagram / Tiktok: senyummedia</p>
        </div>
        <hr>
    </div>

    <script>
        document.getElementById('cetakButton').addEventListener('click', function() {
            console.log('Tombol Cetak diklik. Memulai proses pencetakan.');
        });
    </script>
</body>
</html>