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

$qty = $_POST['qty'];
$cart = $_SESSION['cart'];

// print_r($qty);

foreach ($cart as $key => $value) {
    $_SESSION['cart'][$key]['qty'] = $qty[$key];

    // $id_barang = $_SESSION['cart'][$key]['id'];
    // //cek diskon barang
    // $disbarang = mysqli_query($koneksi, "SELECT * FROM disbarang WHERE barang_id='$id_barang'");
    // $disb = mysqli_fetch_assoc($disbarang);

    // //cek jika di keranjang sudah ada barang yang masuk
    // $key = array_search($id_barang, array_column($_SESSION['cart'], 'id'));
    // // return var_dump($key);
    // if ($key !== false) {
    //     // return var_dump($_SESSION['cart']);

    //     //cek jika ada potongan dan cek jumlah barang lebih besar sama dengan minimum order potongan
    //     if ($disb['qty'] && $_SESSION['cart'][$key]['qty'] >= $disb['qty']) {

    //         //cek kelipatan jumlah barang dengan batas minimum order
    //         $mod = $_SESSION['cart'][$key]['qty'] % $disb['qty'];

    //         if ($mod == 0) {

    //             //Jika benar jumlah barang kelipatan batas minimum order
    //             $d = $_SESSION['cart'][$key]['qty'] / $disb['qty'];
    //         } else {

    //             //Simpan jumlah potongan yang didapat
    //             $d = ($_SESSION['cart'][$key]['qty'] - $mod) / $disb['qty'];
    //         }

    //         //Simpan diskon dengan jumlah kelipatan dikali potongan barang
    //         $_SESSION['cart'][$key]['diskon'] = $d * $disb['potongan'];
    //     }
    // }
}

header('location:./');