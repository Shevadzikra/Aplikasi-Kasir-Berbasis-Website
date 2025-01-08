<?php 

include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    mysqli_query($koneksi, "DELETE FROM users WHERE id_user='$id'");

    header("location:./user.php");
}

?>