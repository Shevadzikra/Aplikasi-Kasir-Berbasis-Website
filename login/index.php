<?php 

include '../config.php';
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' and password='$password'");

    $data = mysqli_fetch_assoc($query);

    $check = mysqli_num_rows($query);

    if (!$check) {
        $_SESSION['error'] = 'Password atau Username Salah!' ;
    } else {
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role_id'] = $data['role_id'];

        header("location:../");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<div class="container">
<?php if (isset($_SESSION['error']) && $_SESSION['error'] != '') { ?>
    <div>
        <h3>Password atau Username Salah!</h3>
    </div>
<?php 
    }
    $_SESSION['error'] = '';
?>
    <h1>Login</h1>
<form action="" method="post">
    <div class="form-group">
        <label for="">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Username">
    </div>
    <div class="form-group">
        <label for="">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password">
    </div>
    <input type="submit" name="login" value="Login">
    <a href="./index.php">Kembali</a>
</form>
</div>
</body>
</html>