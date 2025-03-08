<?php 

session_start();

if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role_id'] == 2 ) {
        header("location:./kasir/");
    }
} else {
    header("location:./login/");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Aplikasi Kasir</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="page-header">
        <h1>Dashboard Admin</h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Manajemen Data</h3>
                </div>
                <div class="panel-body">
                    <p>Pengelolaan barang, peran, dan pengguna aplikasi kasir.</p>
                    <a href="./barang/" class="btn btn-success btn-lg btn-block">Halaman Barang</a>
                    <a href="./diskon_barang/" class="btn btn-primary btn-lg btn-block">Halaman Diskon Barang</a>
                    <a href="./role/" class="btn btn-info btn-lg btn-block">Halaman Role</a>
                    <a href="./users/" class="btn btn-warning btn-lg btn-block">Halaman Users</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">Logout</h3>
                </div>
                <div class="panel-body">
                    <p>Untuk keluar dari aplikasi, klik tombol berikut:</p>
                    <a href="./logout/index.php" class="btn btn-danger btn-lg btn-block">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
