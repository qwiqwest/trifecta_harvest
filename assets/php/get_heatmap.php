<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost","root","","jeruk");

$sql = "
  SELECT 
    baris,
    sisi,
    AVG(value) AS value
    FROM heatmap_scan
    GROUP BY baris, sisi;

";

$res = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($res)) {
    $data[] = [
        'baris' => (int)$row['baris'],
        'sisi'  => $row['sisi'],
        'value' => (int)$row['value']
    ];
}

echo json_encode($data);
