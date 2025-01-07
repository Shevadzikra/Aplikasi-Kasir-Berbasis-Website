<?php 

include 'config.php';
session_start();

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    mysqli_query($koneksi, "INSERT INTO barang VALUES ('', '$nama', '$harga', '4jumlah')");
    
    $_SESSION['success'] = 'Berhasil menambahkan data';

    header("location:./barang.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Tambah Barang</title>
</head>
<body>
    <div class="container">

        <form action="" method="post">
            <div class="form-group">
                <label for="">Nama Barang</label>
                <input type="text" name="nama" class="form-control" placeholder="Nama Barang">
            </div>
            <div class="form-group">
                <label for="">Harga</label>
                <input type="number" name="harga" class="form-control" placeholder="Harga">
            </div>
            <div class="form-group">
                <label for="">Jumlah Stok</label>
                <input type="number" name="jumlah" class="form-control" placeholder="Jumlah Stok">
            </div>
            <input type="submit" name="simpan" value="Simpan">
            <a href="./barang.php">Kembali</a>
        </form>
    </div>
</body>
</html>