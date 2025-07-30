<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "sumon";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("DB Connection Failed: ".$conn->connect_error);

$id = intval($_GET['id'] ?? 0);
$res = $conn->query("SELECT * FROM bio_data WHERE id=$id");
if(!$res || $res->num_rows==0) die("Record not found!");
$row = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name        = $_POST['name'];
    $fatherName  = $_POST['fatherName'];
    $motherName  = $_POST['motherName'];
    $qualification = $_POST['qualification'];
    $weight      = $_POST['weight'];
    $dob         = $_POST['dob'];
    $height      = $_POST['height'];
    $gender      = $_POST['gender'];
    $password    = $_POST['password']; // plain password

    // keep old photo unless updated
    $photoPath = $row['photo'];
    if (!empty($_FILES['photoInput']['name'])) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir,0777,true);
        $fileName = time()."_".basename($_FILES['photoInput']['name']);
        $targetPath = $uploadDir.$fileName;
        if(move_uploaded_file($_FILES['photoInput']['tmp_name'],$targetPath)){
            $photoPath = $targetPath;
        }
    }

    $stmt = $conn->prepare("UPDATE bio_data SET photo=?, name=?, father_name=?, mother_name=?, qualification=?, weight=?, dob=?, height=?, gender=?, password=? WHERE id=?");
    $stmt->bind_param(
        "sssssdssssi",
        $photoPath,
        $name,
        $fatherName,
        $motherName,
        $qualification,
        $weight,
        $dob,
        $height,
        $gender,
        $password,
        $id
    );

    if($stmt->execute()){
        echo "<script>alert('Updated successfully!'); window.location='view_bio.php';</script>";
        exit;
    } else {
        echo "Update Failed: ".$conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Bio</title>
  <style>
    body { font-family: Arial; background:#f4f4f4; padding:20px; }
    form { background:#fff; padding:20px; max-width:400px; margin:auto; border-radius:6px; }
    input, select { width:100%; padding:8px; margin-bottom:10px; }
    button { padding:10px 20px; background:#1976d2; color:#fff; border:none; border-radius:4px; }
  </style>
</head>
<body>

<h2>Edit Bio Data</h2>
<form method="POST" enctype="multipart/form-data">
  <p><img src="<?= $row['photo'] ?>" width="80" alt=""></p>
  <label>Change Photo:</label>
  <input type="file" name="photoInput">

  <label>Name:</label>
  <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>

  <label>Father Name:</label>
  <input type="text" name="fatherName" value="<?= htmlspecialchars($row['father_name']) ?>" required>

  <label>Mother Name:</label>
  <input type="text" name="motherName" value="<?= htmlspecialchars($row['mother_name']) ?>" required>

  <label>Qualification:</label>
  <input type="text" name="qualification" value="<?= htmlspecialchars($row['qualification']) ?>" required>

  <label>Weight (kg):</label>
  <input type="number" name="weight" value="<?= $row['weight'] ?>" step="0.1" required>

  <label>DOB:</label>
  <input type="date" name="dob" value="<?= $row['dob'] ?>" required>

  <label>Height:</label>
  <select name="height" required>
    <option value="">Select</option>
    <?php foreach([150,155,160,165,170,175,180] as $h): ?>
      <option value="<?= $h ?>" <?= $row['height']==$h?'selected':'' ?>><?= $h ?> cm</option>
    <?php endforeach; ?>
  </select>

  <label>Gender:</label>
  <select name="gender" required>
    <option value="Male" <?= $row['gender']=="Male"?'selected':'' ?>>Male</option>
    <option value="Female" <?= $row['gender']=="Female"?'selected':'' ?>>Female</option>
    <option value="Other" <?= $row['gender']=="Other"?'selected':'' ?>>Other</option>
  </select>

  <label>Password:</label>
  <input type="text" name="password" value="<?= htmlspecialchars($row['password']) ?>" required>

  <button type="submit">Update</button>
  <a href="view_bio.php">Cancel</a>
</form>
</body>
</html>