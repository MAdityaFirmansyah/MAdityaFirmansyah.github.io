<?php
session_start();

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weblogin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Variabel untuk pesan
$error_message = "";
$success_message = "";
// Proses Login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['password'] == $password) {
            $_SESSION['username'] = $row['username'];
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Password salah!";
        }
    } else {
        $error_message = "Username tidak ditemukan!";
    }
}
// Proses Logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: index.php");
    exit();
}
// Proses Pendaftaran Pengguna
if (isset($_POST['register'])) {
    $nim = $_POST['nim'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($nim) || empty($username) || empty($password)) {
        $error_message = "Semua kolom harus diisi!";
    } else {
        $sql = "INSERT INTO login (nim, username, password) VALUES ('$nim', '$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            $success_message = "Pendaftaran berhasil! Silakan login.";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}
// Proses Tambah Data Penjual
if (isset($_POST['add_penjual'])) {
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $tlpn = $_POST['tlpn'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $desa = $_POST['desa'];
    $kec = $_POST['kec'];
    $kab = $_POST['kab'];

    $sql = "INSERT INTO Penjual (nama, umur, tlpn, email, alamat, desa, kec, kab)
            VALUES ('$nama', '$umur', '$tlpn', '$email', '$alamat', '$desa', '$kec', '$kab')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Data penjual berhasil ditambahkan!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            /* Ganti dengan gambar latar belakang */
            background-image: url('image/bg.jpg'); /* Ganti dengan path gambar yang Anda inginkan */
            background-size: cover;  /* Menyesuaikan gambar dengan ukuran layar */
            background-position: center center; /* Menempatkan gambar di tengah layar */
            background-attachment: fixed; /* Menjaga posisi gambar saat scroll */
            margin: 0;
            padding: 0;
        }

        /* Container untuk form login dan register */
        .container {
            margin-top: 210px;  /* Menambahkan margin-top agar form lebih ke bawah */
            max-width: 400px;
            background: rgba(255, 255, 255, 0.8); /* Membuat kontainer lebih jelas dan terlihat di atas gambar latar belakang */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .dashboard-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .dashboard-buttons a {
            padding: 10px;
            text-align: center;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn-blue { background-color: #007bff; }
        .btn-yellow { background-color: #fbbd08; }
        .btn-green { background-color: #4caf50; }
        .btn-red { background-color: #dc3545; }

        /* Mengatur agar tombol lebih responsif saat di hover */
        .btn:hover {
            opacity: 0.8;
        }
        /* Menata tombol logout */
        .logout-button {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            display: inline-block;
        }
        .logout-button:hover {
            background-color: #c82333;
        }
        /* Penataan form login dan register */
        .form-container {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background: white;
            border-radius: 8px;
        }

    </style>
</head>
<body>
<div class="container">
    <?php if (!isset($_SESSION['username'])): ?>
        <?php 
        $show_register = isset($_GET['action']) && $_GET['action'] === 'register';
        ?>
        <?php if ($show_register): ?>
            <!-- Form Register -->
            <div class="form-container">
                <h2 class="text-center">Daftar Akun</h2>
                <?php if ($error_message) echo "<p class='text-danger'>$error_message</p>"; ?>
                <?php if ($success_message) echo "<p class='text-success'>$success_message</p>"; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" name="nim" id="nim" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="register" class="btn btn-primary">Daftar</button>
                    </div>
                </form>
                <p class="text-center">Sudah punya akun? <a href="index.php">Login di sini</a></p>
            </div>
        <?php else: ?>
            <!-- Form Login -->
            <div class="form-container">
                <h2 class="text-center">Login</h2>
                <?php if ($error_message) echo "<p class='text-danger'>$error_message</p>"; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="login" class="btn btn-primary">Login</button>
                    </div>
                </form>
                <p class="text-center">Belum punya akun? <a href="index.php?action=register">Daftar di sini</a></p>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <!-- Dashboard -->
        <h2 class="text-center">Selamat Datang, <?= $_SESSION['username']; ?>!</h2>
        <p class="text-center">Di Platform Sistem Kasir</p>
        <div class="dashboard-buttons">
            <a href="penjual.php" class="btn btn-blue">Penjual</a>
            <a href="menu.php" class="btn btn-yellow">Makanan</a>
            <a href="#" class="btn btn-green">Pembeli</a>
            <a href="pembayaran.php" class="btn btn-red">Pembayaran</a>
        </div>
        <a href="?action=logout" class="logout-button mt-3">Logout</a>
    <?php endif; ?>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
