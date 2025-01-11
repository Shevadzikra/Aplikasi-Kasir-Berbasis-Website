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

$role = mysqli_query($koneksi, "SELECT * FROM role");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $data = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id'");
    $data = mysqli_fetch_assoc($data);
}

if (isset($_POST['update'])) {
    $id = $_GET['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role_id = $_POST['role_id'];

    mysqli_query($koneksi, "UPDATE users SET
    nama='$nama', username='$username', password='$password', role_id='$role_id' WHERE id_user='$id'");
    
    $_SESSION['success'] = 'Berhasil memperbarui data';

    header("location:./index.php");
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
                <input type="text" name="nama" class="form-control" placeholder="Nama">
            </div>
            <div class="form-group">
                <label for="">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="">Role</label>
                <select name="role_id" class="form-control">
                    <option>Pilih Role Akses</option>
                    <?php while ($row = mysqli_fetch_array($role)) {?>
                        <option value="<?=$row['id_role']?>"><?=$row['nama']?></option>
                    <?php }?>
                </select>
            </div>
            <input type="submit" name="update" value="Update">
            <a href="./index.php">Kembali</a>
        </form>
    </div>
</body>
</html>