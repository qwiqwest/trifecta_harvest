<?php
header('Content-Type: application/json');
include 'koneksi.php';

// ambil data terbaru
$q = mysqli_query($koneksi, "
  SELECT * FROM hasil
  ORDER BY waktu DESC
  LIMIT 1
");

$row = mysqli_fetch_assoc($q);

$points = [];
$maxValue = 0;

// BARIS A (y = 1)
for ($i = 1; $i <= 10; $i++) {
    $val = (int)$row["a$i"];
    $points[] = [
        "x" => $i,
        "y" => 1,
        "value" => $val
    ];
    if ($val > $maxValue) $maxValue = $val;
}

// BARIS B (y = 2)
for ($i = 1; $i <= 10; $i++) {
    $val = (int)$row["b$i"];
    $points[] = [
        "x" => $i,
        "y" => 2,
        "value" => $val
    ];
    if ($val > $maxValue) $maxValue = $val;
}

echo json_encode([
    "max" => $maxValue,
    "data" => $points
]);
