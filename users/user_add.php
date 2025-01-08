<?php 

include '../config.php';
session_start();

$role = mysqli_query($koneksi, "SELECT * FROM role");

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role_id = $_POST['role_id'];

    mysqli_query($koneksi, "INSERT INTO users VALUES ('', '$nama', '$username', '$password', '$role_id')");
    
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
            <input type="submit" name="simpan" value="Simpan">
            <a href="./index.php">Kembali</a>
        </form>
    </div>
</body>
</html>