<?php
include 'db_connect.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>User List</h2>";
    while($row = $result->fetch_assoc()) {
        echo "ID: {$row['id']} | Name: {$row['name']} | Email: {$row['email']} | Age: {$row['age']}<br>";
    }
} else {
    echo "No users found.";
}

$conn->close();
?>