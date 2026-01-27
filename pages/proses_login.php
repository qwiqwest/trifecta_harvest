<?php
header('Content-Type: application/json');

$pin_benar = "1234"; // ganti sesuai kebutuhan

if (!isset($_POST['pin'])) {
    echo json_encode(["success" => false]);
    exit;
}

if ($_POST['pin'] === $pin_benar) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
