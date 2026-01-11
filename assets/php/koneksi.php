<?php
$koneksi = mysqli_connect("localhost", "root", "", "jeruk");

if (!$koneksi) {
    die("Koneksi gagal");
}
