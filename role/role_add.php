<?php 

include '../config.php';
session_start();

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];

    mysqli_query($koneksi, "INSERT INTO role VALUES ('', '$nama')");
    
    $_SESSION['success'] = 'Berhasil menambahkan data';

    header("location:./index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Tambah Role</title>
</head>
<body>
    <div class="container">

        <form action="" method="post">
            <div class="form-group">
                <label for="">Nama</label>
                <input type="text" name="nama" class="form-control" placeholder="Nama">
            </div>
            <input type="submit" name="simpan" value="Simpan">
            <a href="./index.php">Kembali</a>
        </form>
    </div>
</body>
</html>