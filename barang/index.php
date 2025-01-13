<?php 

include '../config.php';
session_start();

if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role_id'] == 2 ) {
        header("location:../kasir/");
    }
} else {
    header("location:../login/");
}

$view = $koneksi->query("SELECT * FROM barang");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>List Barang</title>
</head>
<body>
    <div class="container mt-5">

        <?php if (isset($_SESSION['success']) && $_SESSION['success'] != '') { ?>
            <div class="alert alert-success">
                Berhasil Menambahkan Data!
            </div>
        <?php 
            }
            $_SESSION['success'] = '';
        ?>

        <h1 class="mb-4">List Barang</h1>
        <a href="./barang_add.php" class="btn btn-primary mb-3">Tambah Barang</a>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID Barang</th>
                    <th>Kode Barang</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Jumlah Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            
            while ($row = $view->fetch_array()) { ?>
                <tr>
                    <td> <?= $row['id_barang']?> </td>
                    <td> <?= $row['kode_barang']?> </td>
                    <td> <?= $row['nama']?> </td>
                    <td> <?= $row['harga']?> </td>
                    <td> <?= $row['jumlah']?> </td>
                    <td>
                        <a href="./barang_edit.php?id=<?=$row['id_barang']?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="./barang_hapus.php?id=<?=$row['id_barang']?>" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
            <?php 
            } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
