\keranjang_act.php
    <?php
    session_start();

    include 'config.php';
    include "authcheckkasir.php";

    if (isset($_POST['id_barang']) && isset($_POST['qty'])) {
        $id_barang = $_POST['id_barang'];
        $qty = $_POST['qty'];

        // Validasi input jumlah pesanan
        if ($qty <= 0) {
            $_SESSION['error'] = "Jumlah pesanan harus lebih dari 0.";
            header('Location: kasir.php');
            exit();
        }

        // Mengambil data barang berdasarkan ID
        $data = mysqli_query($dbconnect, "SELECT * FROM barang WHERE id_barang='$id_barang'");
        
        if ($data && mysqli_num_rows($data) > 0) {
            $b = mysqli_fetch_assoc($data);

            // Mengecek apakah stok mencukupi
            if ($qty > $b['jumlah']) {
                $_SESSION['error'] = "Stok tidak mencukupi! Stok tersedia: " . $b['jumlah'];
                header('Location: kasir.php');
                exit();
            }

            // Menambahkan barang ke dalam cart
            $barang_baru = [
                'id' => $b['id_barang'],
                'nama' => $b['nama'],
                'harga' => $b['harga'],
                'qty' => $qty
            ];

            // Periksa apakah barang sudah ada di keranjang
            $item_found = false;
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['id'] == $id_barang) {
                        $item['qty'] += $qty;
                        $item_found = true;
                        break;
                    }
                }
            } else {
                $_SESSION['cart'] = [];
            }

            // Jika barang belum ada di keranjang, tambahkan sebagai barang baru
            if (!$item_found) {
                $_SESSION['cart'][] = $barang_baru;
            }

            // Mengurangi stok barang di database
            $stok_akhir = $b['jumlah'] - $qty;
            mysqli_query($dbconnect, "UPDATE barang SET jumlah='$stok_akhir' WHERE id_barang='$id_barang'");

            // Pesan sukses
            $_SESSION['success'] = "Barang berhasil ditambahkan ke keranjang.";
            header('Location: kasir.php');
            exit();
        } else {
            // Jika barang tidak ditemukan, tampilkan pesan error
            $_SESSION['error'] = "Barang tidak ditemukan.";
            header('Location: kasir.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Harap pilih barang dan masukkan jumlah.";
        header('Location: kasir.php');
        exit();
    }
    ?>