<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the appointment ID from the form
  $appointmentID = $_POST['appointment_id'];
  $fullName = $_SESSION['full_name'];

  // Retrieve the appointment details from the database
  $appointmentQuery = "SELECT * FROM appointment WHERE appointment_id='$appointmentID'";
  $appointmentResult = $conn->query($appointmentQuery);

  if ($appointmentResult->num_rows > 0) {
    // Fetch the appointment details
    $appointmentRow = $appointmentResult->fetch_assoc();
    $appointmentDate = $appointmentRow['appointment_date'];
    $appointmentTime = $appointmentRow['appointment_time'];
    $patientSSN = $appointmentRow['patient_SSN'];

    // Retrieve the patient's details from the database
    $patientQuery = "SELECT * FROM patient WHERE SSN='$patientSSN'";
    $patientResult = $conn->query($patientQuery);

    if ($patientResult->num_rows > 0) {
      echo "<div class='user-info'>";
      echo "<h2>$fullName</h2>";
      echo "</div>";
      // Fetch the patient's detail
      $patientRow = $patientResult->fetch_assoc();
      $patientFullName = $patientRow['full_name'];

      // Display the edit appointment form
      echo "<h1>Edit Appointment</h1>";
      echo "<form method='POST' action='doctor_update_appointment.php'>";
      echo "<input type='hidden' name='appointment_id' value='$appointmentID'>";

      echo "<div class='input-field'>";
      echo "<label for='patient'>Patient:</label>";
      echo "<input type='text' id='patient' name='patient' value='$patientFullName' readonly>";
      echo "</div>";

      echo "<div class='input-field'>";
      echo "<label for='date'>Date:</label>";
      echo "<input type='date' id='date' name='date' value='$appointmentDate' required>";
      echo "</div>";

      echo "<div class='input-field'>";
      echo "<label for='time'>Time:</label>";
      echo "<input type='time' id='time' name='time' value='$appointmentTime' required>";
      echo "</div>";

      echo "<div class='input-buttons'>";
      echo "<input type='submit' value='Update Appointment'>";
      echo "<button class='back-button' onclick='goBack()'>Back</button>";
      echo "</div>";

      echo "</form>";

      echo "<script>";
      echo "function goBack() {";
      echo "  window.location.href = 'doctor_view_appointments.php';";
      echo "}";
      echo "</script>";
    } else {
      echo "Patient not found.";
    }
  } else {
    echo "Appointment not found.";
  }
} else {
  echo "Invalid request.";
}

$conn->close();
?>

<style>
.user-info {
  text-align: center;
  margin-bottom: 20px;
}

.user-info h2 {
  color: #333;
}

body {
  background-image: url('doctorappointment.webp');
  background-size: cover;
  background-position: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  /* Align items horizontally at the center */
  justify-content: center;
  /* Align items vertically at the center */
  height: 100vh;
  margin: 0;
}

h1 {
  text-align: center;
  color: #333;
  margin-bottom: 10px;
}

form {
  /* Add styles to center the form and set a maximum width */
  max-width: 400px;
  margin: 0 auto;
}

label {
  display: inline-block;
  width: 100px; /* Set a fixed width for the labels */
  margin-bottom: 5px;
  font-weight: bold;
  color: #333;
}

.input-field {
  margin-bottom: 10px;
}

.input-buttons {
  /* Add styles to display buttons in a row */
  display: flex;
  justify-content: space-between; /* Space buttons evenly */
  align-items: center; /* Align items vertically in the center */
}

/* Adjust button styles */
input[type="submit"],
button {
  padding: 8px 12px;
  background-color: #333;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  flex: 1; /* Let both buttons take equal space */
  margin: 5px; /* Add margin between buttons */
}

input[type="submit"]:hover,
button:hover {
  background-color: #555;
}

.back-button {
  padding: 8px 12px; /* Set the same padding as the other button */
}
</style>
