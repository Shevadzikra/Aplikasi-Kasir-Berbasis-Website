<?php 

include '../config.php';
session_start();

if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role_id'] == 1 ) {
        header("location:../login");
    }
} else {
    header("location:../kasir/");
}

if(isset($_POST['id_barang'])) {

    $id_barang = $_POST['id_barang'];
    $qty = $_POST['qty'];

    $data = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id_barang'");
    $item = mysqli_fetch_assoc($data);

    $barang = [
        'id' => $item['id_barang'],
        'nama' => $item['nama'],
        'harga' => $item['harga'],
        'qty' => $qty
    ];

    $_SESSION['cart'][] = $barang;

    header("location:./");

}

?>