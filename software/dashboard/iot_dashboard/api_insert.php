<?php
header("Content-Type: application/json");

// ===== DATABASE CONFIG =====
$host = "sql111.infinityfree.com";
$user = "if0_41039846";
$pass = "hepnKh2E43ns";
$db   = "if0_41039846_jeruk";

// ===== CONNECT =====
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["status"=>"error","msg"=>"DB gagal konek"]));
}

// ===== AMBIL DATA POST =====
$hasil = $_POST['hasil'] ?? null;
$persen = $_POST['persentase'] ?? null;

if($hasil === null || $persen === null){
    echo json_encode(["status"=>"error","msg"=>"data kosong"]);
    exit;
}

// ===== INSERT =====
$stmt = $conn->prepare("INSERT INTO coba (hasil,persentase) VALUES (?,?)");
$stmt->bind_param("ii",$hasil,$persen);

if($stmt->execute()){
    echo json_encode(["status"=>"ok"]);
}else{
    echo json_encode(["status"=>"error","msg"=>"gagal insert"]);
}

$stmt->close();
$conn->close();
?>
