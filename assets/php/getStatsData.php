<?php
include 'koneksi.php';

/* TOTAL SCANNING (id terakhir) */
$totalQuery = mysqli_query($koneksi, "SELECT MAX(id) AS total FROM hasil_scan");
$total = mysqli_fetch_assoc($totalQuery)['total'] ?? 0;

/* CEK SCANNING HARI INI */
$todayQuery = mysqli_query($koneksi, "
  SELECT COUNT(*) AS total_today
  FROM hasil_scan
  WHERE DATE(waktu) = CURDATE()
");
$today = mysqli_fetch_assoc($todayQuery)['total_today'];

/* DATA TERAKHIR */
$lastQuery = mysqli_query($koneksi, "
  SELECT hasil, persentase
  FROM hasil_scan
  ORDER BY waktu DESC
  LIMIT 1
");
$last = mysqli_fetch_assoc($lastQuery);

/* DATA SEBELUM TERAKHIR */
$prevQuery = mysqli_query($koneksi, "
  SELECT hasil, persentase
  FROM hasil_scan
  ORDER BY waktu DESC
  LIMIT 1 OFFSET 1
");
$prev = mysqli_fetch_assoc($prevQuery);

echo json_encode([
  'total' => (int)$total,
  'status_today' => $today > 0,
  'last' => $last,
  'previous' => $prev
]);
