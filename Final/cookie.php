<?php

$cookie_name = "user_preference";
$cookie_value = "dark_mode";
$expiration = time() + (3600); // 3600 seconds = 1 hour
setcookie($cookie_name, $cookie_value, $expiration, "/"); // "/" means the cookie is available for the entire website

// === DELETING A COOKIE ===
// To delete a cookie, you set its expiration date to a time in the past.
// Let's set a cookie to be deleted.
setcookie("cookie_to_delete", "some_value", time() + 3600, "/");

// Now, let's delete it immediately (for demonstration)
// In a real app, a user might click a "delete" button.
if (isset($_GET['deletecookie'])) {
    setcookie("cookie_to_delete", "", time() - 3600, "/"); // Set expiration to one hour ago
    // Redirect to the same page to see the change
    header("Location: cookie_example.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Cookie Example</title>
</head>
<body>

    <h1>Working with Cookies</h1>

    <?php
    // === READING A COOKIE ===
    // We use the $_COOKIE superglobal array to read cookies.

    echo "<h2>Reading Cookies:</h2>";

    if (isset($_COOKIE[$cookie_name])) {
        echo "Cookie '" . $cookie_name . "' is set!<br>";
        echo "Your preference is: " . htmlspecialchars($_COOKIE[$cookie_name]);
    } else {
        echo "Cookie '" . $cookie_name . "' is not set. Please reload the page.";
    }

    echo "<hr>";

    if (isset($_COOKIE['cookie_to_delete'])) {
        echo "'cookie_to_delete' exists. <a href='cookie_example.php?deletecookie=true'>Click here to delete it.</a>";
    } else {
        echo "'cookie_to_delete' has been deleted. Refresh the page if you just clicked the link.";
    }
    ?>

    <p><strong>How to test:</strong></p>
    <ol>
        <li>Load this page for the first time. It will tell you the 'user_preference' cookie is not set, but the PHP code has just sent it to your browser.</li>
        <li>Reload the page. Now your browser sends the cookie back to the server, and the script will display its value.</li>
        <li>Click the "delete" link to see the other cookie get deleted.</li>
    </ol>

</body>
</html>