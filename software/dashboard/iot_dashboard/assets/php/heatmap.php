<?php
// Konfigurasi koneksi DomaiNesia
include 'koneksi.php';

// Ambil data terbaru (id terbesar)
$query = "SELECT a1, a2, b1, b2 FROM nama_tabel ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Kirim sebagai JSON agar bisa dibaca Javascript
header('Content-Type: application/json');
echo json_encode($data);

mysqli_close($conn);
?>