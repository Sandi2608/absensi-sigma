<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['submit'])) {
    $nip      = mysqli_real_escape_string($conn, $_POST['nip']);
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role     = $_POST['role'];
    $password = md5($_POST['password']);

    
    $query = "INSERT INTO karyawan (nip, nama, username, password, role) 
              VALUES ('$nip', '$nama', '$username', '$password', '$role')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Berhasil disimpan!'); window.location='data_karyawan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>