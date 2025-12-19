<?php
session_start();
include '../config/koneksi.php';
include '../layouts/header.php';

$id = $_GET['id'];
$edit = mysqli_query($conn, "SELECT * FROM karyawan WHERE id_karyawan='$id'");
$d = mysqli_fetch_array($edit);
?>

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
    .form-card { max-width: 600px; margin: 50px auto; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
    .form-header { background: #002b5c; color: white; padding: 25px; text-align: center; }
    .form-body { padding: 30px; }
    .form-control { width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; margin-top: 5px; margin-bottom: 20px; }
    .btn-update { width: 100%; padding: 15px; background: #3b82f6; color: white; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; }
</style>

<div class="form-card">
    <div class="form-header">
        <h3><i class="fas fa-user-edit"></i> Edit Data Karyawan</h3>
    </div>
    <div class="form-body">
        <form action="update_karyawan.php" method="POST">
            <input type="hidden" name="id_karyawan" value="<?= $d['id_karyawan'] ?>">
            
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="<?= $d['nama'] ?>" required>

            <label>Role</label>
            <select name="role" class="form-control">
                <option value="karyawan" <?= $d['role'] == 'karyawan' ? 'selected' : '' ?>>Karyawan</option>
                <option value="admin" <?= $d['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>

            <label>Password Baru (Biarkan kosong jika tidak ingin diganti)</label>
            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tetap">

            <button type="submit" name="update" class="btn-update">Perbarui Data</button>
            <a href="data_karyawan.php" style="display:block; text-align:center; margin-top:15px; color:#64748b; text-decoration:none;">Batal</a>
        </form>
    </div>
</div>