<?php
require_once 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL query to delete a user
    $sql = "DELETE FROM users WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            header("location: index.php");
            exit();
        } else {
            echo "Error deleting record.";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>