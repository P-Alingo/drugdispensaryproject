<?php
require_once("connection.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the appointment ID and updated details from the form
  $appointmentID = $_POST['appointmentID'];
  $appointmentDate = $_POST['appointmentDate'];
  $appointmentTime = $_POST['appointmentTime'];
  $appointmentPurpose = $_POST['appointmentPurpose'];

  // Update the appointment details in the database
  $updateQuery = "UPDATE appointment SET appointment_date='$appointmentDate', appointment_time='$appointmentTime', appointment_purpose='$appointmentPurpose' WHERE appointment_id='$appointmentID'";

  if ($conn->query($updateQuery) === TRUE) {
    // Redirect back to patient_view_appointments.php
    header("Location: patient_view_appointments.php");
    exit();
  } else {
    echo "Error updating appointment: " . $conn->error;
  }
} else {
  echo "Invalid request.";
}

$conn->close();
?>
