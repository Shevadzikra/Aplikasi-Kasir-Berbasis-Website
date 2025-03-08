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

if (isset($_POST['simpan'])) {
    $barang = $_POST['barang'];
    $qty = $_POST['qty'];
    $potongan = $_POST['potongan'];

    // Validasi: Cek apakah barang sudah memiliki diskon
    $cek_diskon = mysqli_query($koneksi, "SELECT * FROM disbarang WHERE barang_id = '$barang'");
    if (mysqli_num_rows($cek_diskon) > 0) {
        $_SESSION['error'] = 'Barang ini sudah memiliki diskon. Tidak bisa menambahkan diskon lagi.';
        header("location:./diskon_add.php");
    } else {
        // Menyimpan ke database jika barang belum memiliki diskon
        mysqli_query($koneksi, "INSERT INTO disbarang VALUES (NULL,'$barang','$qty','$potongan')");

        $_SESSION['success'] = 'Berhasil menambahkan data';
    }

    // Mengalihkan halaman ke list diskon
    header("location:./index.php");
    exit();
}

// Ambil data barang dari tabel barang
$query_barang = mysqli_query($koneksi, "SELECT id_barang, nama FROM barang");
$barang_options = [];
while ($row = mysqli_fetch_assoc($query_barang)) {
    $barang_options[] = $row;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Diskon</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Tambah Diskon</h1>
    <!-- Tampilkan pesan error jika ada -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Tampilkan pesan sukses jika ada -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Nama Barang</label>
            <select name="barang" class="form-control" required>
                <?php foreach ($barang_options as $barang): ?>
                    <option value="<?php echo $barang['id_barang']; ?>"><?php echo $barang['nama']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Batas Nominal</label>
            <input type="number" name="qty" class="form-control" placeholder="Batas Nominal" required>
        </div>
        <div class="form-group">
            <label>Potongan</label>
            <input type="number" name="potongan" class="form-control" placeholder="Jumlah Potongan" required>
        </div>
        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
        <a href="./index.php" class="btn btn-warning">Kembali</a>
    </form>
</div>
</body>
</html>