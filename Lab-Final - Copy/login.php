<?php
session_start();
include 'db.php';

$error = "";

// Debugging: Show DB connection error if any
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM users WHERE email=? OR profile_id=? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $email, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "❌ Invalid Password!";
        }
    } else {
        $error = "❌ Invalid Email or Profile ID!";
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
      background: #f9f9f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-box {
      background: #fff;
      border: 1px solid #ddd;
      padding: 25px;
      width: 420px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .header {
      background: #9c0;
      padding: 10px;
      color: white;
      font-weight: bold;
      text-align: center;
    }
    .form-group {
      margin-bottom: 15px;
    }
    input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .btn {
      background: #9c0;
      color: white;
      padding: 10px;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }
    .btn:hover {
      background: #7a0;
    }
    .error { color: red; margin-bottom: 10px; }
    .side-box {
      margin-top: 20px;
      padding: 10px;
      border-left: 2px solid #ccc;
    }
    .side-box a {
      color: #9c0;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <div class="header">Login To Continue...</div>
    
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
      <div class="form-group">
        <label>Email ID or Profile ID</label>
        <input type="text" name="email" placeholder="Email ID or Profile ID" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <button type="submit" class="btn">LOGIN</button>
    </form>

    <div class="side-box">
      <p><strong>Not Our Member?</strong><br>
      Have not previously registered?<br>
      <a href="register.php"><button class="btn">REGISTER NOW</button></a></p>

      <p><strong>Forgot Password?</strong><br>
      <a href="recover.php">Click here for Recover</a> a new password.</p>
    </div>
  </div>
</body>
</html>