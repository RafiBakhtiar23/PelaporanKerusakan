<?php
require "../middleware/auth.php";
include "../config/db.php";

if ($_SESSION['role'] !== 'siswa') die("Akses ditolak");

$user_id = $_SESSION['user_id'];
$data = mysqli_query($conn, "
    SELECT * FROM reports 
    WHERE user_id = $user_id 
    ORDER BY tanggal_lapor DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head> 
<body>

<div class="navbar">
    <b>Pelaporan Kerusakan</b>
    <div>
        <a href="tambah_laporan.php" class="btn">+ Laporan</a>
        <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
        
    </div>
</div>


<div class="container">
    <div class="card">
        <h2>Riwayat Laporan Saya</h2>
<?php if (mysqli_num_rows($data) == 0): ?>
    <div style="padding:20px; text-align:center; color:#777">
        <p>📭 Belum ada laporan</p>
        <p>Silakan klik <b>+ Laporan</b> untuk membuat laporan baru</p>
    </div>
<?php else: ?>
    <div class="table-wrapper">
<table>
    <tr>
        <th>Judul</th>
        <th>Lokasi</th>
        <th>Status</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>

    <?php while ($r = mysqli_fetch_assoc($data)) { ?>
    <tr>
        <td><?= htmlspecialchars($r['judul']) ?></td>
        <td><?= htmlspecialchars($r['lokasi']) ?></td>
        <td>
            <span class="status <?= $r['status'] ?>">
                <?= $r['status'] ?>
            </span>
        </td>
        <td><?= $r['tanggal_lapor'] ?></td>
        <td>
            <a class="btn btn-sm" href="../reports/detail.php?id=<?= $r['report_id'] ?>">
                Detail
            </a>
        </td>
    </tr>
    <?php } ?>
</table>
        </div>
<?php endif; ?>


    </div>
</div>

</body>
</html>
