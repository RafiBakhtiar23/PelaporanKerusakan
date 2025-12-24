<?php
require "../middleware/auth.php";
include "../config/db.php";

if ($_SESSION['role'] !== 'admin') die("Akses ditolak");

$id = $_GET['id'];

$q = mysqli_query($conn,"
    SELECT r.*, u.nama 
    FROM reports r
    JOIN users u ON r.user_id = u.user_id
    WHERE r.report_id=$id
");
$r = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html>
<head>
<title>Detail Laporan</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">
<div class="card">

<h2><?= $r['judul'] ?></h2>

<p><b>Pelapor:</b> <?= $r['nama'] ?></p>
<p><b>Lokasi:</b> <?= $r['lokasi'] ?></p>
<p><b>Deskripsi:</b><br><?= nl2br($r['deskripsi']) ?></p>
<p><b>Status:</b> <?= $r['status'] ?></p>

<hr>

<?php if($r['status'] == 'OPEN') { ?>
    <a class="btn" href="process.php?id=<?= $id ?>">Set PROCESS</a>
    <a class="btn btn-danger" href="reject.php?id=<?= $id ?>">Reject</a>
<?php } ?>

<?php if($r['status'] == 'PROCESS' && $r['assigned_to'] == NULL) { ?>
    <a class="btn" href="assign.php?id=<?= $id ?>">Assign Teknisi</a>
<?php } ?>

<a href="dashboard.php">⬅ Kembali</a>

</div>
</div>

</body>
</html>
