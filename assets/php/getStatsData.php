<?php
include 'koneksi.php';

/* TOTAL SCANNING (id terakhir) */
$totalQuery = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM hasil");
$total = mysqli_fetch_assoc($totalQuery)['total'] ?? 0;

/* CEK SCANNING HARI INI */
$todayQuery = mysqli_query($koneksi, "
  SELECT COUNT(*) AS total_today
  FROM hasil
  WHERE DATE(waktu) = CURDATE()
");
$today = mysqli_fetch_assoc($todayQuery)['total_today'];

/* DATA TERAKHIR */
$lastQuery = mysqli_query($koneksi, "
  SELECT 
  a1,a2,
  b1,b2,

  (a1 + a2) / 2 AS avgA,
  (b1 + b2) / 2 AS avgB,

  DATE_FORMAT(waktu, '%d %b %H:%i') AS waktu_label
  FROM hasil
  ORDER BY waktu_label DESC
  LIMIT 1
");
$last = mysqli_fetch_assoc($lastQuery);

/* DATA SEBELUM TERAKHIR */
$prevQuery = mysqli_query($koneksi, "
  SELECT 
    DATE_FORMAT(waktu, '%d %b %H:%i') AS waktu_label
  FROM hasil
  ORDER BY `waktu` DESC
  LIMIT 1
");
$prev = mysqli_fetch_assoc($prevQuery);

echo json_encode([
  'total' => (int)$total,
  'status_today' => $today > 0,
  'last' => $last,
  'previous' => $prev
]);
