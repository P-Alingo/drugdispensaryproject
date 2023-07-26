<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the patient's email from the session
  $email = $_SESSION['email'];

  // Retrieve the patient's details from the database
  $query = "SELECT * FROM patient WHERE email='$email'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    // Retrieve the patient's full name from the database
    $row = $result->fetch_assoc();
    $full_name = $row['full_name'];
  } else {
    // If the patient's details are not found, redirect to the login page
    header("Location: patient_login.php");
    exit();
  }
} else {
  // If the 'email' key is not set in the session, redirect to the login page
  header("Location: patient_login.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Patient Page</title>
  <style>
    body {
      display: flex;
      flex-direction: column;
      align-items: center; /* Center horizontally */
      justify-content: flex-start; /* Align at the top */
      text-align: center;
      padding-top: 50px; /* Reduce the padding to move the name to the top */
      margin: 0;
      padding: 20px;
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      animation: slideshow 10s linear infinite;
      background-size: cover; /* Add this line to make the background images fit the screen */
    }
    
    h1 {
      color: #333;
      margin-bottom: 30px;
    }
    
    .button {
      display: block;
      padding: 10px 20px;
      width: 150px; /* Set a fixed width for the buttons */
      font-size: 18px;
      background-color: #18448f; /* Set the background color to dark blue */
      color: white;
      border: none;
      border-radius: 4px;
      text-decoration: none;
      margin-right: 10px;
      margin-bottom: 20px; /* Add margin at the bottom to create space between buttons */
      cursor: pointer;
    }
    
    .button:hover {
      background-color: #123768; /* Darken the color on hover */
    }

    .user-info {
      font-size: 60px; /* Set the font size to 70 */
      font-weight: bold;
      color: #333;
    }

    @keyframes slideshow {
      0%, 100% {
        background-image: url('patient.jpg');
      }
      50% {
        background-image: url('patient3.webp');
      }
    }
  </style>
</head>
<body>
  <div class="user-info">
    Welcome, <?php echo $full_name; ?>!
  </div>
  
  <a href="Patient_profile.php" class="button">Profile</a>
  <a href="patient_appointment.php" class="button">Appointments</a>
  <a href="Patient_prescription.php" class="button">Prescription</a> 
  <a href="Patient_reminder.php" class="button">Set Reminder</a>
  <a href="project.html" class="button">Log Out</a>
</body>
</html>
