<?php 

include '../config.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_SESSION['id_user'])) {
        if ($_SESSION['role_id'] == 2 ) {
            header("location:../kasir/");
        }
    } else {
        header("location:../login/");
    }

    $data = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = '$id'");
    $data = mysqli_fetch_assoc($data);
}

if (isset($_POST['update'])) {
    $id = $_GET['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    mysqli_query($koneksi, "UPDATE barang SET 
    nama='$nama', harga='$harga', jumlah='$jumlah' WHERE id_barang='$id'");

    header("location:./index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
</head>
<body>
    <div class="container">
        <h1>Tambah Barang</h1>
        <form action="" method="post">
        <div class="form-group">
                <label for="">Nama Barang</label>
                <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" placeholder="Nama Barang">
            </div>
            <div class="form-group">
                <label for="">Harga</label>
                <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" placeholder="Harga">
            </div>
            <div class="form-group">
                <label for="">Jumlah Stok</label>
                <input type="number" name="jumlah" class="form-control" value="<?= $data['jumlah'] ?>" placeholder="Jumlah Stok">
            </div>
            <input type="submit" value="Update" name="update">
            <a href="./barang.php">Kembali</a>
        </form>
    </div>
</body>
</html>