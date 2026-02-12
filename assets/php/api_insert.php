<?php
header("Content-Type: application/json");

// ===== CONFIG DB (GANTI SESUAI CPANEL) =====
$host = "localhost";      // biasanya localhost di hosting berbayar
$user = "smarthar_rasp";
$pass = "trifecta_harvest";
$db   = "smarthar_jeruk";

$conn = new mysqli($host,$user,$pass,$db);

if ($conn->connect_error) {
    echo json_encode(["status"=>"error","msg"=>"DB gagal"]);
    exit;
}

$a1 = $_POST['a1'] ?? null;
$a2 = $_POST['a2'] ?? null;
$b1 = $_POST['b1'] ?? null;
$b2 = $_POST['b2'] ?? null;

if($a1===null || $a2===null || $b1===null || $b2===null){
    echo json_encode(["status"=>"error","msg"=>"data kosong"]);
    exit;
}

// waktu otomatis pakai NOW()
$stmt = $conn->prepare("
INSERT INTO hasil (waktu,a1,a2,b1,b2)
VALUES (NOW(),?,?,?,?)
");

$stmt->bind_param("iiii",$a1,$a2,$b1,$b2);

if($stmt->execute()){
    echo json_encode(["status"=>"ok"]);
}else{
    echo json_encode(["status"=>"error","msg"=>$stmt->error]);
}

$stmt->close();
$conn->close();
?>
