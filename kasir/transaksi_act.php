<?php
include '../config.php';
session_start();

if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role_id'] == 1 ) {
        header("location:../login");
        exit();
    }
} else {
    header("location:./kasir/");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $tanggal_waktu = date('Y-m-d H:i:s');
    $nomor = rand(111111, 999999);
    $total = (int)$_POST['total'];
    $bayar = (int)preg_replace('/\D/', '', $_POST['bayar']);
    $nama = $_SESSION['nama'];
    $kembali = $bayar - $total;

    if ($bayar < $total) {
        $_SESSION['error'] = "Jumlah pembayaran kurang. MINGGIR LU MISKIN!!";
        header('Location: ./');
        exit();
    }

    // Insert ke tabel transaksi
    mysqli_query($koneksi, 
    "INSERT INTO transaksi (id_transaksi, tanggal_waktu, nomor, total, nama, bayar, kembali) 
    VALUES (NULL, '$tanggal_waktu', '$nomor', '$total', '$nama', '$bayar', '$kembali')");

    $id_transaksi = mysqli_insert_id($koneksi);

    // Insert ke tabel detail transaksi
    foreach ($_SESSION['cart'] as $item) {
        $id_barang = $item['id'];
        $harga = $item['harga'];
        $qty = $item['qty'];
        $tot = $harga * $qty;

        mysqli_query($koneksi,
        "INSERT INTO transaksi_detail (id_transaksi_detail, id_transaksi, id_barang, qty, total, harga) 
        VALUES (NULL, '$id_transaksi', '$id_barang', '$qty', '$tot', '$harga')");

        // Update stok barang
        $data_barang = mysqli_query($koneksi, "SELECT jumlah FROM barang WHERE id_barang='$id_barang'");
        $barang = mysqli_fetch_assoc($data_barang);
        $stok_akhir = $barang['jumlah'] - $qty;
        mysqli_query($koneksi, "UPDATE barang SET jumlah='$stok_akhir' WHERE id_barang='$id_barang'");
    }

    $_SESSION['cart'] = [];
    header("Location: ./transaksi_selesai.php?idtrx=".$id_transaksi);
    exit();
} else {
    $_SESSION['error'] = "Keranjang kosong atau data tidak valid.";
    header('Location: ./');
    exit();
}
?>
