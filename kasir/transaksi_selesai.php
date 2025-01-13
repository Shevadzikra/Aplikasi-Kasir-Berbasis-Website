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
	<style type="text/css">
		@media print {
            @page {
                size: 80mm 100mm; /* Ukuran kertas thermal */
                margin: 0;
            }

            body {
                width: 80mm;
                font-size: 12px;
            }

            .struk {
                text-align: center;
            }

			#info td, #info th{
				visibility: visible;
			}

            button {
                display: none;
            }
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
				<td valign="top">
					<?=$row['nama']?>
				</td>
				<td valign="top"><?=$row['qty']?></td>
				<td  valign="top" align="left"><?=number_format($row['harga'])?></td>
				<td valign="top" align="left">
					<?=number_format($row['total'])?>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="4"><hr></td>
			</tr>
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
				<th>Terimkasih, Selamat Belanja Kembali</th>
			</tr>
			<button onclick="window.print()">Cetak</button>
		</table>
	</div>
</body>
</html>