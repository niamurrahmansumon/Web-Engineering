<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f9f9f9; }
        .profile-box { width: 80%; margin: auto; background: #fff; padding: 20px; border: 1px solid #ddd; }
        .left { float: left; width: 25%; text-align: center; }
        .right { float: right; width: 70%; }
        img { width: 120px; border-radius: 50%; }
        .field { margin: 10px 0; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <div class="profile-box">
        <div class="left">
            <img src="uploads/<?php echo $user['profile_pic']; ?>" alt="Profile Picture">
            <h3><?php echo $user['full_name']; ?></h3>
            <p><?php echo $user['email']; ?></p>
        </div>
        <div class="right">
            <h2>My Basic Informations & Appearance</h2>
            <div class="field"><span class="label">Marital Status:</span> <?php echo $user['marital_status']; ?></div>
            <div class="field"><span class="label">Date Of Birth:</span> <?php echo $user['dob']; ?></div>
            <div class="field"><span class="label">Height:</span> <?php echo $user['height']; ?></div>
            <div class="field"><span class="label">Children:</span> <?php echo $user['children']; ?></div>
            <div class="field"><span class="label">Zodiac Sign:</span> <?php echo $user['zodiac_sign']; ?></div>
            <div class="field"><span class="label">Eye Color:</span> <?php echo $user['eye_color']; ?></div>
            <div class="field"><span class="label">Complexion:</span> <?php echo $user['complexion']; ?></div>
            <div class="field"><span class="label">Body Type:</span> <?php echo $user['body_type']; ?></div>
            <div class="field"><span class="label">Disabilities:</span> <?php echo $user['disability']; ?></div>
            <div class="field"><span class="label">Blood Group:</span> <?php echo $user['blood_group']; ?></div>
            <div class="field"><span class="label">Hair Color:</span> <?php echo $user['hair_color']; ?></div>
        </div>
        <div style="clear:both;"></div>
    </div>
</body>
</html>