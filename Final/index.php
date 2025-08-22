<?php
// We need the database connection file
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP CRUD</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        .action-links a { margin-right: 10px; }
        form { border: 1px solid #ccc; padding: 20px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <h2>Add New User</h2>
    <form action="create.php" method="post">
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <input type="submit" value="Add User">
    </form>

    <hr>

    <h2>Users List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // SQL query to fetch all users, ordered by the latest first
            $sql = "SELECT * FROM users ORDER BY id DESC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Loop through each row of the result
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td class='action-links'>";
                    echo "<a href='edit.php?id=" . $row['id'] . "'>Edit</a>";
                    echo "<a href='delete.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure?');\">Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
<?php
// Close the database connection
mysqli_close($conn);
?>