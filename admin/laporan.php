<?php
session_start();
include '../config/koneksi.php';

// Proteksi halaman admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// Logika Filter Tanggal
$tgl_mulai = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : date('Y-m-01');
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : date('Y-m-d');

// Query Statistik untuk Ringkasan
$stats_query = mysqli_query($conn, "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN tipe_kerja = 'WFO' THEN 1 ELSE 0 END) as wfo,
    SUM(CASE WHEN tipe_kerja = 'WFH' THEN 1 ELSE 0 END) as wfh
    FROM absensi WHERE tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai'");
$stats = mysqli_fetch_assoc($stats_query);

include '../layouts/header.php';
?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>

<style>
    body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; color: #1e293b; }
    .container-laporan { padding: 25px; max-width: 1400px; margin: auto; }

    /* Statistik Cards */
    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px; }
    .stat-card { background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #002b5c; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .stat-card h4 { margin: 0; font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }
    .stat-card .value { font-size: 24px; font-weight: 800; color: #0f172a; margin-top: 5px; }

    /* Main Table Card */
    .main-card { background: white; border-radius: 16px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); overflow: hidden; border: 1px solid #e2e8f0; }
    .card-header { padding: 20px 30px; background: white; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
    
    .btn-group { display: flex; gap: 10px; }
    .btn-action { padding: 10px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; display: flex; align-items: center; gap: 8px; transition: 0.2s; text-decoration: none; }
    .btn-excel { background: #10b981; color: white; }
    .btn-print { background: #64748b; color: white; }
    .btn-view { background: #eff6ff; color: #3b82f6; border: 1px solid #dbeafe; font-size: 12px; }
    .btn-view:hover { background: #3b82f6; color: white; }
    
    .filter-box { padding: 20px 30px; background: #f8fafc; border-bottom: 1px solid #f1f5f9; }
    .form-filter { display: flex; gap: 15px; align-items: flex-end; }
    
    .modern-table { width: 100%; border-collapse: collapse; }
    .modern-table th { background: #f8fafc; padding: 15px; font-size: 11px; font-weight: 700; color: #475569; text-transform: uppercase; text-align: center; }
    .modern-table td { padding: 15px; font-size: 14px; border-bottom: 1px solid #f1f5f9; text-align: center; vertical-align: middle; }

    .gps-link { color: #3b82f6; text-decoration: none; font-weight: 600; font-size: 12px; }
    .gps-link:hover { text-decoration: underline; }

    @media print {
        .no-print, .btn-action, .filter-box, .sidebar { display: none !important; }
        .main-card { box-shadow: none; border: none; }
        .container-laporan { padding: 0; }
    }
</style>

<div class="container-laporan">
    <div class="stats-grid no-print">
        <div class="stat-card"><h4>Total Kehadiran</h4><div class="value"><?= $stats['total'] ?></div></div>
        <div class="stat-card" style="border-left-color: #10b981;"><h4>Hadir WFO</h4><div class="value"><?= $stats['wfo'] ?></div></div>
        <div class="stat-card" style="border-left-color: #3b82f6;"><h4>Hadir WFH</h4><div class="value"><?= $stats['wfh'] ?></div></div>
    </div>

    <div class="main-card">
        <div class="card-header">
            <h2 style="margin:0; font-size:18px; font-weight:800;">REKAPITULASI ABSENSI</h2>
            <div class="btn-group no-print">
                <button id="exportExcel" class="btn-action btn-excel"><i class="fas fa-file-excel"></i> Export Excel</button>
                <button onclick="window.print()" class="btn-action btn-print"><i class="fas fa-print"></i> PDF / Cetak</button>
            </div>
        </div>

        <div class="filter-box no-print">
            <form method="GET" class="form-filter">
                <div style="display:flex; flex-direction:column; gap:5px;">
                    <label style="font-size:10px; font-weight:800; color:#64748b;">DARI TANGGAL</label>
                    <input type="date" name="tgl_mulai" value="<?= $tgl_mulai ?>" style="padding:8px; border-radius:6px; border:1px solid #cbd5e1;">
                </div>
                <div style="display:flex; flex-direction:column; gap:5px;">
                    <label style="font-size:10px; font-weight:800; color:#64748b;">SAMPAI TANGGAL</label>
                    <input type="date" name="tgl_selesai" value="<?= $tgl_selesai ?>" style="padding:8px; border-radius:6px; border:1px solid #cbd5e1;">
                </div>
                <button type="submit" class="btn-action" style="background:#002b5c; color:white; height:38px;">Filter Data</button>
            </form>
        </div>

        <div style="overflow-x: auto;">
            <table class="modern-table" id="tabelAbsensi">
                <thead>
                    <tr>
                        <th data-exclude="true">No</th>
                        <th style="text-align:left;">Karyawan</th>
                        <th>Tanggal</th>
                        <th>Masuk</th>
                        <th>Pulang</th>
                        <th>Tipe</th>
                        <th class="no-print" data-exclude="true">Dokumentasi</th>
                        <th class="no-print" data-exclude="true">Peta Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sql = mysqli_query($conn, "SELECT absensi.*, karyawan.nama, karyawan.nip FROM absensi 
                           JOIN karyawan ON absensi.id_karyawan = karyawan.id_karyawan 
                           WHERE tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai' ORDER BY tanggal DESC");
                    
                    while($row = mysqli_fetch_array($sql)){
                    ?>
                    <tr>
                        <td data-exclude="true" style="color:#94a3b8;"><?= $no++ ?></td>
                        <td style="text-align:left;">
                            <div style="font-weight:700;"><?= $row['nama'] ?></div>
                            <small style="color:#64748b; font-size:11px;"><?= $row['nip'] ?></small>
                        </td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                        <td style="color:#16a34a; font-weight:700;"><?= $row['jam_masuk'] ?></td>
                        <td style="color:#dc2626; font-weight:700;"><?= $row['jam_keluar'] ?: '--:--' ?></td>
                        <td>
                            <span style="font-size:11px; font-weight:700; color:#475569; background:#f1f5f9; padding:4px 10px; border-radius:6px;">
                                <?= $row['tipe_kerja'] ?>
                            </span>
                        </td>
                        
                        <td class="no-print" data-exclude="true">
                            <a href="detail_foto.php?id=<?= $row['id_absensi'] ?>" target="_blank" class="btn-action btn-view">
                                <i class="fas fa-images"></i> Lihat Foto
                            </a>
                        </td>

                        <td class="no-print" data-exclude="true">
                            <div style="display:flex; flex-direction:column; gap:5px;">
                                <a href="https://www.google.com/maps?q=<?= $row['lokasi_masuk'] ?>" target="_blank" class="gps-link">
                                    <i class="fas fa-map-marker-alt"></i> Lokasi In
                                </a>
                                <?php if($row['lokasi_keluar']): ?>
                                <a href="https://www.google.com/maps?q=<?= $row['lokasi_keluar'] ?>" target="_blank" class="gps-link" style="color:#dc2626;">
                                    <i class="fas fa-map-marker-alt"></i> Lokasi Out
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('exportExcel').addEventListener('click', function() {
        TableToExcel.convert(document.getElementById("tabelAbsensi"), {
            name: "Laporan_Absensi_SCU_Lengkap.xlsx",
            sheet: { name: "Rekap Absensi" }
        });
    });
</script>

<?php include '../layouts/footer.php'; ?>