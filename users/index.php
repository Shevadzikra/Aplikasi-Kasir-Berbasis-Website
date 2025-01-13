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

$view = $koneksi->query("SELECT u.*, r.nama as nama_role FROM 
users as u INNER JOIN role as r ON u.role_id=r.id_role");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>List Users</title>
</head>
<body>
    <div class="container mt-5">
        <?php if (isset($_SESSION['success']) && $_SESSION['success'] != '') { ?>
            <div class="alert alert-success">
                <h3>Berhasil Menambahkan Data!</h3>
            </div>
        <?php 
            $_SESSION['success'] = '';
        } ?>

        <h1 class="mb-4">List Users</h1>
        <a href="./user_add.php" class="btn btn-primary mb-3">Tambah Users</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID User</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Role Access</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $view->fetch_array()) { ?>
                    <tr>
                        <td><?= $row['id_user'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['password'] ?></td>
                        <td><?= $row['nama_role'] ?></td>
                        <td>
                            <a href="./user_edit.php?id=<?=$row['id_user']?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="./user_delete.php?id=<?=$row['id_user']?>" class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
