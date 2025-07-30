<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "sumon";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("DB Connection Failed: " . $conn->connect_error);

$result = $conn->query("SELECT * FROM bio_data ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>All Bio Data</title>
  <style>
    body { font-family: Arial; padding: 20px; background: #f4f4f4; }
    table { width: 100%; border-collapse: collapse; background: #fff; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
    th { background: #1976d2; color: #fff; }
    img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; }
    .btn { padding: 6px 12px; text-decoration: none; color: #fff; border-radius: 4px; }
    .edit { background: #4caf50; }
    .delete { background: #f44336; }
    .add { background: #1976d2; margin-bottom: 10px; display: inline-block; }
  </style>
</head>
<body>

<h2>All Bio Data Records</h2>
<a class="btn add" href="index.html">+ Add New Record</a>

<table>
  <tr>
    <th>ID</th>
    <th>Photo</th>
    <th>Name</th>
    <th>Father</th>
    <th>Mother</th>
    <th>Qualification</th>
    <th>Weight</th>
    <th>DOB</th>
    <th>Height</th>
    <th>Gender</th>
    <th>Password</th>
    <th>Actions</th>
  </tr>
<?php while($row = $result->fetch_assoc()): ?>
  <tr>
    <td><?= $row['id'] ?></td>
    <td>
      <?php if($row['photo']): ?>
        <img src="<?= $row['photo'] ?>" alt="Photo">
      <?php else: ?>
        No Photo
      <?php endif; ?>
    </td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['father_name']) ?></td>
    <td><?= htmlspecialchars($row['mother_name']) ?></td>
    <td><?= htmlspecialchars($row['qualification']) ?></td>
    <td><?= $row['weight'] ?> kg</td>
    <td><?= $row['dob'] ?></td>
    <td><?= $row['height'] ?> cm</td>
    <td><?= $row['gender'] ?></td>
    <td><?= htmlspecialchars($row['password']) ?></td>
    <td>
      <a class="btn edit" href="edit_bio.php?id=<?= $row['id'] ?>">Edit</a>
      <a class="btn delete" href="delete_bio.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this record?')">Delete</a>
    </td>
  </tr>
<?php endwhile; ?>
</table>

</body>
</html>
<?php $conn->close(); ?>