<?php

include '../config.php';
session_start();

if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role_id'] == 1) {
        header("location:../login");
    }
} else {
    header("location:./kasir/");
}

$nama_user = $_SESSION['nama']; // ambil nama pengguna dari sesi

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Jumlah baris per halaman
$offset = ($page - 1) * $limit;

$total_query = $koneksi->query("SELECT COUNT(*) AS total FROM transaksi WHERE nama='$nama_user'");
$total_result = $total_query->fetch_assoc();
$total_data = $total_result['total'];
$total_pages = ceil($total_data / $limit);

$view = $koneksi->query("SELECT * FROM transaksi WHERE nama='$nama_user' ORDER BY tanggal_waktu DESC LIMIT $limit OFFSET $offset");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        #searchInput {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <?php if (isset($_SESSION['success']) && $_SESSION['success'] != '') { ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['success'] ?>
        </div>
    <?php
        $_SESSION['success'] = '';
    } ?>

    <h1>Riwayat Transaksi</h1>
    <a href="./" class="btn btn-default">Kembali</a>

    <input type="month" id="searchInput" class="form-control" placeholder="Cari berdasarkan bulan">

    <table class="table table-bordered" id="transaksiTable">
        <thead>
            <tr>
                <th>#Nomor</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Kasir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $view->fetch_array()) { ?>
                <tr>
                    <td><?= $row['nomor'] ?></td>
                    <td><?= $row['tanggal_waktu'] ?></td>
                    <td><?= $row['total'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td>
                        <a href="./unduh_struk.php?idtrx=<?= $row['id_transaksi'] ?>" class="btn btn-primary">Cetak</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <ul class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <li class="<?= $i == $page ? 'active' : '' ?>"><a href="?page=<?= $i ?>"><?= $i ?></a></li>
        <?php } ?>
    </ul>
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        var filter = this.value;
        var table = document.getElementById('transaksiTable');
        var tr = table.getElementsByTagName('tr');

        for (var i = 1; i < tr.length; i++) {
            var td = tr[i].getElementsByTagName('td')[1];
            if (td) {
                var txtValue = td.textContent || td.innerText;
                var date = new Date(txtValue);
                var monthYear = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2);
                tr[i].style.display = (monthYear === filter) ? '' : 'none';
            }
        }
    });
</script>
</body>
</html>
