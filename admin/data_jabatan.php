<?php include '../layouts/header.php'; ?>

<div class="card" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="margin:0;">Data Jabatan</h3>
        <button style="background:#28a745; color:white; border:none; padding:8px 15px; border-radius:5px; cursor:pointer;">+ Tambah Jabatan</button>
    </div>

    <table border="1" style="width:100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: #f8f9fa;">
                <th style="padding:12px; border-bottom: 2px solid #dee2e6;">No</th>
                <th style="padding:12px; border-bottom: 2px solid #dee2e6;">Nama Jabatan</th>
                <th style="padding:12px; border-bottom: 2px solid #dee2e6; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = mysqli_query($conn, "SELECT DISTINCT jabatan FROM karyawan WHERE jabatan != ''");
            $no = 1;
            if(mysqli_num_rows($sql) > 0){
                while($d = mysqli_fetch_array($sql)){
                    echo "<tr>
                        <td style='padding:12px; border-bottom: 1px solid #eee;'>$no</td>
                        <td style='padding:12px; border-bottom: 1px solid #eee;'>$d[jabatan]</td>
                        <td style='padding:12px; border-bottom: 1px solid #eee; text-align: center;'>
                            <button style='background:#ffc107; border:none; padding:5px 10px; border-radius:3px; cursor:pointer;'>Edit</button>
                            <button style='background:#dc3545; border:none; padding:5px 10px; color:white; border-radius:3px; cursor:pointer;'>Hapus</button>
                        </td>
                    </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='3' style='text-align:center; padding:20px;'>Belum ada data jabatan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../layouts/footer.php'; ?>