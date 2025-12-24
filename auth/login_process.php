<?php
session_start(); // 🔥 WAJIB, INI YANG BIKIN LOGIN STUCK TADI

include "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($query);

if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['role']    = $user['role'];

    if ($user['role'] === 'admin') {
        header("Location: ../admin/dashboard.php");
    } elseif ($user['role'] === 'siswa') {
        header("Location: ../siswa/dashboard.php");
    } elseif ($user['role'] === 'teknisi') {
        header("Location: ../teknisi/dashboard.php");
    }

    exit;

} else {
    echo "<script>
        alert('Username atau password salah');
        window.location='login.php';
    </script>";
}
