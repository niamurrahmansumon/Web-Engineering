<?php
include 'db_connect.php';

$name = "Sumon";
$email = "sumon@gmail.com";
$age = 24;

$sql = "INSERT INTO users (name, email, age) VALUES ('$name', '$email', $age)";
if ($conn->query($sql) === TRUE) {
    echo "✅ New record created successfully";
} else {
    echo "❌ Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>