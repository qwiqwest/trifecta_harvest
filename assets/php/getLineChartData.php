<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "
  SELECT 
    DATE_FORMAT(waktu, '%d %b %H:%i') AS waktu_label,
    persentase
  FROM hasil_scan
  WHERE waktu >= NOW() - INTERVAL 7 DAY
  ORDER BY waktu ASC
");

$labels = [];
$data   = [];

while ($row = mysqli_fetch_assoc($query)) {
    $labels[] = $row['waktu_label']; // ← sudah diformat
    $data[]   = (int)$row['persentase'];
}

echo json_encode([
  'labels' => $labels,
  'data'   => $data
]);
