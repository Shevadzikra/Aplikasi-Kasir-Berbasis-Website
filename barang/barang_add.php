
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

if (isset($_POST['simpan'])) {
	// echo var_dump($_POST);
	$nama = $_POST['nama'];
	$kode_barang = $_POST['kode_barang'];
	$harga = $_POST['harga'];
	$jumlah = $_POST['jumlah'];


	// Menyimpan ke database;
	mysqli_query($koneksi, "INSERT INTO barang VALUES (NULL,'$nama','$harga','$jumlah','$kode_barang')");

	$_SESSION['success'] = 'Berhasil menambahkan data';

	// mengalihkan halaman ke list barang
	header("location:./index.php");

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Tambah Barang</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Tambah Barang</h1>
        <form method="post">
            <div class="form-group mb-3">
                <label for="nama">Nama Barang</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama barang">
            </div>
            <div class="form-group mb-3">
                <label for="kode_barang">Kode Barang</label>
                <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Kode barang">
            </div>
            <div class="form-group mb-3">
                <label for="harga">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga Barang">
            </div>
            <div class="form-group mb-3">
                <label for="jumlah">Jumlah Stock</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah Stock">
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                <a href="./index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>
