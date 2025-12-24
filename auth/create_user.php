<?php
include "../config/db.php";

$users = [
    ['Rafi','siswa1','12345','siswa'],
    ['Dimas','admin1','12345','admin'],
    ['Ridwan','teknisi1','12345','teknisi'],
];

foreach ($users as $u) {
    $hash = password_hash($u[2], PASSWORD_DEFAULT);
    mysqli_query($conn,"INSERT INTO users (nama, username, password, role)
    VALUES ('$u[0]','$u[1]','$hash','$u[3]')");
}

echo "USER BERHASIL DIBUAT";
