<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the doctor's email from the session
  $email = $_SESSION['email'];

  // Retrieve the doctor's details from the database
  $doctorQuery = "SELECT * FROM doctor WHERE email='$email'";
  $doctorResult = $conn->query($doctorQuery);

  if ($doctorResult->num_rows > 0) {
    // Fetch the doctor's details
    $doctorRow = $doctorResult->fetch_assoc();
    $doctorSSN = $doctorRow['SSN']; // Retrieve the doctor's SSN

    // Check if the prescription ID is provided
    if (isset($_GET['prescription_id'])) {
      $prescriptionID = $_GET['prescription_id'];

      // Retrieve the prescription details from the database
      $prescriptionQuery = "SELECT * FROM Prescription WHERE prescription_id='$prescriptionID' AND doctor_SSN='$doctorSSN'";
      $prescriptionResult = $conn->query($prescriptionQuery);

      if ($prescriptionResult->num_rows > 0) {
        // Fetch the prescription details
        $prescriptionRow = $prescriptionResult->fetch_assoc();
        $patientSSN = $prescriptionRow['SSN'];
        $traceName = $prescriptionRow['trace_name'];
        $date = $prescriptionRow['date'];
        $quantity = $prescriptionRow['quantity'];

        // Display the prescription form for editing
        echo "<h1>Edit Prescription</h1>";
        echo "<form method='post' action='doctor_update_prescription.php'>";
        echo "<input type='hidden' name='prescription_id' value='$prescriptionID'>";
        echo "<label for='patient'>Patient SSN:</label>";
        echo "<input type='text' name='patient' id='patient' value='$patientSSN' readonly>";
        echo "<br>";
        echo "<label for='trace_name'>Trace Name:</label>";
        echo "<input type='text' name='trace_name' id='trace_name' value='$traceName' required>";
        echo "<br>";
        echo "<label for='date'>Date:</label>";
        echo "<input type='date' name='date' id='date' value='$date' required>";
        echo "<br>";
        echo "<label for='quantity'>Quantity:</label>";
        echo "<input type='text' name='quantity' id='quantity' value='$quantity' required>";
        echo "<br>";
        echo "<input type='submit' value='Update'>";
        echo "</form>";

        // Back button
        echo "<button onclick='goBack()'>Back</button>";
        echo "<script>";
        echo "function goBack() {";
        echo "  window.location.href = 'Doctor_prescription.php';";
        echo "}";
        echo "</script>";
      } else {
        echo "Prescription not found.";
      }
    } else {
      echo "Prescription ID not provided.";
    }
  } else {
    echo "Doctor not found.";
  }
} else {
  echo "Invalid session. Please login again.";
}

$conn->close();
?>
