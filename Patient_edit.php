<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the patient's email from the session
  $sessionEmail = $_SESSION['email'];
  $fullName = $_SESSION['full_name'];

  // Retrieve the patient's information from the database using their email
  $patientQuery = "SELECT * FROM patient WHERE email='$sessionEmail'";
  $patientResult = $conn->query($patientQuery);

  if ($patientResult->num_rows > 0) {
    // Fetch the patient's information
    $patientRow = $patientResult->fetch_assoc();
    $fullName = $patientRow['full_name'];
    $gender = $patientRow['gender'];
    $email = $patientRow['email'];
    $password = $patientRow['PASSWORD'];
    $dateOfBirth = $patientRow['date_of_birth'];
    $age = $patientRow['age'];
    $phoneNumber = $patientRow['phone_number'];
    $address = $patientRow['address'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Patient Information</title>
  <style>
    body {
      background-image: url('patientprofile2.jpg'); /* Add the image as the background */
      background-size: cover; /* Make the image fit the screen */
      background-position: center; /* Center the background image */
      display: flex;
      flex-direction: column;
      align-items: center; /* Center content horizontally */
      justify-content: center; /* Center the content vertically */
      height: 100vh; /* Set the height of the body to fill the viewport */
    }

    h1 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    form {
      margin-top: 20px;
      background-color: rgba(255, 255, 255, 0.7); /* Add a semi-transparent background for better readability */
      padding: 40px;
      border-radius: 8px;
      max-width: 900px; /* Increased width to 900px */
      /* Adjust the margin to center the form horizontally */
      margin: 20px auto;
    }

    /* Adjust the styles for text fields to make them wider */
    input[type='text'],
    input[type='email'],
    input[type='password'],
    input[type='date'],
    input[type='number'],
    input[type='tel'],
    textarea {
      width: 100%; /* Make the text fields 100% wide */
      padding: 12px; /* Increase the padding for better appearance */
      border-radius: 4px;
      border: 1px solid #ccc;
      margin-bottom: 10px;
      box-sizing: border-box; /* Include padding and border in the width calculation */
    }
    
    input[type='submit'] {
      padding: 8px 16px;
      background-color: darkblue; /* Updated color */
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button {
      display: inline-block;
      padding: 8px 16px;
      background-color: darkblue; /* Updated color */
      color: white;
      text-decoration: none;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-right: 10px;
    }

    button a {
      color: white;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <h1>Edit Patient Information</h1>
  <div style='text-align: center; font-size: 45px; margin-bottom: 20px;'> 
    Welcome, <?php echo $fullName; ?>!
  </div>
  <form method='POST' action='patient_update.php'>
    <label for='fullName'>Full Name:</label>
    <div class='content-container'>
      <input type='text' id='fullName' name='fullName' value='<?php echo $fullName; ?>' required><br>
      <label for='gender'>Gender:</label>
      <select id='gender' name='gender' required>
        <option value='Male' <?php echo ($gender === 'Male') ? 'selected' : ''; ?>>Male</option>
        <option value='Female' <?php echo ($gender === 'Female') ? 'selected' : ''; ?>>Female</option>
      </select><br>
      <label for='email'>Email:</label>
      <input type='email' id='email' name='email' value='<?php echo $email; ?>' required><br>
      <label for='password'>Password:</label>
      <input type='password' id='password' name='password' value='<?php echo $password; ?>' required><br>
      <label for='dateOfBirth'>Date of Birth:</label>
      <input type='date' id='dateOfBirth' name='dateOfBirth' value='<?php echo $dateOfBirth; ?>' required><br>
      <label for='age'>Age:</label>
      <input type='number' id='age' name='age' value='<?php echo $age; ?>' required><br>
      <label for='phoneNumber'>Phone Number:</label>
      <input type='tel' id='phoneNumber' name='phoneNumber' value='<?php echo $phoneNumber; ?>' required><br>
      <label for='address'>Address:</label>
      <textarea id='address' name='address' required><?php echo $address; ?></textarea><br>
      <input type='submit' value='Update Information'>
      <button><a href='Patient_profile.php'>Back</a></button>
    </div>
  </form>
</body>
</html>

<?php
    } else {
      echo "Patient not found.";
    }
} else {
  echo "Invalid session. Please login again.";
}

$conn->close();
?>

