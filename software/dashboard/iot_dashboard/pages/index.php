<?php
include '../assets/php/koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM hasil_scan");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Daftar Mahasiswa</h2>

<table>
    <tr>
        <th>id</th>
        <th>waktu</th>
        <th>hasil</th>
        <th>jumlah</th>
    </tr>

    <?php $no = 1; ?>
    <?php while ($data = mysqli_fetch_assoc($query)) { ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $data['waktu']; ?></td>
        <td><?= $data['hasil']; ?></td>
        <td><?= $data['jumlah']; ?></td>
    </tr>
    <?php } ?>

</table>

</body>
</html>
