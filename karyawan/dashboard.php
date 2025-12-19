<?php include '../layouts/header.php'; ?>
<?php
$id = $_SESSION['user']['id_karyawan'];
$tgl = date('Y-m-d');
$cek = mysqli_query($conn, "SELECT * FROM absensi WHERE id_karyawan='$id' AND tanggal='$tgl'");
$data = mysqli_fetch_array($cek);
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="card" style="text-align: center; max-width: 600px; margin: auto; padding: 20px;">
    <h2 style="margin:0; color: var(--primary);">PRESENSI DIGITAL</h2>
    <div id="clock" style="font-size: 40px; font-weight: 800; color: #333; margin: 10px 0;">00:00:00</div>
    
    <div id="location-status" style="font-size: 13px; margin-bottom: 10px; font-weight: bold;">
        <i class="fas fa-sync fa-spin"></i> Mencari Lokasi GPS...
    </div>

    <div style="position: relative; width: 100%; max-width: 400px; margin: auto; background: #000; border-radius: 15px; overflow: hidden; border: 4px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
        <video id="webcam" width="100%" autoplay playsinline></video>
        <canvas id="canvas" style="display:none;"></canvas>
    </div>

    <form action="proses_absen.php" method="POST" id="formAbsen" style="margin-top: 20px;">
        <input type="hidden" name="lat_long" id="lat_long">
        <input type="hidden" name="image_data" id="image_data">
        
        <div style="margin-bottom: 15px; text-align: left;">
            <label style="font-size: 13px; font-weight: 700;">Tipe Kehadiran:</label>
            <select name="tipe_kerja" style="width:100%; padding:10px; border-radius:8px;" <?= ($data && $data['jam_keluar']) ? 'disabled' : '' ?>>
                <option value="WFO" <?= ($data && $data['tipe_kerja']=='WFO')?'selected':'' ?>>WFO - Kantor</option>
                <option value="WFH" <?= ($data && $data['tipe_kerja']=='WFH')?'selected':'' ?>>WFH - Rumah</option>
                <option value="Dinas Luar" <?= ($data && $data['tipe_kerja']=='Dinas Luar')?'selected':'' ?>>Dinas Luar</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <button type="submit" name="absen_masuk" class="btn btn-success" style="flex:1; padding:15px;" <?= ($data)?'disabled style="opacity:0.5"':'' ?>>MASUK</button>
            <button type="submit" name="absen_pulang" class="btn btn-danger" style="flex:1; padding:15px;" <?= (!$data || $data['jam_keluar'])?'disabled style="opacity:0.5"':'' ?>>PULANG</button>
        </div>
    </form>
</div>

<script>
    const video = document.getElementById('webcam');
    const canvas = document.getElementById('canvas');
    const imageData = document.getElementById('image_data');

    // Akses Kamera
    navigator.mediaDevices.getUserMedia({ video: true }).then(s => video.srcObject = s);

    // Ambil GPS
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(p => {
            document.getElementById('lat_long').value = p.coords.latitude + "," + p.coords.longitude;
            document.getElementById('location-status').innerHTML = "<span style='color:green'>✔ GPS Terkunci</span>";
        });
    }

    // Capture Foto saat Submit
    document.getElementById('formAbsen').onsubmit = function() {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        imageData.value = canvas.toDataURL('image/jpeg');
    };

    // Jam Real-time
    setInterval(() => { document.getElementById('clock').innerText = new Date().toLocaleTimeString('id-ID', {hour12:false}); }, 1000);

    // SweetAlert Notif
    const status = new URLSearchParams(window.location.search).get('status');
    if(status === 'sukses_masuk') Swal.fire('Berhasil!', 'Absen masuk tersimpan.', 'success');
    if(status === 'sukses_pulang') Swal.fire('Berhasil!', 'Absen pulang tersimpan.', 'success');
</script>
<?php include '../layouts/footer.php'; ?>