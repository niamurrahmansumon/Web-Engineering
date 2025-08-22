<?php
// 1. MUST start the session on every page where you want to use it
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Session - Page 2</title>
</head>
<body>

    <h1>Reading Session Data</h1>

    <?php
    // 2. Read session variables from the $_SESSION superglobal array
    if (isset($_SESSION["username"])) {
        echo "Welcome back, " . htmlspecialchars($_SESSION["username"]) . "!<br>";
        echo "Your favorite color is " . htmlspecialchars($_SESSION["favorite_color"]) . ".";
    } else {
        echo "It seems the session was not set. Please go back to Page 1.";
    }
    ?>

    <p>The server remembered who you are!</p>
    <br>
    <a href="session.php">Go back to Start Session</a><br>
    <a href="logout.php">Logout (Destroy Session)</a>

</body>
</html>