<?php
session_start();
include("db.php");

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' OR profile_id='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Email/Profile ID or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            width: 450px;
            background: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .login-header {
            background: #8bb600;
            padding: 10px;
            color: #fff;
            font-weight: bold;
        }
        .login-body {
            display: flex;
            padding: 20px;
        }
        .left-box {
            flex: 1;
            margin-right: 15px;
        }
        .left-box input {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .left-box button {
            background: #8bb600;
            border: none;
            padding: 10px 15px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
        }
        .right-box {
            flex: 1;
            border-left: 1px solid #ddd;
            padding-left: 15px;
            font-size: 14px;
            color: #333;
        }
        .right-box a {
            color: #8bb600;
            text-decoration: none;
            font-weight: bold;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">Login To Continue...</div>
        <div class="login-body">
            <div class="left-box">
                <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
                <form method="post" action="">
                    <input type="text" name="email" placeholder="Email ID or Profile ID" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="login">LOGIN</button>
                </form>
            </div>
            <div class="right-box">
                <p><b>Not Our Member?</b><br>Have not previously registered?</p>
                <a href="register.php"><button>REGISTER NOW</button></a>
                <p style="margin-top:15px;">
                    <b>Forgot Password?</b><br>
                    <a href="recover.php">Click here for Recover</a> a new password.
                </p>
            </div>
        </div>
    </div>
</body>
</html>