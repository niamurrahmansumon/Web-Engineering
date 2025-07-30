<?php
require_once 'db_config.php';

// Handle form submission (Create/Update)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    try {
        if ($_POST['action'] === 'create' || $_POST['action'] === 'update') {
            $stmt = $conn->prepare("
                " . ($_POST['action'] === 'update' ? "UPDATE" : "INSERT INTO") . " bio_data 
                SET 
                    name = :name, 
                    dob_day = :dob_day, 
                    dob_month = :dob_month, 
                    dob_year = :dob_year, 
                    birth_hour = :birth_hour, 
                    birth_minute = :birth_minute, 
                    birth_ampm = :birth_ampm, 
                    gender = :gender, 
                    birth_place = :birth_place, 
                    height = :height, 
                    complexion = :complexion, 
                    education = :education, 
                    occupation = :occupation, 
                    hobbies = :hobbies, 
                    father_name = :father_name, 
                    mother_name = :mother_name, 
                    father_occupation = :father_occupation, 
                    mother_occupation = :mother_occupation, 
                    brothers = :brothers, 
                    sisters = :sisters, 
                    phone = :phone, 
                    email = :email, 
                    address = :address, 
                    about_me = :about_me,
                    photo = :photo
                " . ($_POST['action'] === 'update' ? "WHERE id = :id" : "") . "
            ");

            // Bind parameters
            $stmt->bindParam(':name', $_POST['name']);
            $stmt->bindParam(':dob_day', $_POST['dob_day']);
            $stmt->bindParam(':dob_month', $_POST['dob_month']);
            $stmt->bindParam(':dob_year', $_POST['dob_year']);
            $stmt->bindParam(':birth_hour', $_POST['birth_hour']);
            $stmt->bindParam(':birth_minute', $_POST['birth_minute']);
            $stmt->bindParam(':birth_ampm', $_POST['birth_ampm']);
            $stmt->bindParam(':gender', $_POST['gender']);
            $stmt->bindParam(':birth_place', $_POST['birth_place']);
            $stmt->bindParam(':height', $_POST['height']);
            $stmt->bindParam(':complexion', $_POST['complexion']);
            $stmt->bindParam(':education', $_POST['education']);
            $stmt->bindParam(':occupation', $_POST['occupation']);
            $stmt->bindParam(':hobbies', $_POST['hobbies']);
            $stmt->bindParam(':father_name', $_POST['father_name']);
            $stmt->bindParam(':mother_name', $_POST['mother_name']);
            $stmt->bindParam(':father_occupation', $_POST['father_occupation']);
            $stmt->bindParam(':mother_occupation', $_POST['mother_occupation']);
            $stmt->bindParam(':brothers', $_POST['brothers']);
            $stmt->bindParam(':sisters', $_POST['sisters']);
            $stmt->bindParam(':phone', $_POST['phone']);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':address', $_POST['address']);
            $stmt->bindParam(':about_me', $_POST['about_me']);

            // Handle photo upload
            $photo = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                $photo = file_get_contents($_FILES['photo']['tmp_name']);
            }
            $stmt->bindParam(':photo', $photo, PDO::PARAM_LOB);

            if ($_POST['action'] === 'update') {
                $stmt->bindParam(':id', $_POST['id']);
            }

            $stmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'Data ' . ($_POST['action'] === 'update' ? 'updated' : 'saved') . ' successfully']);
        } elseif ($_POST['action'] === 'delete') {
            $stmt = $conn->prepare("DELETE FROM bio_data WHERE id = :id");
            $stmt->bindParam(':id', $_POST['id']);
            $stmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'Data deleted successfully']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

// Fetch all records for display (Read)
$records = $conn->query("SELECT id, name, dob_day, dob_month, dob_year, birth_place, height, complexion, education, photo FROM bio_data")->fetchAll(PDO::FETCH_ASSOC);

// Fetch single record for editing
$editRecord = null;
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM bio_data WHERE id = :id");
    $stmt->bindParam(':id', $_GET['edit']);
    $stmt->execute();
    $editRecord = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bio Data Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f8f8 url('https://www.transparenttextures.com/patterns/diamond-upholstery.png');
      padding: 20px;
    }
    .container {
      background: rgba(255, 255, 255, 0.95);
      max-width: 700px;
      margin: auto;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    label {
      display: block;
      font-weight: bold;
      margin-top: 12px;
    }
    input[type="text"],
    input[type="number"],
    input[type="email"],
    textarea,
    select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
      box-sizing: border-box;
    }
    .row {
      display: flex;
      gap: 10px;
      margin-top: 5px;
    }
    .row select, .row input {
      flex: 1;
    }
    textarea {
      resize: vertical;
      min-height: 60px;
    }
    .error {
      color: red;
      font-size: 12px;
      margin-top: 3px;
    }
    .invalid {
      border-color: red !important;
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      background: #1976d2;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover {
      background: #145ca1;
    }
    .photo-upload {
      text-align: center;
      margin-bottom: 15px;
    }
    .photo-preview {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #1976d2;
      display: block;
      margin: auto auto 10px;
      background: #eee;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }
    th {
      background: #1976d2;
      color: #fff;
    }
    .action-btn {
      padding: 5px 10px;
      margin: 0 5px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .edit-btn {
      background: #4caf50;
      color: #fff;
    }
    .delete-btn {
      background: #f44336;
      color: #fff;
    }
    .new-record-btn {
      background: #1976d2;
      color: #fff;
      padding: 10px;
      text-decoration: none;
      border-radius: 4px;
      display: inline-block;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Bio Data Management</h2>

    <!-- Form for Create/Update -->
    <form id="bioForm" enctype="multipart/form-data">
      <input type="hidden" id="action" name="action" value="<?php echo $editRecord ? 'update' : 'create'; ?>">
      <?php if ($editRecord): ?>
        <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($editRecord['id']); ?>">
      <?php endif; ?>

      <div class="photo-upload">
        <img id="photoPreview" class="photo-preview" src="<?php echo $editRecord && $editRecord['photo'] ? 'data:image/jpeg;base64,' . base64_encode($editRecord['photo']) : 'https://via.placeholder.com/100x100?text=Photo'; ?>" alt="Photo Preview">
        <input type="file" id="photoInput" accept="image/*" name="photo">
        <div class="error" id="photoError"></div>
      </div>

      <label>Name *</label>
      <input type="text" id="name" name="name" value="<?php echo $editRecord ? htmlspecialchars($editRecord['name']) : ''; ?>" required>
      <div class="error" id="nameError"></div>

      <label>Date of Birth *</label>
      <div class="row">
        <select id="dob_day" name="dob_day" required>
          <option value="">Day</option>
          <?php for ($i = 1; $i <= 31; $i++): ?>
            <option <?php echo $editRecord && $editRecord['dob_day'] == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
          <?php endfor; ?>
        </select>
        <select id="dob_month" name="dob_month" required>
          <option value="">Month</option>
          <option value="1" <?php echo $editRecord && $editRecord['dob_month'] == 1 ? 'selected' : ''; ?>>January</option>
          <option value="2" <?php echo $editRecord && $editRecord['dob_month'] == 2 ? 'selected' : ''; ?>>February</option>
          <option value="3" <?php echo $editRecord && $editRecord['dob_month'] == 3 ? 'selected' : ''; ?>>March</option>
          <option value="4" <?php echo $editRecord && $editRecord['dob_month'] == 4 ? 'selected' : ''; ?>>April</option>
          <option value="5" <?php echo $editRecord && $editRecord['dob_month'] == 5 ? 'selected' : ''; ?>>May</option>
          <option value="6" <?php echo $editRecord && $editRecord['dob_month'] == 6 ? 'selected' : ''; ?>>June</option>
          <option value="7" <?php echo $editRecord && $editRecord['dob_month'] == 7 ? 'selected' : ''; ?>>July</option>
          <option value="8" <?php echo $editRecord && $editRecord['dob_month'] == 8 ? 'selected' : ''; ?>>August</option>
          <option value="9" <?php echo $editRecord && $editRecord['dob_month'] == 9 ? 'selected' : ''; ?>>September</option>
          <option value="10" <?php echo $editRecord && $editRecord['dob_month'] == 10 ? 'selected' : ''; ?>>October</option>
          <option value="11" <?php echo $editRecord && $editRecord['dob_month'] == 11 ? 'selected' : ''; ?>>November</option>
          <option value="12" <?php echo $editRecord && $editRecord['dob_month'] == 12 ? 'selected' : ''; ?>>December</option>
        </select>
        <input type="number" id="dob_year" name="dob_year" placeholder="Year" value="<?php echo $editRecord ? htmlspecialchars($editRecord['dob_year']) : ''; ?>" required>
      </div>
      <div class="error" id="dobError"></div>

      <label>Time of Birth</label>
      <div class="row">
        <select id="birth_hour" name="birth_hour">
          <option value="">Hour</option>
          <?php for ($i = 1; $i <= 12; $i++): ?>
            <option <?php echo $editRecord && $editRecord['birth_hour'] == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
          <?php endfor; ?>
        </select>
        <select id="birth_minute" name="birth_minute">
          <option value="">Minute</option>
          <?php for ($i = 0; $i < 60; $i++): ?>
            <option <?php echo $editRecord && $editRecord['birth_minute'] == sprintf("%02d", $i) ? 'selected' : ''; ?>><?php echo sprintf("%02d", $i); ?></option>
          <?php endfor; ?>
        </select>
        <select id="birth_ampm" name="birth_ampm">
          <option value="">AM/PM</option>
          <option <?php echo $editRecord && $editRecord['birth_ampm'] == 'AM' ? 'selected' : ''; ?>>AM</option>
          <option <?php echo $editRecord && $editRecord['birth_ampm'] == 'PM' ? 'selected' : ''; ?>>PM</option>
        </select>
      </div>
      <div class="error" id="birthTimeError"></div>

      <label>Gender</label>
      <select id="gender" name="gender">
        <option value="">Select</option>
        <option <?php echo $editRecord && $editRecord['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
        <option <?php echo $editRecord && $editRecord['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
        <option <?php echo $editRecord && $editRecord['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
      </select>
      <div class="error" id="genderError"></div>

      <label>Birth Place *</label>
      <input type="text" id="birth_place" name="birth_place" value="<?php echo $editRecord ? htmlspecialchars($editRecord['birth_place']) : ''; ?>" required>
      <div class="error" id="birthPlaceError"></div>

      <label>Height *</label>
      <input type="text" id="height" name="height" placeholder="e.g. 170 cm" value="<?php echo $editRecord ? htmlspecialchars($editRecord['height']) : ''; ?>" required>
      <div class="error" id="heightError"></div>

      <label>Complexion *</label>
      <input type="text" id="complexion" name="complexion" value="<?php echo $editRecord ? htmlspecialchars($editRecord['complexion']) : ''; ?>" required>
      <div class="error" id="complexionError"></div>

      <label>Education *</label>
      <input type="text" id="education" name="education" value="<?php echo $editRecord ? htmlspecialchars($editRecord['education']) : ''; ?>" required>
      <div class="error" id="educationError"></div>

      <label>Occupation</label>
      <input type="text" id="occupation" name="occupation" value="<?php echo $editRecord ? htmlspecialchars($editRecord['occupation']) : ''; ?>">
      <div class="error" id="occupationError"></div>

      <label>Hobbies</label>
      <input type="text" id="hobbies" name="hobbies" value="<?php echo $editRecord ? htmlspecialchars($editRecord['hobbies']) : ''; ?>">
      <div class="error" id="hobbiesError"></div>

      <label>Father Name</label>
      <input type="text" id="father_name" name="father_name" value="<?php echo $editRecord ? htmlspecialchars($editRecord['father_name']) : ''; ?>">
      <div class="error" id="fatherError"></div>

      <label>Mother Name</label>
      <input type="text" id="mother_name" name="mother_name" value="<?php echo $editRecord ? htmlspecialchars($editRecord['mother_name']) : ''; ?>">
      <div class="error" id="motherError"></div>

      <label>Father Occupation</label>
      <input type="text" id="father_occupation" name="father_occupation" value="<?php echo $editRecord ? htmlspecialchars($editRecord['father_occupation']) : ''; ?>">
      <div class="error" id="fatherOccupationError"></div>

      <label>Mother Occupation</label>
      <input type="text" id="mother_occupation" name="mother_occupation" value="<?php echo $editRecord ? htmlspecialchars($editRecord['mother_occupation']) : ''; ?>">
      <div class="error" id="motherOccupationError"></div>

      <label>Brother(s)</label>
      <input type="text" id="brothers" name="brothers" value="<?php echo $editRecord ? htmlspecialchars($editRecord['brothers']) : ''; ?>">
      <div class="error" id="brothersError"></div>

      <label>Sister(s)</label>
      <input type="text" id="sisters" name="sisters" value="<?php echo $editRecord ? htmlspecialchars($editRecord['sisters']) : ''; ?>">
      <div class="error" id="sistersError"></div>

      <label>Phone</label>
      <input type="text" id="phone" name="phone" value="<?php echo $editRecord ? htmlspecialchars($editRecord['phone']) : ''; ?>">
      <div class="error" id="phoneError"></div>

      <label>Email</label>
      <input type="email" id="email" name="email" value="<?php echo $editRecord ? htmlspecialchars($editRecord['email']) : ''; ?>">
      <div class="error" id="emailError"></div>

      <label>Address</label>
      <input type="text" id="address" name="address" value="<?php echo $editRecord ? htmlspecialchars($editRecord['address']) : ''; ?>">
      <div class="error" id="addressError"></div>

      <label>About Me</label>
      <textarea id="about_me" name="about_me"><?php echo $editRecord ? htmlspecialchars($editRecord['about_me']) : ''; ?></textarea>
      <div class="error" id="aboutMeError"></div>

      <button type="submit"><?php echo $editRecord ? 'Update' : 'Submit'; ?></button>
    </form>

    <!-- Records Table -->
    <a href="index.php" class="new-record-btn">Add New Record</a>
    <table>
      <thead>
        <tr>
          <th>Photo</th>
          <th>Name</th>
          <th>Date of Birth</th>
          <th>Birth Place</th>
          <th>Height</th>
          <th>Complexion</th>
          <th>Education</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($records as $record): ?>
          <tr>
            <td><img src="<?php echo $record['photo'] ? 'data:image/jpeg;base64,' . base64_encode($record['photo']) : 'https://via.placeholder.com/50x50?text=No+Photo'; ?>" width="50" height="50" style="border-radius: 50%;"></td>
            <td><?php echo htmlspecialchars($record['name']); ?></td>
            <td><?php echo htmlspecialchars($record['dob_day'] . '/' . $record['dob_month'] . '/' . $record['dob_year']); ?></td>
            <td><?php echo htmlspecialchars($record['birth_place']); ?></td>
            <td><?php echo htmlspecialchars($record['height']); ?></td>
            <td><?php echo htmlspecialchars($record['complexion']); ?></td>
            <td><?php echo htmlspecialchars($record['education']); ?></td>
            <td>
              <button class="action-btn edit-btn" onclick="window.location.href='index.php?edit=<?php echo $record['id']; ?>'">Edit</button>
              <button class="action-btn delete-btn" onclick="deleteRecord(<?php echo $record['id']; ?>)">Delete</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

<script>
function sanitizeInput(input) {
  const div = document.createElement('div');
  div.textContent = input;
  return div.innerHTML;
}

function isValidDate(day, month, year) {
  const d = parseInt(day), m = parseInt(month), y = parseInt(year);
  if (isNaN(d) || isNaN(m) || isNaN(y)) return false;
  if (y < 1900 || y > new Date().getFullYear()) return false;
  const date = new Date(y, m - 1, d);
  return date.getDate() === d && date.getMonth() === m - 1 && date.getFullYear() === y;
}

function validateField(field, regex, errorElement, errorMessage, isRequired = false) {
  const value = field.value.trim();
  if (isRequired && value === "") {
    field.classList.add("invalid");
    errorElement.textContent = errorMessage || "This field is required.";
    return false;
  }
  if (value !== "" && regex && !regex.test(value)) {
    field.classList.add("invalid");
    errorElement.textContent = errorMessage;
    return false;
  }
  field.classList.remove("invalid");
  errorElement.textContent = "";
  return true;
}

const photoInput = document.getElementById("photoInput");
const photoPreview = document.getElementById("photoPreview");
const photoError = document.getElementById("photoError");

photoInput.addEventListener("change", function() {
  const file = this.files[0];
  if (!file) {
    photoError.textContent = "Please upload a photo.";
    return;
  }
  if (!file.type.startsWith("image/")) {
    photoError.textContent = "Only image files (JPEG, PNG, etc.) are allowed.";
    this.value = "";
    return;
  }
  if (file.size > 2 * 1024 * 1024) {
    photoError.textContent = "Image must be less than 2MB.";
    this.value = "";
    return;
  }
  const reader = new FileReader();
  reader.onload = e => {
    photoPreview.src = e.target.result;
    photoError.textContent = "";
  };
  reader.readAsDataURL(file);
});

const form = document.getElementById("bioForm");
const fields = [
  { id: "name", regex: /^[A-Za-z\s]{2,50}$/, errorId: "nameError", message: "Name must be 2-50 letters only.", required: true },
  { id: "birth_place", regex: /^[A-Za-z\s,]{2,100}$/, errorId: "birthPlaceError", message: "Birth place must be 2-100 letters, spaces, or commas.", required: true },
  { id: "height", regex: /^[0-9]{2,3}(\s?cm)?$/i, errorId: "heightError", message: "Height must be a number (e.g., 170 or 170 cm).", required: true },
  { id: "complexion", regex: /^[A-Za-z\s]{2,20}$/, errorId: "complexionError", message: "Complexion must be 2-20 letters only.", required: true },
  { id: "education", regex: /^[A-Za-z0-9\s,.]{2,100}$/, errorId: "educationError", message: "Education must be 2-100 letters, numbers, spaces, or punctuation.", required: true },
  { id: "occupation", regex: /^[A-Za-z0-9\s,.]{0,100}$/, errorId: "occupationError", message: "Occupation must be 0-100 letters, numbers, spaces, or punctuation." },
  { id: "hobbies", regex: /^[A-Za-z0-9\s,.]{0,200}$/, errorId: "hobbiesError", message: "Hobbies must be 0-200 letters, numbers, spaces, or punctuation." },
  { id: "father_name", regex: /^[A-Za-z\s]{0,50}$/, errorId: "fatherError", message: "Father's name must be 0-50 letters only." },
  { id: "mother_name", regex: /^[A-Za-z\s]{0,50}$/, errorId: "motherError", message: "Mother's name must be 0-50 letters only." },
  { id: "father_occupation", regex: /^[A-Za-z0-9\s,.]{0,100}$/, errorId: "fatherOccupationError", message: "Father's occupation must be 0-100 letters, numbers, spaces, or punctuation." },
  { id: "mother_occupation", regex: /^[A-Za-z0-9\s,.]{0,100}$/, errorId: "motherOccupationError", message: "Mother's occupation must be 0-100 letters, numbers, spaces, or punctuation." },
  { id: "brothers", regex: /^[0-9]{0,2}$/, errorId: "brothersError", message: "Number of brothers must be a number (0-99)." },
  { id: "sisters", regex: /^[0-9]{0,2}$/, errorId: "sistersError", message: "Number of sisters must be a number (0-99)." },
  { id: "phone", regex: /^[0-9]{6,15}$/, errorId: "phoneError", message: "Phone must be 6-15 digits." },
  { id: "email", regex: /^[^@\s]+@[^@\s]+\.[^@\s]+$/, errorId: "emailError", message: "Invalid email format." },
  { id: "address", regex: /^[A-Za-z0-9\s,.#]{0,200}$/, errorId: "addressError", message: "Address must be 0-200 letters, numbers, spaces, or punctuation." },
  { id: "about_me", regex: /^[A-Za-z0-9\s,.!?]{0,500}$/, errorId: "aboutMeError", message: "About Me must be 0-500 letters, numbers, spaces, or punctuation." }
];

fields.forEach(field => {
  const element = document.getElementById(field.id);
  element.addEventListener("input", () => {
    validateField(
      element,
      field.regex,
      document.getElementById(field.errorId),
      field.message,
      field.required
    );
  });
});

form.addEventListener("submit", function(e) {
  e.preventDefault();
  let valid = true;

  if (!photoInput.files[0] && document.getElementById("action").value === "create") {
    valid = false;
    photoError.textContent = "Please upload a photo.";
  } else {
    photoError.textContent = "";
  }

  const dobDay = document.getElementById("dob_day").value;
  const dobMonth = document.getElementById("dob_month").value;
  const dobYear = document.getElementById("dob_year").value;
  const dobError = document.getElementById("dobError");
  if (!dobDay || !dobMonth || !dobYear || !isValidDate(dobDay, dobMonth, dobYear)) {
    valid = false;
    dobError.textContent = "Please select a valid date of birth.";
    document.getElementById("dob_day").classList.add("invalid");
    document.getElementById("dob_month").classList.add("invalid");
    document.getElementById("dob_year").classList.add("invalid");
  } else {
    dobError.textContent = "";
    document.getElementById("dob_day").classList.remove("invalid");
    document.getElementById("dob_month").classList.remove("invalid");
    document.getElementById("dob_year").classList.remove("invalid");
  }

  const birthHour = document.getElementById("birth_hour").value;
  const birthMinute = document.getElementById("birth_minute").value;
  const birthAmPm = document.getElementById("birth_ampm").value;
  const birthTimeError = document.getElementById("birthTimeError");
  if ((birthHour || birthMinute || birthAmPm) && (!birthHour || !birthMinute || !birthAmPm)) {
    valid = false;
    birthTimeError.textContent = "Please complete all time of birth fields or leave them all empty.";
    document.getElementById("birth_hour").classList.add("invalid");
    document.getElementById("birth_minute").classList.add("invalid");
    document.getElementById("birth_ampm").classList.add("invalid");
  } else {
    birthTimeError.textContent = "";
    document.getElementById("birth_hour").classList.remove("invalid");
    document.getElementById("birth_minute").classList.remove("invalid");
    document.getElementById("birth_ampm").classList.remove("invalid");
  }

  const gender = document.getElementById("gender");
  const genderError = document.getElementById("genderError");
  if (gender.value !== "" && !["Male", "Female", "Other"].includes(gender.value)) {
    valid = false;
    gender.classList.add("invalid");
    genderError.textContent = "Please select a valid gender.";
  } else {
    gender.classList.remove("invalid");
    genderError.textContent = "";
  }

  fields.forEach(field => {
    const element = document.getElementById(field.id);
    if (!validateField(
      element,
      field.regex,
      document.getElementById(field.errorId),
      field.message,
      field.required
    )) {
      valid = false;
    }
  });

  if (valid) {
    const formData = new FormData(form);
    formData.append("photo", photoInput.files[0]);

    fetch('', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        alert(data.message);
        window.location.href = 'index.php'; // Refresh to show updated table
      } else {
        alert(data.message);
      }
    })
    .catch(error => {
      alert("An error occurred: " + error.message);
    });
  } else {
    alert("Please fix the highlighted errors before submitting.");
  }
});

function deleteRecord(id) {
  if (confirm("Are you sure you want to delete this record?")) {
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('id', id);

    fetch('', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        alert(data.message);
        window.location.href = 'index.php'; // Refresh to update table
      } else {
        alert(data.message);
      }
    })
    .catch(error => {
      alert("An error occurred: " + error.message);
    });
  }
}
</script>
</body>
</html>