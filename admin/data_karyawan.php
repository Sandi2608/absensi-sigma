<?php include '../layouts/header.php'; ?>
<div class="card">
    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <h3>Daftar Karyawan</h3>
        <a href="tambah_karyawan.php" class="btn btn-primary" style="background:var(--secondary); color:white; text-decoration:none; padding:10px 20px; border-radius:10px;">+ Tambah Baru</a>
    </div>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; background: #f1f5f9;">
                <th style="padding: 15px;">NIP</th>
                <th style="padding: 15px;">Nama</th>
                <th style="padding: 15px;">Username</th>
                <th style="padding: 15px;">Akses</th>
                <th style="padding: 15px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM karyawan");
            while($d = mysqli_fetch_array($sql)){
                echo "<tr style='border-bottom: 1px solid #f1f5f9;'>
                    <td style='padding: 15px;'>$d[nip]</td>
                    <td style='padding: 15px; font-weight: 600;'>$d[nama]</td>
                    <td style='padding: 15px;'>$d[username]</td>
                    <td style='padding: 15px;'><span class='badge' style='background:#e2e8f0; padding:5px 10px; border-radius:10px; font-size:12px;'>$d[role]</span></td>
                    <td style='padding: 15px;'>
                        <a href='edit_karyawan.php?id=$d[id_karyawan]' style='color: var(--secondary); text-decoration:none; font-weight:700; margin-right:10px;'>Edit</a>
                        <a href='hapus_karyawan.php?id=$d[id_karyawan]' style='color: var(--danger); text-decoration:none; font-weight:700;' onclick='return confirm(\"Yakin ingin menghapus karyawan ini?\")'>Hapus</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php include '../layouts/footer.php'; ?>