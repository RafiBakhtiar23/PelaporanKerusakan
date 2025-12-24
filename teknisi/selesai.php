<?php
require "../middleware/auth.php";
include "../config/db.php";

if ($_SESSION['role'] !== 'teknisi') die("Akses ditolak");

$id = $_POST['id'];
$catatan = mysqli_real_escape_string($conn, $_POST['catatan']);
$teknisi_id = $_SESSION['user_id'];

/* Update status laporan */
mysqli_query($conn, "
    UPDATE reports 
    SET status = 'DONE'
    WHERE report_id = $id
");

/* Simpan catatan ke tracking_progress */
mysqli_query($conn, "
    INSERT INTO tracking_progress (
        report_id,
        technician_id,
        status_awal,
        status_akhir,
        catatan
    ) VALUES (
        $id,
        $teknisi_id,
        'PROCESS',
        'DONE',
        '$catatan'
    )
");

header("Location: dashboard.php");
exit;
