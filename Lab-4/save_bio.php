<?php
// DB CONFIG
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "sumon";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("DB Connection Failed: " . $conn->connect_error);

// Collect POST data
$name         = $_POST['name'];
$fatherName   = $_POST['fatherName'];
$motherName   = $_POST['motherName'];
$qualification= $_POST['qualification'];
$weight       = $_POST['weight'];
$dob          = $_POST['dob'];
$height       = $_POST['height'];
$gender       = $_POST['gender'];
$password     = $_POST['password'];  // store plain text password

// Upload photo
$photoPath = "";
if (!empty($_FILES['photoInput']['name'])) {
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    $fileName = time()."_".basename($_FILES['photoInput']['name']);
    $targetPath = $uploadDir.$fileName;
    if(move_uploaded_file($_FILES['photoInput']['tmp_name'],$targetPath)){
        $photoPath = $targetPath;
    }
}

// Insert into DB (plain password)
$stmt = $conn->prepare("INSERT INTO bio_data 
(photo, name, father_name, mother_name, qualification, weight, dob, height, gender, password) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "sssssdssss",
    $photoPath,
    $name,
    $fatherName,
    $motherName,
    $qualification,
    $weight,
    $dob,
    $height,
    $gender,
    $password
);

if($stmt->execute()){
    echo "<script>alert('Data Saved Successfully!'); window.location='view_bio.php';</script>";
} else {
    echo "Error: ".$conn->error;
}

$conn->close();
?>