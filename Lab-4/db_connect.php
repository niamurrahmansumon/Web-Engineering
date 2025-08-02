<?php
$host = 'localhost';
$dbname = '_db';
$username = 'root'; // Default for localhost (XAMPP)
$password = '';     // Default for localhost (XAMPP)

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Connection successful
echo "✅ Connected successfully";
?>
