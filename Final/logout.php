<?php
// 1. Start the session to access it
session_start();

// 2. Unset all of the session variables
$_SESSION = array(); // or session_unset();

// 3. Destroy the session
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
</head>
<body>

    <h1>Session Destroyed</h1>
    <p>You have been logged out. All session data is gone.</p>

    <a href="session.php">Go to Start Session</a><br>
    <a href="read_session.php">Go to Check Session (You will see the session is gone)</a>

</body>
</html>