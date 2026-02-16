<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost","smarthar_rasp","trifecta_harvest","smarthar_jeruk");

$q = $conn->query("
SELECT * FROM commands
WHERE status='pending'
ORDER BY id ASC
LIMIT 1
");

if($row = $q->fetch_assoc()){
    echo json_encode($row);
}else{
    echo json_encode(["command"=>null]);
}
?>
