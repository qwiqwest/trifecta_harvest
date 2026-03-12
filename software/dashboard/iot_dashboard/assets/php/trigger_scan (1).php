<?php
include "koneksi.php";

$sql = "INSERT INTO commands (command,status)
        VALUES ('scan','pending')";

if(mysqli_query($koneksi,$sql)){
    echo json_encode(["ok"=>true]);
}else{
    echo json_encode(["ok"=>false]);
}
?>
