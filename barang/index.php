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
    <div class="container">

        <?php if (isset($_SESSION['success']) && $_SESSION['success'] != '') { ?>
            <div>
                <h3>Berhasil Menambahkan Data!</h3>
            </div>
        <?php 
            }
            $_SESSION['success'] = '';
        ?>

        <h1>List Barang</h1>
        <a href="./barang_add.php">Tambah Barang</a>
        <table class="table table-bordered">
            <tr>
                <th>ID Barang</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Jumlah Stok</th>
                <th>Aksi</th>
            </tr>
            <?php 
            
            while ($row = $view->fetch_array()) { 
                // looping data barang menggunakan while kedalam bentuk array yang
                // dimasukkan kedalam variable $row
                ?>

            <tr>
                <td> <?= $row['id_barang']?> </td>
                <td> <?= $row['nama']?> </td>
                <td> <?= $row['harga']?> </td>
                <td> <?= $row['jumlah']?> </td>
                <td>
                    <a href="./barang_edit.php?id=<?=$row['id_barang']?>">Edit</a> |
                    <a href="./barang_hapus.php?id=<?=$row['id_barang']?>">Hapus</a>
                </td>
            </tr>
            <?php 
            } ?>
        </table>
    </div>
</body>
</html>