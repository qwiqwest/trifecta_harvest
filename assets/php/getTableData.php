<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "
  SELECT id, DATE_FORMAT(waktu, '%d %b %H:%i') AS waktu_label, a1, a2, b1, b2
  FROM hasil
  ORDER BY waktu ASC
");

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
  $data[] = $row;
}

echo json_encode($data);