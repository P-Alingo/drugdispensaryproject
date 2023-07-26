<?php
require_once("connection.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the appointment ID from the form
  $appointmentID = $_POST['appointmentID'];

  // Delete the appointment from the database
  $deleteQuery = "DELETE FROM appointment WHERE appointment_id='$appointmentID'";
  
  if ($conn->query($deleteQuery) === TRUE) {
    // Redirect the user to the view appointments page
    header("Location: patient_view_appointments.php");
    exit();
  } else {
    echo "Error deleting appointment: " . $conn->error;
  }
}

$conn->close();
?>
