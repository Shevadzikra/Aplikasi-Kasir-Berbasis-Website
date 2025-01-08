<?php 

include '../config.php';
session_start();

$role = mysqli_query($koneksi, "SELECT * FROM role");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $data = mysqli_query($koneksi, "SELECT * FROM role WHERE id_role = '$id'");
    $data = mysqli_fetch_assoc($data);
}

if (isset($_POST['update'])) {
    $id = $_GET['id'];
    $nama = $_POST['nama'];

    // Perbaikan query dengan klausa WHERE
    mysqli_query($koneksi, "UPDATE role SET nama='$nama' WHERE id_role='$id'");
    
    $_SESSION['success'] = 'Berhasil memperbarui data';

    header("location:./index.php");
    exit(); // Tambahkan exit setelah header
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Tambah Users</title>
</head>
<body>
    <div class="container">

        <form action="" method="post">
            <div class="form-group">
                <label for="">Nama</label>
                <?php { ?>
                    <input type="text" name="nama" class="form-control" placeholder="<?=$data['nama']?>">
                <?php } ?>
            </div>
            <input type="submit" name="update" value="Update">
            <a href="./index.php">Kembali</a>
        </form>
    </div>
</body>
</html>