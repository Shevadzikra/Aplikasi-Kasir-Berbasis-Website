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
</head>
<body>
    <a href="./logout/">Logout</a>
</body>
</html>