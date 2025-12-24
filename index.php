<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

switch ($_SESSION['role']) {
    case 'admin':
        header("Location: admin/dashboard.php");
        break;
    case 'siswa':
        header("Location: siswa/dashboard.php");
        break;
    case 'teknisi':
        header("Location: teknisi/dashboard.php");
        break;
    default:
        session_destroy();
        header("Location: auth/login.php");
}

exit;
