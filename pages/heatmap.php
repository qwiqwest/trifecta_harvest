<?php
// --- KONEKSI DATABASE ---
$host = "";
$user = ""; 
$pass = "";     
$db   = "";   

$conn = mysqli_connect($host, $user, $pass, $db);

// Tangkap ID dari URL, jika tidak ada, ambil data terbaru
$id_pilihan = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

if ($id_pilihan) {
    // Ambil data spesifik berdasarkan ID
    $query = "SELECT a1, a2, b1, b2, waktu FROM hasil WHERE id = '$id_pilihan'";
} else {
    // Fallback: Ambil data terakhir jika user langsung buka file ini
    $query = "SELECT a1, a2, b1, b2, waktu FROM hasil ORDER BY id DESC LIMIT 1";
}

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) { die("Data tidak ditemukan."); }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Visualisasi Data ID: <?php echo $id_pilihan; ?></title>
    <style>
        body { font-family: sans-serif; display: flex; flex-direction: column; align-items: center; padding: 20px; }
        .back-btn { margin-bottom: 20px; text-decoration: none; color: #f37021; font-weight: bold; }
        
        .heatmap-container {
            position: relative;
            width: 450px;
            height: 550px;
            display: grid;
            grid-template-columns: 100px 175px 175px;
            grid-template-rows: 60px 220px 220px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .label-header { display: flex; justify-content: center; align-items: center; font-size: 1.5rem; font-weight: bold; color: #444; }
        .label-side { display: flex; align-items: center; padding-left: 20px; font-weight: bold; color: #888; }
        .drop-zone { position: relative; display: flex; justify-content: center; align-items: center; }

        /* Efek Glow Heatmap */
        .heat-point {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .value-text { font-weight: bold; color: #333; font-size: 1.1rem; z-index: 2; }
    </style>
</head>
<body>

    <a href="index.php" class="back-btn">← Kembali ke Hasil Scanning</a>
    <h2>Heatmap Detail (Waktu: <?php echo $data['waktu']; ?>)</h2>

    <div class="heatmap-container">
        <div></div>
        <div class="label-header">A</div>
        <div class="label-header">B</div>

        <div class="label-side">Baris 2</div>
        <div class="drop-zone">
            <div class="heat-point" id="p-a2"><span class="value-text"><?php echo $data['a2']; ?>%</span></div>
        </div>
        <div class="drop-zone">
            <div class="heat-point" id="p-b2"><span class="value-text"><?php echo $data['b2']; ?>%</span></div>
        </div>

        <div class="label-side">Baris 1</div>
        <div class="drop-zone">
            <div class="heat-point" id="p-a1"><span class="value-text"><?php echo $data['a1']; ?>%</span></div>
        </div>
        <div class="drop-zone">
            <div class="heat-point" id="p-b1"><span class="value-text"><?php echo $data['b1']; ?>%</span></div>
        </div>
    </div>

    <script>
        function getHeatGradient(value) {
            let v = Math.min(Math.max(value, 0), 100);
            // Skema Warna: Biru (Dingin) -> Hijau -> Kuning -> Merah (Panas)
            if (v < 25) return `radial-gradient(circle, rgba(0,0,255,0.7) 0%, rgba(0,0,255,0) 70%)`;
            if (v < 50) return `radial-gradient(circle, rgba(0,255,0,0.7) 0%, rgba(255,255,0,0.2) 60%, rgba(255,255,255,0) 75%)`;
            if (v < 75) return `radial-gradient(circle, rgba(255,255,0,0.8) 0%, rgba(255,165,0,0.3) 50%, rgba(255,255,255,0) 75%)`;
            return `radial-gradient(circle, rgba(255,0,0,0.8) 0%, rgba(255,255,0,0.4) 40%, rgba(0,0,255,0.1) 60%, rgba(255,255,255,0) 75%)`;
        }

        document.getElementById('p-a1').style.background = getHeatGradient(<?php echo $data['a1']; ?>);
        document.getElementById('p-a2').style.background = getHeatGradient(<?php echo $data['a2']; ?>);
        document.getElementById('p-b1').style.background = getHeatGradient(<?php echo $data['b1']; ?>);
        document.getElementById('p-b2').style.background = getHeatGradient(<?php echo $data['b2']; ?>);
    </script>
</body>
</html>