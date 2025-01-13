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

$barang = mysqli_query($koneksi, 'SELECT * FROM barang');
// print_r($_SESSION);

$sum = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $sum += ($value['harga'] * $value['qty']);
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="page-header">
        <h1>Kasir</h1>
        <div>
            <a href="../logout/index.php" class="btn btn-danger btn-sm">Logout</a> 
            <a href="./keranjang_reset.php" class="btn btn-warning btn-sm">Reset Keranjang</a> 
            <a href="./riwayat.php" class="btn btn-info btn-sm">Riwayat Transaksi</a>
        </div>
    </div>
    
    <hr>
    <div class="row">
        <div class="col-md-6">
            <?php if (isset($_SESSION['error']) && $_SESSION['error'] != '') { ?>
                <div class="alert alert-danger" role="alert">
                    <?=$_SESSION['error']?>
                </div>
            <?php }
            $_SESSION['error'] = '';
            ?>
            <form method="post" action="./keranjang_act.php">
                <div class="form-group">
                    <label for="kode_barcode">Masukkan Kode Barang</label>
                    <input type="text" name="kode_barang" id="kode_barcode" class="form-control" placeholder="Masukkan Kode Barang" autofocus>
                    <input type="hidden" name="qty" value="1">
                </div>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>

            <br>

            <form method="post" action="./keranjang_update.php">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Sub Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($_SESSION['cart'])): ?>
                            <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                                <tr>
                                    <td><?=$value['nama']?></td>
                                    <td align="right"><?=number_format($value['harga'])?></td>
                                    <td>
                                        <input type="number" name="qty[<?=$key?>]" value="<?=$value['qty']?>" class="form-control" min="1">
                                    </td>
                                    <td align="right"><?=number_format(($value['qty'] * $value['harga']))?></td>
                                    <td>
                                        <a href="./keranjang_delete.php?id=<?=$value['id']?>" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i> Hapus</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-warning">Perbaruhi</button>
            </form>
        </div>

        <div class="col-md-6">
            <h3>Total Rp. <?=number_format($sum)?></h3>
            <form action="./transaksi_act.php" method="POST">
                <input type="hidden" name="total" value="<?=$sum?>">
                <div class="form-group">
                    <label for="bayar">Bayar</label>
                    <input type="number" id="bayar" name="bayar" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Selesai</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById('kode_barang').focus();
</script>
</body>
</html>