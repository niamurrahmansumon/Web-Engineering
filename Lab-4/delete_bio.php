<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "sumon";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("DB Connection Failed: ".$conn->connect_error);

$id = intval($_GET['id'] ?? 0);

// Optionally delete photo file
$res = $conn->query("SELECT photo FROM bio_data WHERE id=$id");
if($res && $res->num_rows>0){
    $row = $res->fetch_assoc();
    if($row['photo'] && file_exists($row['photo'])) unlink($row['photo']);
}

// Delete record
$conn->query("DELETE FROM bio_data WHERE id=$id");
$conn->close();

header("Location: view_bio.php");
exit;
?>