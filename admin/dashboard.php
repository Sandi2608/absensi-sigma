<?php include '../layouts/header.php'; ?>
<?php
$tgl_ini = date('Y-m-d');
$res_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM karyawan WHERE role='karyawan'");
$total_k = mysqli_fetch_assoc($res_total)['total'];
$res_hadir = mysqli_query($conn, "SELECT COUNT(*) as total FROM absensi WHERE tanggal='$tgl_ini'");
$hadir_ini = mysqli_fetch_assoc($res_hadir)['total'];

$labels = []; $data_grafik = [];
for($i=6; $i>=0; $i--) {
    $t = date('Y-m-d', strtotime("-$i days"));
    $labels[] = date('D', strtotime($t));
    $q = mysqli_query($conn, "SELECT COUNT(*) as total FROM absensi WHERE tanggal='$t'");
    $data_grafik[] = mysqli_fetch_assoc($q)['total'];
}
?>
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
    <div class="card" style="border-left: 6px solid var(--secondary);">
        <small style="color: #64748b; font-weight: 700;">TOTAL KARYAWAN</small>
        <h1 style="font-size: 40px; margin: 10px 0;"><?= $total_k ?></h1>
    </div>
    <div class="card" style="border-left: 6px solid #2ecc71;">
        <small style="color: #64748b; font-weight: 700;">HADIR HARI INI</small>
        <h1 style="font-size: 40px; margin: 10px 0;"><?= $hadir_ini ?></h1>
    </div>
</div>
<div class="card">
    <h3 style="margin-top:0">Tren Kehadiran 7 Hari Terakhir</h3>
    <canvas id="chartAbsen" height="100"></canvas>
</div>
<script>
new Chart(document.getElementById('chartAbsen'), {
    type: 'line',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{ label: 'Kehadiran', data: <?= json_encode($data_grafik) ?>, borderColor: '#3498db', tension: 0.4, fill: true, backgroundColor: 'rgba(52, 152, 219, 0.1)' }]
    }
});
</script>
<?php include '../layouts/footer.php'; ?>