<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit; }
include '../layouts/header.php';
?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
    .form-card { max-width: 500px; margin: 60px auto; background: white; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); overflow: hidden; border: 1px solid #e2e8f0; }
    .form-header { background: linear-gradient(135deg, #002b5c 0%, #004a8d 100%); padding: 30px; color: white; text-align: center; }
    .form-body { padding: 30px; }
    .input-group { margin-bottom: 20px; }
    .input-group label { display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px; }
    .input-wrapper { position: relative; }
    .input-wrapper i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    .form-control { width: 100%; padding: 12px 15px 12px 45px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; box-sizing: border-box; }
    .form-control:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
    .btn-submit { width: 100%; padding: 15px; background: #3b82f6; color: white; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s; }
    .btn-submit:hover { background: #2563eb; transform: translateY(-2px); }
</style>

<div class="form-card">
    <div class="form-header">
        <i class="fas fa-user-plus fa-3x"></i>
        <h2 style="margin: 10px 0 0;">Tambah Karyawan</h2>
    </div>
    <div class="form-body">
        <form action="simpan_karyawan.php" method="POST">
            <div class="input-group">
                <label>NIP</label>
                <div class="input-wrapper">
                    <i class="fas fa-id-badge"></i>
                    <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Pegawai" required>
                </div>
            </div>
            <div class="input-group">
                <label>Nama Lengkap</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" name="nama" class="form-control" placeholder="Nama Karyawan" required>
                </div>
            </div>
            <div class="input-group">
                <label>Username</label>
                <div class="input-wrapper">
                    <i class="fas fa-at"></i>
                    <input type="text" name="username" class="form-control" placeholder="Username untuk login" required>
                </div>
            </div>
            <div class="input-group">
                <label>Role Akses</label>
                <div class="input-wrapper">
                    <i class="fas fa-shield-alt"></i>
                    <select name="role" class="form-control">
                        <option value="karyawan">Karyawan</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
            </div>
            <div class="input-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
            </div>
            <button type="submit" name="submit" class="btn-submit">Simpan & Daftarkan</button>
            <a href="data_karyawan.php" style="display:block; text-align:center; margin-top:15px; color:#64748b; text-decoration:none; font-size:13px;">Kembali</a>
        </form>
    </div>
</div>