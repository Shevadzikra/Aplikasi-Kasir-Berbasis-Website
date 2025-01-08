<?php 

include '../config.php';

session_start();

$view = $koneksi->query("SELECT u.*, r.nama as nama_role FROM 
users as u INNER JOIN role as r ON u.role_id=r.id_role");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Users</title>
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

<h1>List Users</h1>
<a href="./user_add.php">Tambah Users</a>
<table border="1">
    <tr>
        <th>ID User</th>
        <th>Nama</th>
        <th>Username</th>
        <th>Password</th>
        <th>Role Access</th>
        <th>Aksi</th>
    </tr>
    <?php 
    
    while ($row = $view->fetch_array()) { 
        // looping data barang menggunakan while kedalam bentuk array yang
        // dimasukkan kedalam variable $row
        ?>

    <tr>
        <td> <?= $row['id_user']?> </td>
        <td> <?= $row['nama']?> </td>
        <td> <?= $row['username']?> </td>
        <td> <?= $row['password']?> </td>
        <td> <?= $row['nama_role']?> </td>
        <td>
            <a href="./user_edit.php?id=<?=$row['id_user']?>">Edit</a> |
            <a href="./user_delete.php?id=<?=$row['id_user']?>">Hapus</a>
        </td>
    </tr>
    <?php 
    } ?>
</table>
</div>
</body>
</html>