<?php

include '../config.php';
session_start();

if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role_id'] == 1 ) {
        header("location:../login");
    }
} else {
    header("location:../kasir/");
}

$qty = $_POST['qty'];
$cart = $_SESSION['cart'];

foreach ($cart as $key => $value) {
    $_SESSION['cart'][$key]['qty'] = $qty[$key];
}

header('location:./');