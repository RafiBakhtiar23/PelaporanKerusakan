<?php
require "../middleware/auth.php";
include "../config/db.php";

if ($_SESSION['role'] !== 'teknisi') die("Akses ditolak");

$id = $_GET['id'];

$data = mysqli_query($conn, "
    SELECT r.*, u.nama 
    FROM reports r
    JOIN users u ON r.user_id = u.user_id
    WHERE r.report_id = $id
");

$r = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Laporan</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="navbar">
    <a href="dashboard.php" class="btn">⬅ Kembali</a>
</div>

<div class="container">
    <div class="card">
        <h2><?= $r['judul'] ?></h2>

        <p><b>Pelapor:</b> <?= $r['nama'] ?></p>
        <p><b>Lokasi:</b> <?= $r['lokasi'] ?></p>
        <p><b>Deskripsi:</b><br><?= nl2br($r['deskripsi']) ?></p>
        <p><b>Status:</b> <?= $r['status'] ?></p>

        <form action="selesai.php" method="POST">
            <input type="hidden" name="id" value="<?= $r['report_id'] ?>">

            <label>Catatan Teknisi</label>
            <textarea name="catatan" required></textarea>

            <button type="submit" class="btn btn-success">
                Tandai Selesai
            </button>
        </form>
    </div>
</div>

</body>
</html>
