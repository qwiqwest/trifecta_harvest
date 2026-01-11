<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "
  SELECT id, waktu, hasil, persentase
  FROM hasil_scan
  ORDER BY waktu ASC
");

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
  $data[] = $row;
}

echo json_encode($data);
