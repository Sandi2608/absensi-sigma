<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['update'])) {
    $id    = $_POST['id_karyawan'];
    $nama  = mysqli_real_escape_string($conn, $_POST['nama']);
    $role  = $_POST['role'];
    
    if (!empty($_POST['password'])) {
        $pass = md5($_POST['password']);
        $sql  = "UPDATE karyawan SET nama='$nama', role='$role', password='$pass' WHERE id_karyawan='$id'";
    } else {
        $sql  = "UPDATE karyawan SET nama='$nama', role='$role' WHERE id_karyawan='$id'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data diperbarui!'); window.location='data_karyawan.php';</script>";
    }
}
?>