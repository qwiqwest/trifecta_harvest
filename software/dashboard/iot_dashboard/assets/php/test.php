<?php
header("Content-Type: application/json");

// ===== DB CONFIG =====
$host="localhost";
$user="smarthar_rasp";
$pass="trifecta_harvest";
$db="smarthar_jeruk";

$conn = new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
    echo json_encode(["status"=>"error","msg"=>"DB gagal"]);
    exit;
}

// ===== AMBIL JSON BODY =====
$data = json_decode(file_get_contents("php://input"), true);

if(!$data){
    echo json_encode(["status"=>"error","msg"=>"JSON kosong"]);
    exit;
}

// Mapping ke variabel database
$a1 = $data["baris1"]["A"]["persentase"] ?? null;
$a2 = $data["baris1"]["B"]["persentase"] ?? null;
$b1 = $data["baris2"]["A"]["persentase"] ?? null;
$b2 = $data["baris2"]["B"]["persentase"] ?? null;

if($a1===null || $a2===null || $b1===null || $b2===null){
    echo json_encode(["status"=>"error","msg"=>"data tidak lengkap"]);
    exit;
}

$stmt=$conn->prepare("
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
