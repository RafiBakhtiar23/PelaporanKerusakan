<?php
include "../config/db.php";

$hash = password_hash("12345", PASSWORD_DEFAULT);

mysqli_query($conn, "UPDATE users SET password='$hash' WHERE username='siswa1'");
mysqli_query($conn, "UPDATE users SET password='$hash' WHERE username='admin1'");
mysqli_query($conn, "UPDATE users SET password='$hash' WHERE username='teknisi1'");

echo "PASSWORD BERHASIL DIPERBAIKI ✅";