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

if (isset($_POST['kode_barang'])) {
    $kode_barang = $_POST['kode_barang'];
    $qty = 1;

    $data = mysqli_query($koneksi,
     "SELECT * FROM barang WHERE kode_barang='$kode_barang'");

    $item = mysqli_fetch_assoc($data);

    $barang = [
        'id' => $item['id_barang'],
        'nama' => $item['nama'],
        'harga' => $item['harga'],
        'jumlah' => $item['jumlah'],
        'qty' => $qty,
    ];

    $stok_akhir = $item['jumlah'] - $qty;
    mysqli_query($koneksi, "UPDATE barang SET jumlah='$stok_akhir' WHERE id_barang='$id_barang'");

    $_SESSION['cart'][] = $barang;

    header('location:./index.php');
}