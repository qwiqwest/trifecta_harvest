<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "
  SELECT 
    a1,a2,a3,a4,a5,a6,a7,a8,a9,a10,
    b1,b2,b3,b4,b5,b6,b7,b8,b9,b10,

    (a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 + a9 + a10) / 10 AS avgA,
    (b1 + b2 + b3 + b4 + b5 + b6 + b7 + b8 + b9 + b10) / 10 AS avgB,

    DATE_FORMAT(waktu, '%d %b %H:%i') AS waktu_label
  FROM hasil
  ORDER BY `waktu_label` DESC
  LIMIT 10
");


$data = [];

while ($row = mysqli_fetch_assoc($query)) {
  $data[] = $row;
}

echo json_encode($data);
