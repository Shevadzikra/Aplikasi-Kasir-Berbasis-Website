<?php
include '../config.php';
session_start();

if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role_id'] == 1 ) {
        header("location:../login");
    }
} else {
    header("location:./kasir/");
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['nama'])) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu.";
    header("Location: login.php");
    exit();
}

// Ambil data barang dari database
$barang = mysqli_query($koneksi, "SELECT * FROM barang");
if (!$barang) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Kasir</h1>
                <h2>Hai, <?= htmlspecialchars($_SESSION['nama']); ?></h2>
                <a href="logout.php" class="btn btn-danger">Logout</a>
                <a href="./keranjang_reset.php" class="btn btn-danger">Reset Keranjang</a>
            </div>
        </div>
        <hr>
        <div class="row mt-4">
            <div class="col-md-8">
                <form method="post" action="./keranjang_act2.php" class="form-inline">
                <?php if (isset($_SESSION['error']) && $_SESSION['error'] != '') { ?>
    <div class="alert alert-danger" role="alert">
        <?= $_SESSION['error'] ?>
    </div>
<?php 
    $_SESSION['error'] = ''; // Mengosongkan session setelah menampilkan pesan
} ?>

<?php if (isset($_SESSION['success']) && $_SESSION['success'] != '') { ?>
    <div class="alert alert-success" role="alert">
        <?= $_SESSION['success'] ?>
    </div>
<?php 
    $_SESSION['success'] = ''; // Mengosongkan session setelah menampilkan pesan
} ?>

                    <div class="input-group">
                        <input type="text" name="kode_barang" class="form-control" placeholder="Kode barang">
                    </div>
                    <div class="input-group">
                        <input type="number" name="qty" class="form-control" placeholder="Jumlah">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">Tambah</button>
                        </span>
                    </div>
                </form>
                <form method="POST" action="./keranjang_update.php">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Sub Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $key => $value) {
                    $subtotal = $value['qty'] * $value['harga'];
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($value['nama']); ?></td>
                        <td><?= number_format($value['harga'], 2); ?></td>
                        <td class="col-md-2">
                            <input type="number" name="qty[<?= $value['id']; ?>]" value="<?= htmlspecialchars($value['qty']) ?>" class="form-control">
                        </td>
                        <td><?= number_format($subtotal, 2); ?></td>
                        <td>
                            <a href="./keranjang_hapus.php?id=<?= urlencode($value['id']); ?>" class="btn btn-danger" title="Hapus">
                                <i class="fas fa-times"></i> 
                            </a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Keranjang kosong</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <button type="submit" class="btn btn-success">Perbarui</button>
</form>

            </div>
            <div class="col-md-4">
                <div class="border p-3 text-center">
                    <h3>Total: <?= number_format($total, 2); ?></h3>
                    <form action="./transaksi_act.php" method="POST">
                        <input type="hidden" name="total" value="<?= htmlspecialchars($total); ?>">
                        <div class="form-group">
                            <label>Bayar</label>
                            <input type="text" id="bayar" name="bayar" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Selesai</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var bayar = document.getElementById('bayar');
        bayar.addEventListener('keyup', function (e) {
            bayar.value = formatRupiah(this.value, 'Rp. ');
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
        }
    </script>
</body>
</html>