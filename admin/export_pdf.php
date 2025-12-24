<?php
require "../middleware/auth.php";
include "../config/db.php";
require "../vendor/autoload.php";

use Dompdf\Dompdf;

if ($_SESSION['role'] !== 'admin') die("Akses ditolak");

$q = mysqli_query($conn,"
    SELECT r.*, u.nama 
    FROM reports r
    JOIN users u ON r.user_id = u.user_id
    ORDER BY r.tanggal_lapor DESC
");

$html = '
<!DOCTYPE html>
<html>
<head>
<style>
body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    color: #333;
}

.header {
    text-align: center;
    border-bottom: 3px solid #000;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.header h1 {
    margin: 0;
    font-size: 20px;
    letter-spacing: 1px;
}

.header p {
    margin: 3px 0;
    font-size: 12px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background: #2c3e50;
    color: #fff;
    padding: 8px;
    text-align: center;
    font-size: 11px;
}

.table td {
    border: 1px solid #ccc;
    padding: 7px;
    font-size: 11px;
}

.status {
    padding: 4px 8px;
    border-radius: 4px;
    color: #fff;
    font-size: 10px;
    text-align: center;
}

.OPEN { background: #f39c12; }
.PROCESS { background: #2980b9; }
.DONE { background: #27ae60; }
.REJECT { background: #c0392b; }

.footer {
    margin-top: 30px;
    text-align: right;
    font-size: 10px;
    color: #666;
}
</style>
</head>

<body>

<div class="header">
    <h1>LAPORAN KERUSAKAN SARANA & PRASARANA</h1>
    <p>SMK Negeri 4 Padalarang</p>
    <p>Tahun Ajaran '.date('Y').'</p>
</div>

<table class="table">
<tr>
    <th>No</th>
    <th>Pelapor</th>
    <th>Judul</th>
    <th>Lokasi</th>
    <th>Status</th>
    <th>Tanggal</th>
</tr>
';

$no = 1;
while($r = mysqli_fetch_assoc($q)){
    $html .= "
    <tr>
        <td align='center'>{$no}</td>
        <td>{$r['nama']}</td>
        <td>{$r['judul']}</td>
        <td>{$r['lokasi']}</td>
        <td align='center'>
            <span class='status {$r['status']}'>{$r['status']}</span>
        </td>
        <td>{$r['tanggal_lapor']}</td>
    </tr>";
    $no++;
}

$html .= '
</table>

<div class="footer">
    Dicetak pada: '.date('d-m-Y H:i').'
</div>

</body>
</html>
';

$pdf = new Dompdf();
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'portrait');
$pdf->render();
$pdf->stream("Laporan_Kerusakan_SMKN4.pdf", ["Attachment" => false]);
