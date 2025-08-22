<?php
// 1. Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Session - Page 1</title>
</head>
<body>

    <h1>Session Started</h1>

    <?php
    // 2. Set session variables
    $_SESSION["username"] = "Alex";
    $_SESSION["favorite_color"] = "blue";
    
    echo "Session variables have been set.";
    ?>

    <p>Now, let's go to another page and see if the session variables are still there.</p>
    <a href="read_session.php">Go to Page 2</a>

</body>
</html>