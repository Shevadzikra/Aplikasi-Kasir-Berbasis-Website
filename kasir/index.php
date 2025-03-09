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

$sum = 0;
$total_diskon = 0; // Inisialisasi total diskon
$total_netto = 0; // Inisialisasi total netto
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $subtotal = $value['harga'] * $value['qty'];
        $sum += $subtotal;

        // Hitung diskon per item
        $diskon = 0;
        $diskon_query = mysqli_query($koneksi, "SELECT * FROM disbarang WHERE barang_id = '{$value['id']}'");
        if ($diskon_query && mysqli_num_rows($diskon_query) > 0) {
            $diskon_data = mysqli_fetch_assoc($diskon_query);
            $diskon_qty = $diskon_data['qty'];
            $diskon_potongan = $diskon_data['potongan'];

            // Hitung diskon berdasarkan jumlah barang yang dibeli
            if ($value['qty'] <= $diskon_qty) {
                $diskon = $diskon_potongan * $value['qty'];
            } else {
                $diskon = $diskon_potongan * $diskon_qty;
            }
        }
        $total_diskon += $diskon;

        // Hitung netto per item
        $netto = $subtotal - $diskon;
        $total_netto += $netto;

        // Simpan diskon dan netto ke session cart
        $_SESSION['cart'][$key]['diskon'] = $diskon;
        $_SESSION['cart'][$key]['netto'] = $netto;
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
            <?php if (isset($_SESSION['success']) && $_SESSION['success'] != '') { ?>
                <div class="alert alert-success">
                    Berhasil Menambahkan Data!
                </div>
            <?php 
                }
                $_SESSION['success'] = '';
            ?>
            <form method="post" action="./keranjang_tambah.php">
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
                            <th>Diskon</th>
                            <th>Netto</th>
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
                                    <td align="right"><?=number_format($value['harga'] * $value['qty'])?></td>
                                    <td align="right"><?=number_format($value['diskon'])?></td>
                                    <td align="right"><?=number_format($value['netto'])?></td>
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
            <h3>Diskon Rp. <?=number_format($total_diskon)?></h3>
            <h3>Netto Rp. <?=number_format($total_netto)?></h3>
            <form action="./transaksi_act.php" method="POST">
                <input type="hidden" id="total" name="total" value="<?=$sum?>">
                <input type="hidden" id="total_diskon" name="total_diskon" value="<?=$total_diskon?>">
                <input type="hidden" id="total_netto" name="total_netto" value="<?=$total_netto?>">
                <div class="form-group">
                    <label for="bayar">Bayar</label>
                    <input type="number" id="bayar" name="bayar" class="form-control" required oninput="hitungKembalian()">
                    <label for="donasi">Donasi</label>
                    <input type="number" id="donasi" name="donasi" class="form-control">
                    <label for="kembali">Kembali</label>
                    <input type="number" id="kembali" name="kembali" class="form-control" readonly>
                </div>
                <button type="submit" class="btn btn-success">Selesai</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById('kode_barang').focus();

    function hitungKembalian() {
        var total_netto = parseInt(document.getElementById('total_netto').value) || 0;
        var bayar = parseInt(document.getElementById('bayar').value) || 0;
        var kembali = bayar - total_netto;
        document.getElementById('kembali').value = kembali >= 0 ? kembali : 0;
    }
</script>
</body>
</html>