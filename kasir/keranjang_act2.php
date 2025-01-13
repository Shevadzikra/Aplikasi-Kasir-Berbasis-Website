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

    if (isset($_POST['id_barang']) && isset($_POST['qty'])) {
        $kode_barang = $_POST['kode_barang'];
        $qty = $_POST['qty'];

        // Validasi input jumlah pesanan
        if ($qty <= 0) {
            $_SESSION['error'] = "Jumlah pesanan harus lebih dari 0.";
            header('location: ./');
            exit();
        }

        // Mengambil data barang berdasarkan ID
        $data = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang='$kode_barang'");
        
        if ($data && mysqli_num_rows($data) > 0) {
            $item = mysqli_fetch_assoc($data);

            // Mengecek apakah stok mencukupi
            if ($qty > $item['jumlah']) {
                $_SESSION['error'] = "Stok tidak mencukupi! Stok tersedia: " . $item['jumlah'];
                header('location: ./');
                exit();
            }

            // Menambahkan barang ke dalam cart
            $barang = [
                'id' => $item['id_barang'],
                'nama' => $item['nama'],
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah'],
                'qty' => $qty
            ];

            // Mengurangi stok barang di database
            $stok_akhir = $item['jumlah'] - $qty;
            mysqli_query($koneksi, "UPDATE barang SET jumlah='$stok_akhir' WHERE kode_barang='$kode_barang'");

            // Pesan sukses
            $_SESSION['success'] = "Barang berhasil ditambahkan ke keranjang.";
            header('location: ./');
            exit();
        }

    } else {
        $_SESSION['error'] = "Harap pilih barang dan masukkan jumlah.";
        header('location: ./');
        exit();
    }
    ?>