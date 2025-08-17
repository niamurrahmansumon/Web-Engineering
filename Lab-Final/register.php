<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "bibahabd";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profile_created = $_POST['profile_created'];
    $looking_for     = $_POST['looking_for'];
    $candidate_name  = $_POST['candidate_name'];
    $dob             = $_POST['dob'];
    $community       = $_POST['community'];
    $education       = $_POST['education'];
    $profession      = $_POST['profession'];
    $country         = $_POST['country'];
    $division        = $_POST['division'];
    $district        = $_POST['district'];
    $city            = $_POST['city'];
    $residence       = $_POST['residence'];
    $email           = $_POST['email'];
    $cemail          = $_POST['confirm_email'];
    $phone           = $_POST['phone'];
    $password        = $_POST['password'];
    $cpassword       = $_POST['confirm_password'];

    // Validation
    if ($password !== $cpassword) {
        $message = "<p style='color:red;'>Passwords do not match!</p>";
    } elseif ($email !== $cemail) {
        $message = "<p style='color:red;'>Emails do not match!</p>";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into DB
        $sql = "INSERT INTO users 
                (profile_created, looking_for, candidate_name, dob, community, education, profession, country, division, district, city, residence, email, phone, password) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssssssss",
            $profile_created, $looking_for, $candidate_name, $dob, $community, $education, $profession, 
            $country, $division, $district, $city, $residence, $email, $phone, $hashed_password
        );

        if ($stmt->execute()) {
            $message = "<p style='color:green;'>Registration Successful!</p>";
        } else {
            $message = "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register on Bibahabd | Signup</title>
    <style>
        body {font-family: Arial, sans-serif; background:#fff; margin:0; padding:0;}
        .header {background:#7ca93f; padding:15px; color:white; font-size:18px; font-weight:bold;}
        .container {width:1000px; margin:20px auto; display:flex; gap:20px;}
        .form-box {flex:3; border:1px solid #ccc; background:#f9f9f9; padding:20px;}
        .form-section {margin-bottom:20px; padding:15px; background:#e8f0dc; border-radius:5px;}
        h2 {color:#3b6e22; margin-bottom:15px;}
        h3 {color:#444; margin-bottom:10px;}
        label {display:inline-block; width:200px; margin-bottom:6px; font-weight:bold; vertical-align:top;}
        input, select {padding:6px; width:250px; margin-bottom:10px;}
        .submit-btn {background:#6b9b37; color:white; padding:10px 20px; border:none; font-size:16px; cursor:pointer;}
        .submit-btn:hover {background:#5a882e;}
        .sidebar {flex:1; border:1px solid #ccc; background:#f4f4f4; padding:15px;}
        .sidebar h4 {margin-top:0; color:#3b6e22;}
        .footer {background:#7ca93f; color:white; text-align:center; padding:10px; margin-top:30px;}
    </style>
</head>
<body>

<div class="header">Bibahabd.com - Create a New Profile</div>

<div class="container">
    <div class="form-box">
        <h2>Create a new profile</h2>
        <?php if (!empty($message)) echo $message; ?>

        <form method="POST" action="">
            <!-- Basic Information -->
            <div class="form-section">
                <h3>Basic Information</h3>
                <label>Profile created by:</label>
                <select name="profile_created">
                    <option>Self</option>
                    <option>Parent</option>
                    <option>Sibling</option>
                </select><br>

                <label>Looking For:</label>
                <select name="looking_for">
                    <option>Bride</option>
                    <option>Groom</option>
                </select><br>

                <label>Candidate Full Name:</label>
                <input type="text" name="candidate_name" required><br>

                <label>Date of Birth:</label>
                <input type="date" name="dob"><br>

                <label>Community / Religion:</label>
                <select name="community">
                    <option>Islam</option>
                    <option>Hindu</option>
                    <option>Christian</option>
                    <option>Buddhist</option>
                </select><br>

                <label>Education:</label>
                <input type="text" name="education"><br>

                <label>Profession:</label>
                <input type="text" name="profession"><br>
            </div>

            <!-- Present Location -->
            <div class="form-section">
                <h3>Present Location</h3>
                <label>Country:</label>
                <input type="text" name="country"><br>

                <label>Division:</label>
                <input type="text" name="division"><br>

                <label>District:</label>
                <input type="text" name="district"><br>

                <label>City:</label>
                <input type="text" name="city"><br>

                <label>Resident Status:</label>
                <select name="residence">
                    <option>Permanent</option>
                    <option>Temporary</option>
                </select><br>
            </div>

            <!-- Account Information -->
            <div class="form-section">
                <h3>Account Information</h3>
                <label>Email Address:</label>
                <input type="email" name="email" required><br>

                <label>Confirm Email Address:</label>
                <input type="email" name="confirm_email" required><br>

                <label>Candidate Phone Number:</label>
                <input type="text" name="phone" required><br>

                <label>Password:</label>
                <input type="password" name="password" required><br>

                <label>Confirm Password:</label>
                <input type="password" name="confirm_password" required><br>
            </div>

            <input type="submit" class="submit-btn" value="Submit">
        </form>
    </div>

    <div class="sidebar">
        <h4>Related Links</h4>
        <ul>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Support</a></li>
            <li><a href="#">Terms & Conditions</a></li>
            <li><a href="#">Privacy Policy</a></li>
        </ul>

        <h4>Support Center</h4>
        <p>Email: support@bibahabd.com</p>
        <p>Phone: +8801XXXXXXXXX</p>
        <p>Live Chat Available</p>
    </div>
</div>

<div class="footer">© 2025 Bibahabd.com | All rights reserved</div>

</body>
</html>