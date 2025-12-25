<?php
require "../middleware/auth.php";
include "../config/db.php";

if (!isset($_GET['id'])) {
    die("ID laporan tidak ditemukan");
}

$report_id = intval($_GET['id']);

// ambil data laporan
$q = mysqli_query($conn, "
    SELECT r.*, u.nama AS pelapor, t.nama AS teknisi
    FROM reports r
    JOIN users u ON r.user_id = u.user_id
    LEFT JOIN users t ON r.assigned_to = t.user_id
    WHERE r.report_id = $report_id
");

$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Laporan tidak ditemukan");
}

// ambil tracking
$tracking = mysqli_query($conn, "
    SELECT tp.*, u.nama 
    FROM tracking_progress tp
    LEFT JOIN users u ON tp.technician_id = u.user_id
    WHERE tp.report_id = $report_id
    ORDER BY tp.timestamp DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="navbar">
    <b>Detail Laporan</b>
    <a href="javascript:history.back()" class="btn">⬅ Kembali</a>
</div>

<div class="container">
    <div class="card">

        <h2><?= $data['judul'] ?></h2>

        <p><b>Pelapor:</b> <?= $data['pelapor'] ?></p>
        <p><b>Lokasi:</b> <?= $data['lokasi'] ?></p>
        <p><b>Tanggal:</b> <?= $data['tanggal_lapor'] ?></p>

        <p>
            <b>Status:</b>
            <span class="status <?= $data['status'] ?>">
                <?= $data['status'] ?>
            </span>
        </p>

        <p><b>Teknisi:</b>
            <?= $data['teknisi'] ? $data['teknisi'] : '-' ?>
        </p>

        <hr>

        <h3>Deskripsi</h3>
        <p><?= nl2br($data['deskripsi']) ?></p>

        <?php if ($data['foto']) : ?>
            <img src="../uploads/<?= $data['foto'] ?>" class="img-preview">
        <?php endif ?>

        <hr>

        <h3>Riwayat Status</h3>

        <table>
            <tr>
                <th>Waktu</th>
                <th>Status Awal</th>
                <th>Status Akhir</th>
                <th>Oleh</th>
                <th>Catatan</th>
            </tr>

            <?php while ($t = mysqli_fetch_assoc($tracking)) : ?>
            <tr>
                <td><?= $t['timestamp'] ?></td>
                <td><?= $t['status_awal'] ?></td>
                <td><?= $t['status_akhir'] ?></td>
                <td><?= $t['nama'] ?? 'Sistem' ?></td>
                <td><?= $t['catatan'] ?></td>
            </tr>
            <?php endwhile ?>
        </table>

    </div>
</div>

</body>
</html>
