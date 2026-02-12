<?php
$koneksi = mysqli_connect("", "", "", database: "");

if (!$koneksi) {
    die("Koneksi gagal");
}
