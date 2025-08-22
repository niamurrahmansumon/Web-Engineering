<?php
require_once 'db.php';

// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // SQL query to insert data into the 'users' table
    $sql = "INSERT INTO users (name, email) VALUES (?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        // "ss" means the types of the parameters are both strings
        mysqli_stmt_bind_param($stmt, "ss", $name, $email);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // If successful, redirect back to the main page
            header("location: index.php");
            exit();
        } else {
            echo "Error: Could not execute the query.";
        }
    } else {
        echo "Error: Could not prepare the query.";
    }
    // Close statement
    mysqli_stmt_close($stmt);
}
// Close connection
mysqli_close($conn);
?>