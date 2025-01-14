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

$view = $koneksi->query('SELECT * FROM transaksi ORDER BY tanggal_waktu DESC');
// return var_dump($view);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Riwayat Transaksi</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">

	<?php if (isset($_SESSION['success']) && $_SESSION['success'] != '') {?>

		<div class="alert alert-success" role="alert">
			<?=$_SESSION['success']?>
		</div>

	<?php
        }
        $_SESSION['success'] = '';
    ?>

    <h1>Riwayat Transaksi</h1>
    <a href="./">Kembali</a>
	<table class="table table-bordered">
		<tr>
			<th>#Nomor</th>
			<th>Tanggal</th>
			<th>Total</th>
			<th>Kasir</th>
			<th></th>
		</tr>
		<?php

        while ($row = $view->fetch_array()) { ?>

		<tr>
			<td> <?= $row['nomor'] ?> </td>
			<td><?= $row['tanggal_waktu'] ?></td>
			<td><?=$row['total']?></td>
			<td><?=$row['nama']?></td>
			<td>
                <a href="./unduh_struk.php?idtrx=<?=$row['id_transaksi']?>" class="btn btn-primary">Cetak</a>
			</td>
		</tr>

		<?php }
        ?>

	</table>
</div>
</body>
</html>