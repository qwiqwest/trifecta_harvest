<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "
  SELECT 
    a1,a2,
    b1,b2,

    (a1 + a2) / 2 AS avgA,
    (b1 + b2) / 2 AS avgB,

    DATE_FORMAT(waktu, '%d %b %H:%i') AS waktu_label
  FROM hasil
  ORDER BY `waktu` DESC
  LIMIT 10
");


$data = [];

while ($row = mysqli_fetch_assoc($query)) {
  $data[] = $row;
}

echo json_encode($data);
