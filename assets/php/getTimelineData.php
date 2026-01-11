<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "
  SELECT 
    hasil,
    persentase,
    DATE_FORMAT(waktu, '%d %b %H:%i') AS waktu_label
  FROM hasil_scan
  ORDER BY waktu DESC
  LIMIT 7
");

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
  $data[] = $row;
}

echo json_encode($data);
