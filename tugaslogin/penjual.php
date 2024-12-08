<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weblogin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data penjual
$sql = "SELECT id_penjual, nama_penjual, umur, no_telepon FROM Penjual";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff; /* Light blue */
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .container {
            text-align: center;
        }
        .foto-penjual {
            width: 175px; /* Perbesar foto profil menjadi 200px */
            height: 175px; /* Perbesar tinggi foto profil menjadi 200px */
            border-radius: 50%; /* Membuat foto berbentuk lingkaran */
            object-fit: cover; /* Menjaga proporsi gambar */
            margin-bottom: 20px; /* Memberikan jarak ke bawah */
        }
        .table-container {
            background: #ffffff; /* White */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            background-color: #f9f9f9;
        }
        thead {
            background-color: #007bff; /* Blue background */
        }
        thead th {
            color: white;
            text-align: center;
            padding: 12px;
        }
        tbody td {
            text-align: center;
            padding: 12px;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray for even rows */
        }
        tbody tr:hover {
            background-color: #d1ecf1; /* Light cyan for hover */
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4 text-primary">Data Penjual</h2>

    <!-- Menampilkan foto profil yang diperbesar -->
    <div>
        <img src="image/pp.jpg" alt="Foto Profil" class="foto-penjual">
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Umur</th>
                <th>No Telepon</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama_penjual']); ?></td>
                        <td><?= htmlspecialchars($row['umur']); ?></td>
                        <td><?= htmlspecialchars($row['no_telepon']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Belum ada data penjual.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="btn">Kembali ke Dashboard</a>
    </div>
</div>
</body>
</html>
