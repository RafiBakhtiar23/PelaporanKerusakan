<?php
require "../middleware/auth.php";
include "../config/db.php";

$user_id = $_SESSION['user_id'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];
$lokasi = $_POST['lokasi'];

$foto = null;

if (!empty($_FILES['foto']['name'])) {
    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png'];

    if (!in_array($ext, $allowed)) {
        echo "<script>alert('Format foto tidak valid');history.back();</script>";
        exit;
    }

    if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
        echo "<script>alert('Ukuran foto maksimal 2MB');history.back();</script>";
        exit;
    }

    $foto = time().".".$ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/$foto");
}

mysqli_query($conn, "
    INSERT INTO reports (user_id, judul, deskripsi, lokasi, foto)
    VALUES ('$user_id','$judul','$deskripsi','$lokasi','$foto')
");

header("Location: dashboard.php");
