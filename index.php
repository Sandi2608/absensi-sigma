<?php
session_start();
include 'config/koneksi.php';


if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: karyawan/dashboard.php");
    }
    exit;
}


if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Mencocokkan username dan password langsung ke database
    $query = mysqli_query($conn, "SELECT * FROM karyawan WHERE username='$username' AND password='$password'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        
        // Simpan data ke session
        $_SESSION['user'] = $data;
        $_SESSION['role'] = $data['role'];

        if ($data['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: karyawan/dashboard.php");
        }
        exit;
    } else {
        // Jika tidak ditemukan, tampilkan pesan error
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PT Sigma Cipta Utama</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #002b5c;
            --secondary: #3498db;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #002b5c 0%, #004a99 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: white;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .logo-area img {
            width: 120px;
            margin-bottom: 20px;
        }

        .login-header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: var(--primary);
            text-transform: uppercase;
        }

        .login-header p {
            margin: 5px 0 30px 0;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
        }

        .form-group {
            text-align: left;
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #475569;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            box-sizing: border-box;
            transition: 0.3s;
        }

        input:focus {
            outline: none;
            border-color: var(--secondary);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #001f42;
            transform: translateY(-2px);
        }

        .error-msg {
            background: #fef2f2;
            color: #dc2626;
            padding: 10px;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 20px;
            border: 1px solid #fee2e2;
        }

        .footer-text {
            margin-top: 25px;
            font-size: 11px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="logo-area">
            <img src="assets/img/logo.png" alt="Logo PT SCU">
        </div>

        <div class="login-header">
            <h2>SISTEM ABSENSI DIGITAL</h2>
            <p>PT SIGMA CIPTA UTAMA</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="error-msg"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan Username" required autocomplete="off">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" name="login" class="btn-login">MASUK KE SISTEM</button>
        </form>

        <div class="footer-text">
            &copy; <?= date('Y') ?> PT Sigma Cipta Utama. All rights reserved.
        </div>
    </div>

</body>
</html>