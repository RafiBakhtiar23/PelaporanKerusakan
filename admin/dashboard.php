<?php
require "../middleware/auth.php";
include "../config/db.php";

if ($_SESSION['role'] !== 'admin') die("Akses ditolak");

$data = mysqli_query($conn, "
    SELECT r.*, u.nama 
    FROM reports r
    JOIN users u ON r.user_id = u.user_id
    ORDER BY r.tanggal_lapor DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="navbar">
    <b>Admin - Pelaporan Kerusakan</b>
    <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
</div>

<div class="container">
<div class="card">
    <a href="export_pdf.php" class="btn btn-main" style="margin-bottom:15px;">
        📄 Export PDF
    </a>
<h2>Daftar Laporan Masuk</h2>

<table>
<tr>
    <th>Pelapor</th>
    <th>Judul</th>
    <th>Status</th>
    <th>Tanggal</th>
    <th>Aksi</th>
</tr>

<?php while($r = mysqli_fetch_assoc($data)) { ?>
<tr>
    <td><?= $r['nama'] ?></td>
    <td><?= $r['judul'] ?></td>
    <td>
        <span class="status <?= $r['status'] ?>">
            <?= $r['status'] ?>
        </span>
    </td>
    <td><?= $r['tanggal_lapor'] ?></td>
    <td>
        <a class="btn btn-sm" href="detail.php?id=<?= $r['report_id'] ?>">
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
