<?php
$id = $_POST['id'];

$conn = new mysqli("localhost","smarthar_rasp","trifecta_harvest","smarthar_jeruk");

$conn->query("
UPDATE commands
SET status='done'
WHERE id=$id
");

echo "ok";
?>
