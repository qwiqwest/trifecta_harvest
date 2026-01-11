<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "
  SELECT 
    DATE(waktu) AS label,
    SUM(hasil) AS total
  FROM hasil_scan
  WHERE waktu >= NOW() - INTERVAL 7 DAY
  GROUP BY DATE(waktu)
  ORDER BY DATE(waktu) ASC
  LIMIT 7
");

$labels = [];
$data   = [];

while ($row = mysqli_fetch_assoc($query)) {
    $labels[] = $row['label'];
    $data[]   = (int)$row['total'];
}

echo json_encode([
  'labels' => $labels,
  'data'   => $data
]);
