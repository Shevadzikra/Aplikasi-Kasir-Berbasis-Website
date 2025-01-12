
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

if (isset($_GET['id'])) {
	
	$id = $_GET['id'];
	
	mysqli_query($koneksi, "DELETE FROM `barang` WHERE id_barang='$id' ");
	
	$_SESSION['success'] = 'Berhasil menghapus data';
	
	header("location:./index.php");
}

?>