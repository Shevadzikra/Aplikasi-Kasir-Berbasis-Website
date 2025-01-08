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

$id = $_GET['id'];
$cart = $_SESSION['cart'];

$k = array_filter($cart, function($var) use ($id) {
    return ($var['id'] == $id);
});

foreach ($k as $key => $value) {
    unset($_SESSION['cart'][$key]);
}

$_SESSION['cart'] = array_values($_SESSION['cart']);

header("location:./");

?>