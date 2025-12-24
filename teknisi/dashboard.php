<?php
require "../middleware/auth.php";
include "../config/db.php";

if ($_SESSION['role'] !== 'teknisi') die("Akses ditolak");

$data = mysqli_query($conn, "
    SELECT r.*, u.nama 
    FROM reports r
    JOIN users u ON r.user_id = u.user_id
    WHERE r.status = 'PROCESS'
    ORDER BY r.tanggal_lapor DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Teknisi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="navbar">
    <b>Dashboard Teknisi</b>
    <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
</div>

<div class="container">
    <div class="card">
        <h2>Laporan Sedang Diproses</h2>

        <table>
            <tr>
                <th>Pelapor</th>
                <th>Judul</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>

            <?php while ($r = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <td><?= $r['nama'] ?></td>
                <td><?= $r['judul'] ?></td>
                <td><?= $r['lokasi'] ?></td>
                <td><?= $r['tanggal_lapor'] ?></td>
                <td>
                    <a href="detail.php?id=<?= $r['report_id'] ?>" class="btn btn-sm">
                        Detail
                    </a>
                </td>
            </tr>
            <?php } ?>
        </table>

    </div>
</div>

</body>
</html>
