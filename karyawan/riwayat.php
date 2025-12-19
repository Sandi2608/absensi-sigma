<?php include '../layouts/header.php'; ?>
<div class="card">
    <h3 style="margin-top:0">Riwayat Presensi Anda</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; background: #f1f5f9;">
                <th style="padding: 15px;">Tanggal</th>
                <th style="padding: 15px;">Lokasi</th>
                <th style="padding: 15px;">Masuk</th>
                <th style="padding: 15px;">Pulang</th>
                <th style="padding: 15px;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $id = $_SESSION['user']['id_karyawan'];
            $res = mysqli_query($conn, "SELECT * FROM absensi WHERE id_karyawan='$id' ORDER BY tanggal DESC");
            while($r = mysqli_fetch_array($res)) {
                echo "<tr style='border-bottom: 1px solid #eee;'>
                    <td style='padding: 15px;'>".date('d/m/Y', strtotime($r['tanggal']))."</td>
                    <td style='padding: 15px;'>$r[tipe_kerja]</td>
                    <td style='padding: 15px; font-weight:700; color:#2ecc71'>$r[jam_masuk]</td>
                    <td style='padding: 15px; font-weight:700; color:#e74c3c'>".($r['jam_keluar']??'--:--')."</td>
                    <td style='padding: 15px;'><span style='background:#dcfce7; padding:5px 10px; border-radius:15px; font-size:12px;'>$r[status]</span></td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php include '../layouts/footer.php'; ?>