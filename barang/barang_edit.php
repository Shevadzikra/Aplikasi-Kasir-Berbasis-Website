
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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    //menampilkan data berdasarkan ID
    $data = mysqli_query($koneksi, "SELECT * FROM barang where id_barang='$id'");
    $data = mysqli_fetch_assoc($data);
}

if (isset($_POST['update'])) {
    $id = $_GET['id'];

    $nama = $_POST['nama'];
    $kode_barang = $_POST['kode_barang'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    // Menyimpan ke database;
    mysqli_query($koneksi, "UPDATE barang SET nama='$nama', harga='$harga', jumlah='$jumlah', kode_barang='$kode_barang' where id_barang='$id' ");

    $_SESSION['success'] = 'Berhasil memperbaruhi data';

    // mengalihkan halaman ke list barang
    header('location:./index.php');
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Perbaruhi Barang</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Barang</h1>
        <form method="post">
            <div class="form-group mb-3">
                <label for="nama">Nama Barang</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama barang" value="<?=$data['nama']?>">
            </div>
            <div class="form-group mb-3">
                <label for="kode_barang">Kode Barang</label>
                <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Kode barang" value="<?=$data['kode_barang']?>">
            </div>
            <div class="form-group mb-3">
                <label for="harga">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga Barang" value="<?=$data['harga']?>">
            </div>
            <div class="form-group mb-3">
                <label for="jumlah">Jumlah Stock</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah Stock" value="<?=$data['jumlah']?>">
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" name="update">Perbaruhi</button>
                <a href="./index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>
