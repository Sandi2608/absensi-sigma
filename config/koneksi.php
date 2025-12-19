<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_absensi";

$conn = mysqli_connect($host, $user, $pass, $db);

date_default_timezone_set('Asia/Jakarta');
mysqli_query($conn, "SET time_zone = '+07:00'");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>