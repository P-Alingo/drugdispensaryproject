<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the patient's email from the session
  $email = $_SESSION['email'];

  // Check if the form is submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted form data
    $patientSSN = $_POST['patient_SSN'];
    $patientFullName = $_POST['patient_full_name'];
    $details = $_POST['details'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Check if the reminder ID is provided
    if (isset($_POST['reminder_id'])) {
      $reminderID = $_POST['reminder_id'];

      // Update the reminder in the database
      $updateQuery = "UPDATE reminder SET patient_SSN = '$patientSSN', patient_full_name = '$patientFullName', details = '$details', date = '$date', time = '$time' WHERE reminder_id = '$reminderID'";
      $updateResult = $conn->query($updateQuery);

      if ($updateResult === true) {
        echo "Reminder updated successfully.";
      } else {
        echo "Error updating reminder: " . $conn->error;
      }
    } else {
      echo "Invalid request.";
    }
  }

  $conn->close();
}
?>


