<?php
session_start();
include '../config/koneksi.php';

$id_absensi = $_GET['id'];
$query = mysqli_query($conn, "SELECT absensi.*, karyawan.nama, karyawan.nip FROM absensi 
         JOIN karyawan ON absensi.id_karyawan = karyawan.id_karyawan 
         WHERE id_absensi = '$id_absensi'");
$d = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Detail Dokumentasi - <?= $d['nama'] ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; display: flex; justify-content: center; padding: 40px; }
        .detail-card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); max-width: 800px; width: 100%; }
        .header { text-align: center; border-bottom: 2px solid #f1f5f9; margin-bottom: 30px; padding-bottom: 20px; }
        .foto-container { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .foto-box { text-align: center; background: #f8fafc; padding: 15px; border-radius: 15px; border: 1px solid #e2e8f0; }
        .foto-box img { width: 100%; border-radius: 10px; border: 3px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .label { display: inline-block; margin-top: 15px; padding: 5px 15px; border-radius: 20px; font-weight: 800; font-size: 12px; }
        .info { margin-top: 10px; font-weight: 700; color: #1e293b; }
    </style>
</head>
<body>

<div class="detail-card">
    <div class="header">
        <h2 style="margin:0;"><?= $d['nama'] ?></h2>
        <p style="color:#64748b; margin:5px 0;">Absensi Tanggal: <?= date('d F Y', strtotime($d['tanggal'])) ?></p>
    </div>

    <div class="foto-container">
        <div class="foto-box">
            <img src="../assets/img/absensi/<?= $d['foto_masuk'] ?>" alt="Foto Masuk">
            <div class="label" style="background:#dcfce7; color:#166534;">FOTO MASUK</div>
            <div class="info"><i class="far fa-clock"></i> <?= $d['jam_masuk'] ?></div>
        </div>

        <div class="foto-box">
            <?php if($d['foto_keluar']): ?>
                <img src="../assets/img/absensi/<?= $d['foto_keluar'] ?>" alt="Foto Pulang">
                <div class="label" style="background:#fee2e2; color:#991b1b;">FOTO PULANG</div>
                <div class="info"><i class="far fa-clock"></i> <?= $d['jam_keluar'] ?></div>
            <?php else: ?>
                <div style="height:300px; display:flex; align-items:center; justify-content:center; color:#cbd5e1; flex-direction:column;">
                    <i class="fas fa-camera-slash fa-4x"></i>
                    <p>Belum Absen Pulang</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div style="margin-top:30px; text-align:center;">
        <button onclick="window.close()" style="padding:10px 25px; border-radius:8px; border:none; background:#0f172a; color:white; cursor:pointer; font-weight:600;">Tutup Halaman</button>
    </div>
</div>

</body>
</html>