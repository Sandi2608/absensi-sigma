<?php
session_start();
include '../config/koneksi.php';

$id = $_SESSION['user']['id_karyawan'];
$tgl = date('Y-m-d');
$jam = date('H:i:s');
$lokasi = $_POST['lat_long'];
$img = $_POST['image_data'];

// Proses simpan file gambar
$img = str_replace('data:image/jpeg;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data_img = base64_decode($img);
$filename = "img_" . $id . "_" . time() . ".jpg";
$folderPath = "../assets/img/absensi/";

// Pastikan folder ada
if (!file_exists($folderPath)) { mkdir($folderPath, 0777, true); }
file_put_contents($folderPath . $filename, $data_img);

if(isset($_POST['absen_masuk'])) {
    $tipe = $_POST['tipe_kerja'];
    $query = mysqli_query($conn, "INSERT INTO absensi (id_karyawan, tanggal, tipe_kerja, jam_masuk, lokasi_masuk, foto_masuk, status) 
                                 VALUES ('$id', '$tgl', '$tipe', '$jam', '$lokasi', '$filename', 'Hadir')");
    if($query) header("Location: dashboard.php?status=sukses_masuk");
} 

elseif(isset($_POST['absen_pulang'])) {
    $query = mysqli_query($conn, "UPDATE absensi SET jam_keluar='$jam', lokasi_keluar='$lokasi', foto_keluar='$filename' 
                                 WHERE id_karyawan='$id' AND tanggal='$tgl'");
    if($query) header("Location: dashboard.php?status=sukses_pulang");
}
?>