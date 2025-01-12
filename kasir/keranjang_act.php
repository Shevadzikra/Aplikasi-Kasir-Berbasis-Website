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

    //cek jika di keranjang sudah ada barang yang masuk
    // $key = array_search($item['id_barang'], array_column($_SESSION['cart'], 'id'));

        // $c_qty = $_SESSION['cart'][$key]['qty'];
        // $_SESSION['cart'][$key]['qty'] = $c_qty + 1;

    $barang = [
        'id' => $item['id_barang'],
        'nama' => $item['nama'],
        'harga' => $item['harga'],
        'qty' => $qty,
    ];

    $_SESSION['cart'][] = $barang;

    header('location:./index.php');
}