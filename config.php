<?php
$host = "localhost";
$user = "root"; // ganti sesuai setting XAMPP/MAMP
$pass = "";
$db   = "mini_project";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
