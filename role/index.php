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

$view = $koneksi->query("SELECT * FROM role");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Role</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['success']) && $_SESSION['success'] != '') { ?>
            <div class="alert alert-success" role="alert">
                Berhasil Menambahkan Data!
            </div>
        <?php 
            }
            $_SESSION['success'] = '';
        ?>

        <h1 class="mt-4">List Role</h1>
        <a href="./role_add.php" class="btn btn-primary mb-3">Tambah Role</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Role</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($row = $view->fetch_array()) { ?>
                <tr>
                    <td><?= $row['id_role'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td>
                        <a href="./role_edit.php?id=<?= $row['id_role'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="./role_delete.php?id=<?= $row['id_role'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
