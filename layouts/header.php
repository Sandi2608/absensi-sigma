<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['user'])) { header("Location: ../index.php"); exit; }
include '../config/koneksi.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Absensi Digital - PT SCU</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --primary: #002b5c; --secondary: #3498db; --bg: #f8fafc; --text: #1e293b; }
        body { margin: 0; font-family: 'Inter', sans-serif; display: flex; background: var(--bg); color: var(--text); }
        .sidebar { width: 280px; background: linear-gradient(180deg, #002b5c 0%, #001f42 100%); color: white; height: 100vh; position: fixed; box-shadow: 4px 0 10px rgba(0,0,0,0.1); }
        .sidebar-header { padding: 40px 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-header img { width: 110px; margin-bottom: 15px; transition: 0.3s; }
        .sidebar-header img:hover { transform: scale(1.05); }
        .sidebar-menu a { display: block; color: #cbd5e1; padding: 15px 25px; text-decoration: none; font-weight: 600; font-size: 14px; border-left: 4px solid transparent; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(255,255,255,0.05); color: white; border-left-color: var(--secondary); }
        .main-content { margin-left: 280px; width: 100%; min-height: 100vh; }
        .top-nav { background: white; padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; }
        .container { padding: 30px; }
        .card { background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; margin-bottom: 20px; }
        .btn { padding: 12px 24px; border-radius: 10px; border: none; font-weight: 700; cursor: pointer; transition: 0.2s; text-decoration: none; display: inline-block; }
        .btn-success { background: #2ecc71; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        select, input { padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; width: 100%; font-family: 'Inter'; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="../assets/img/logo.png" alt="Logo">
            <div style="font-size: 15px; font-weight: 700; letter-spacing: 0.5px;">SISTEM ABSENSI DIGITAL</div>
            <div style="font-size: 11px; color: #94a3b8; margin-top: 4px;">PT SIGMA CIPTA UTAMA</div>
        </div>
        <div class="sidebar-menu">
            <?php if ($_SESSION['role'] == 'admin') : ?>
                <a href="dashboard.php" class="<?= $current_page == 'dashboard.php' ? 'active' : '' ?>">Dashboard Admin</a>
                <a href="data_karyawan.php" class="<?= $current_page == 'data_karyawan.php' ? 'active' : '' ?>">Kelola Karyawan</a>
                <a href="laporan.php" class="<?= $current_page == 'laporan.php' ? 'active' : '' ?>">Laporan Absensi</a>
            <?php else : ?>
                <a href="dashboard.php" class="<?= $current_page == 'dashboard.php' ? 'active' : '' ?>">Presensi Online</a>
                <a href="riwayat.php" class="<?= $current_page == 'riwayat.php' ? 'active' : '' ?>">Riwayat Absensi</a>
            <?php endif; ?>
            <a href="../logout.php" style="color: #fca5a5; margin-top: 30px;">Keluar Sistem</a>
        </div>
    </div>
    <div class="main-content">
        <div class="top-nav">
            <div style="font-weight: 600; color: #64748b; font-size: 14px;">Halaman <?= ucfirst(str_replace('.php','',$current_page)) ?></div>
            <div style="font-weight: 700;"><?= $_SESSION['user']['nama'] ?> <span style="font-weight: 400; color: #94a3b8;">(<?= ucfirst($_SESSION['role']) ?>)</span></div>
        </div>
        <div class="container">