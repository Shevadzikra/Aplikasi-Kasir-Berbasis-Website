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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data diskon berdasarkan ID
    $data = mysqli_query($koneksi, "SELECT disbarang.*, barang.nama as nama_barang 
                                    FROM disbarang 
                                    JOIN barang ON disbarang.barang_id = barang.id_barang 
                                    WHERE disbarang.id='$id'");
    $data = mysqli_fetch_assoc($data);
}

if (isset($_POST['update'])) {
    $id = $_GET['id'];

    $qty = $_POST['qty'];
    $potongan = $_POST['potongan'];

    // Update data ke database
    mysqli_query($koneksi, "UPDATE disbarang SET qty='$qty', potongan='$potongan' WHERE id='$id'");

    $_SESSION['success'] = 'Berhasil memperbarui data';

    // Redirect ke halaman list diskon
    header("location:./index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Diskon</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Edit Diskon</h1>
    <!-- Tampilkan pesan sukses jika ada -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" class="form-control" value="<?php echo $data['nama_barang']; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Batas Kuantitas</label>
            <input type="number" name="qty" class="form-control" placeholder="Batas Kuantitas" value="<?php echo $data['qty']; ?>" required>
        </div>
        <div class="form-group">
            <label>Potongan</label>
            <input type="number" name="potongan" class="form-control" placeholder="Jumlah Potongan" value="<?php echo $data['potongan']; ?>" required>
        </div>
        <input type="submit" name="update" value="Update" class="btn btn-primary">
        <a href="./index.php" class="btn btn-warning">Kembali</a>
    </form>
</div>
</body>
</html>