<?php

include '../config.php';
session_start();

// Query untuk mengambil data diskon dan nama barang dari tabel barang
$view = $koneksi->query('SELECT disbarang.*, barang.nama as nama_barang 
                         FROM disbarang 
                         JOIN barang ON disbarang.barang_id = barang.id_barang');

?>

<!DOCTYPE html>
<html>
<head>
    <title>List Diskon</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">

    <?php if (isset($_SESSION['success']) && $_SESSION['success'] != '') { ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['success'] ?>
        </div>
    <?php
        }
        $_SESSION['success'] = ''; // Kosongkan pesan sukses setelah ditampilkan
    ?>

    <h1>List Diskon</h1>

    <a href="./diskon_add.php" class="btn btn-primary">Tambah Data</a>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Barang</th>
            <th>Qty</th>
            <th>Potongan</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $view->fetch_array()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['nama_barang'] ?></td> <!-- Tampilkan nama barang -->
                <td><?= $row['qty'] ?></td>
                <td><?= $row['potongan'] ?></td>
                <td>
                    <a href="./diskon_edit.php?id=<?= $row['id'] ?>">Edit</a> |
                    <a href="./diskon_hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Apakah anda yakin?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>