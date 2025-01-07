<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "kasir";

$koneksi = new mysqli ("$host", "$user", "$pass", "$db");

if ($koneksi -> connect_error) {
    echo 'KONEKSI GAGAL WOY!!' . $koneksi->connect_error;
}

?>