<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    // SQL query to update the user's data
    $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // "ssi" means two strings and then one integer
        mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("location: index.php");
            exit();
        } else {
            echo "Error updating record.";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>