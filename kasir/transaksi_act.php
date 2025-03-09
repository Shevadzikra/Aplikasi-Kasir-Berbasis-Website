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
    $donasi = (int)$_POST['donasi'];
    $total_diskon = (int)$_POST['total_diskon'];
    $total_netto = (int)$_POST['total_netto'];
    $bayar = (int)preg_replace('/\D/', '', $_POST['bayar']);
    $nama = $_SESSION['nama'];
    $kembali = $bayar - $total_netto;

    if ($bayar < $total_netto) {
        $_SESSION['error'] = "Jumlah pembayaran kurang. MINGGIR LU MISKIN!!";
        header('Location: ./');
        exit();
    }

    // Insert ke tabel transaksi
    mysqli_query($koneksi, 
    "INSERT INTO transaksi (id_transaksi, tanggal_waktu, nomor, total, nama, bayar, kembali, donasi) 
    VALUES (NULL, '$tanggal_waktu', '$nomor', '$total', '$nama', '$bayar', '$kembali', '$donasi')");

    $id_transaksi = mysqli_insert_id($koneksi);

    // Insert ke tabel detail transaksi
    foreach ($_SESSION['cart'] as $item) {
        $id_barang = $item['id'];
        $harga = $item['harga'];
        $qty = $item['qty'];
        $subtotal = $harga * $qty;
        $diskon = $item['diskon'];
        $netto = $item['netto'];

        mysqli_query($koneksi,
        "INSERT INTO transaksi_detail (id_transaksi_detail, id_transaksi, id_barang, qty, total, harga, diskon, netto) 
        VALUES (NULL, '$id_transaksi', '$id_barang', '$qty', '$subtotal', '$harga', '$diskon', '$netto')");

        // Update stok barang
        $data_barang = mysqli_query($koneksi, "SELECT jumlah FROM barang WHERE id_barang='$id_barang'");
        $barang = mysqli_fetch_assoc($data_barang);
        $stok_akhir = $barang['jumlah'] - $qty;
        mysqli_query($koneksi, "UPDATE barang SET jumlah='$stok_akhir' WHERE id_barang='$id_barang'");

        // Kurangi qty pada tabel disbarang jika ada diskon
        $diskon_query = mysqli_query($koneksi, "SELECT * FROM disbarang WHERE barang_id='$id_barang'");
        if ($diskon_query && mysqli_num_rows($diskon_query) > 0) {
            $diskon_data = mysqli_fetch_assoc($diskon_query);
            $diskon_qty = $diskon_data['qty'];
            if ($diskon_qty > 0) {
                $diskon_qty_akhir = $diskon_qty - $qty;
                if ($diskon_qty_akhir < 0) {
                    $diskon_qty_akhir = 0; // Pastikan qty tidak kurang dari 0
                }
                mysqli_query($koneksi, "UPDATE disbarang SET qty='$diskon_qty_akhir' WHERE id='{$diskon_data['id']}'");
            }
        }
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