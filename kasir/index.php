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
<html>
<head>
	<title>Kasir</title>
</head>
<body>
<h1>Halaman Kasir</h1>
<a href="../logout/">Logout</a>
<div class="container">
        <div>
            <form action="./keranjang_act.php" method="post">
                <div>
                    <select name="id_barang" required>
                        <option>Pilih Barang</option>
                        <?php while ($row = mysqli_fetch_array($barang)) { ?>
                            <option value="<?=$row['id_barang']?>"><?=$row['nama']?></option>
                        <?php } ?>
                    </select>
                    <span>
                        <input type="number" name="qty" placeholder="Jumlah" required>
                        <button type="submit">Tambah</button>
                        <button><a href="./keranjang_reset.php">Reset Keranjang</a></button>
                    </span>
                </div>
            </form>
            <table border="1">
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Sub Total</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                <tr>
                    <td><?=$value['nama']?></td>
                    <td align="right">Rp<?=number_format($value['harga'])?></td>
                    <td align="center"><?=$value['qty']?></td>
                    <td align="right">Rp<?=number_format($value['qty'] * $value['harga'])?></td>
                    <td><a href="./keranjang_delete.php?id=<?=$value['id']?>">Hapus</a></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <div>
            <h3>Total: Rp<?=number_format($sum)?> </h3>
        </div>
    </div>
<script type="text/javascript">

	//inisialisasi inputan
	var bayar = document.getElementById('bayar');

	bayar.addEventListener('keyup', function (e) {
        bayar.value = formatRupiah(this.value, 'Rp. ');
        // harga = cleanRupiah(dengan_rupiah.value);
        // calculate(harga,service.value);
    });

    //generate dari inputan angka menjadi format rupiah

	function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    //generate dari inputan rupiah menjadi angka

    function cleanRupiah(rupiah) {
        var clean = rupiah.replace(/\D/g, '');
        return clean;
        // console.log(clean);
    }
</script>
</body>
</html>