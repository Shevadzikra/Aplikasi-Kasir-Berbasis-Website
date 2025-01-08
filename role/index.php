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
</head>
    <body>
        <div class="container">

        <?php if (isset($_SESSION['success']) && $_SESSION['success'] != '') { ?>
            <div>
                <h3>Berhasil Menambahkan Data!</h3>
            </div>
        <?php 
            }
            $_SESSION['success'] = '';
        ?>

        <h1>List Role</h1>
        <a href="./role_add.php">Tambah Role</a>
            <table border="1">
                <tr>
                    <th>ID Role</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
                <?php 
                
                while ($row = $view->fetch_array()) { 
                    // looping data barang menggunakan while kedalam bentuk array yang
                    // dimasukkan kedalam variable $row
                    ?>

                <tr>
                    <td> <?= $row['id_role']?> </td>
                    <td> <?= $row['nama']?> </td>
                    <td>
                        <a href="./role_edit.php?id=<?=$row['id_role']?>">Edit</a> |
                        <a href="./role_delete.php?id=<?=$row['id_role']?>">Hapus</a>
                    </td>
                </tr>
                <?php 
                } ?>
            </table>
        </div>
    </body>
</html>