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

?>

<!DOCTYPE html>
<html>
<head>
    <title>Kasir Selesai</title>
    <style>
    body {
            color: #a7a7a7;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0 0 0 3mm; /* Padding: atas 5mm, kanan 0, bawah 0, kiri 10mm */
            width: 70mm; /* Lebar tetap */
            font-size: 12px;
            color: #333;
        }

        #cetakButton {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
            display: none;
        }
        #cetakButton:hover {
            background-color: #0056b3;
        }
        
        @page {
            size: 70mm auto; /* Tinggi auto */
            margin: 0;
        }

        @media print {
            #cetakButton {
                display: none; /* Sembunyikan tombol saat dicetak */
            }
        }

        .content {
            text-align: center;
        }

        .content h1 {
            font-size: 14px;
            margin: 5px 0;
        }

        .content p {
            margin: 3px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        table td {
            font-size: 12px;
            text-align: left;
        }

        table td:last-child {
            text-align: right;
        }
    </style>
</head>
<body>
    <div align="center" class="struk">
        <table width="500" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <th>Toko Raja Iblis <br>
                    Jl Jawa nomer 69<br>
                </th>
            </tr>
            <tr align="center"><td><hr></td></tr>
            <tr>
                <td>#<?=$trx['nomor']?> | <?=date('d-m-Y H:i:s', strtotime($trx['tanggal_waktu']))?> <?=$trx['nama']?></td>
            </tr>
            <tr><td><hr></td></tr>
        </table>
        <table width="500" border="0" cellpadding="3" cellspacing="0">
            <?php while ($row = mysqli_fetch_array($detail)) { ?>
            <tr>
                <td valign="top"><?=$row['nama']?></td>
                <td valign="top"><?=$row['qty']?></td>
                <td valign="top" align="left"><?=number_format($row['harga'])?></td>
                <td valign="top" align="left"><?=number_format($row['total'])?></td>
            </tr>
            <?php } ?>
            <tr><td colspan="4"><hr></td></tr>
            <tr>
                <td align="left" colspan="3">Total</td>
                <td align="left"><?=number_format($trx['total'])?></td>
            </tr>
            <tr>
                <td align="left" colspan="3">Bayar</td>
                <td align="left"><?=number_format($trx['bayar'])?></td>
            </tr>
            <tr>
                <td align="left" colspan="3">Kembali</td>
                <td align="left"><?=number_format($trx['kembali'])?></td>
            </tr>
        </table>
        <table width="500" border="0" cellpadding="1" cellspacing="0">
            <tr><td><hr></td></tr>
            <tr>
                <th>Terimakasih, Selamat Belanja Kembali</th>
            </tr>
        </table>
    </div>
    <div align="center">
        <button id="cetakButton" onclick="window.print()">Cetak</button>
    </div>
	<script>
		document.getElementById('cetakButton').addEventListener('click', function() {
            console.log('Tombol Cetak diklik. Memulai proses pencetakan.');
        });
	</script>
</body>
</html>
