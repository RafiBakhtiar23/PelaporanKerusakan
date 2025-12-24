<?php
require "../middleware/auth.php";
if ($_SESSION['role'] !== 'siswa') die("Akses ditolak");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buat Laporan</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="navbar">
    <b>Form Laporan Kerusakan</b>
    <a href="dashboard.php" class="btn">← Kembali</a>
</div>

<div class="container">
    <div class="card">
        <form action="simpan_laporan.php" method="POST" enctype="multipart/form-data">
            <label>Judul Laporan</label>
            <input type="text" name="judul" required>

            <label>Deskripsi Kerusakan</label>
            <textarea name="deskripsi" rows="4" required></textarea>

            <label>Lokasi</label>
            <input type="text" name="lokasi" required>

            <label>Foto (Opsional)</label>
            <input type="file" name="foto">

            <button class="btn" type="submit">Kirim Laporan</button>
        </form>
    </div>
</div>

</body>
</html>
