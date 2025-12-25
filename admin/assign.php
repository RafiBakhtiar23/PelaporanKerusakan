<?php
require "../middleware/auth.php";
include "../config/db.php";

$id = $_GET['id'];

$teknisi = mysqli_query($conn,"
    SELECT * FROM users WHERE role='teknisi'
");
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Assign Teknisi</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">
<div class="card">

<h2>Assign Teknisi</h2>

<form method="post">
<select name="teknisi_id" required>
<option value="">-- Pilih Teknisi --</option>
<?php while($t=mysqli_fetch_assoc($teknisi)){ ?>
<option value="<?= $t['user_id'] ?>"><?= $t['nama'] ?></option>
<?php } ?>
</select>

<button class="btn">Assign</button>
</form>

</div>
</div>

<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    $tid = $_POST['teknisi_id'];
    mysqli_query($conn,"
        UPDATE reports 
        SET assigned_to=$tid 
        WHERE report_id=$id
    ");
    header("Location: dashboard.php");
}
?>

</body>
</html>
