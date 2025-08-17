<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Dashboard</title>
</head>
<body>
  <h1>Welcome, <?php echo $_SESSION['user_email']; ?> 🎉</h1>
  <p>You are now logged in.</p>
  <a href="logout.php">Logout</a>
</body>
</html>
