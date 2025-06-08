<?php

$hostname = "localhost:3307";
$username = "root";
$password = "";
$database_name = "login_template_php";

$db = mysqli_connect($hostname, $username, $password, $database_name);

if ($db->connect_error) {
    echo 'Koneksi database rusak';
    die("error!");
}
