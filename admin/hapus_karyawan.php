<?php
session_start();
include '../config/koneksi.php';

$id = $_GET['id'];
if (mysqli_query($conn, "DELETE FROM karyawan WHERE id_karyawan='$id'")) {
    echo "<script>alert('Data dihapus!'); window.location='data_karyawan.php';</script>";
}
?>