<?php
include '../config.php';
session_start();

if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role_id'] == 1) {
        header("location:../login");
    }
} else {
    header("location:../kasir/");
}

if (isset($_POST['kode_barang']) && isset($_POST['qty'])) {
    $kode_barang = $_POST['kode_barang'];
    $qty = (int)$_POST['qty'];

    if ($qty <= 0) {
        $_SESSION['error'] = "Jumlah pesanan harus lebih dari 0.";
        header('Location: ./');
        exit();
    }

    $data = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang='$kode_barang'");

    if ($data && mysqli_num_rows($data) > 0) {
        $item = mysqli_fetch_assoc($data);
        $id_barang = $item['id_barang'];
        $stok_tersedia = $item['jumlah'];

        $item_found = false;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as &$cart_item) {
                if ($cart_item['id'] == $id_barang) {
                    if (($cart_item['qty'] + $qty) > $stok_tersedia) {
                        $_SESSION['error'] = "Stok tidak mencukupi! Stok tersedia: " . $stok_tersedia;
                        header('Location: ./');
                        exit();
                    }
                    $cart_item['qty'] += $qty;
                    $item_found = true;
                    break;
                }
            }
        }

        if (!$item_found) {
            if ($qty > $stok_tersedia) {
                $_SESSION['error'] = "Stok tidak mencukupi! Stok tersedia: " . $stok_tersedia;
                header('Location: ./');
                exit();
            }
            $_SESSION['cart'][] = [
                'id' => $item['id_barang'],
                'nama' => $item['nama'],
                'harga' => $item['harga'],
                'qty' => $qty
            ];
        }

        $_SESSION['success'] = "Barang berhasil ditambahkan ke keranjang.";
        header('Location: ./');
        exit();
    } else {
        $_SESSION['error'] = "Barang tidak ditemukan.";
        header('Location: ./');
        exit();
    }
} else {
    $_SESSION['error'] = "Harap pilih barang dan masukkan jumlah.";
    header('Location: ./');
    exit();
}
?>
