<?php
include "../config/db.php";

$id = $_GET['id'];

mysqli_query($conn,"
    UPDATE reports 
    SET status='PROCESS' 
    WHERE report_id=$id
");

header("Location: dashboard.php");
