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

  // Check if the 'full_name' column exists in the patient table
  if ($result !== false && $result->num_rows > 0 && isset($result->fetch_assoc()['full_name'])) {
    $result->data_seek(0); // Reset the result pointer to the beginning

    $row = $result->fetch_assoc();
    $full_name = $row['full_name'];

    // Retrieve the patient's prescription from the Prescription table
    $prescriptionQuery = "SELECT * FROM prescription WHERE patient_SSN='" . $row['SSN'] . "'";
    $prescriptionResult = $conn->query($prescriptionQuery);

    if ($prescriptionResult !== false && $prescriptionResult->num_rows > 0) {
      // Welcome message
      echo "<div class='user-info'>";
      echo "Welcome, $full_name!";
      echo "</div>";

      // Display the prescription details
      echo "<h1>Patient Prescription</h1>";
      echo "<table class='prescription-table'>";
      echo "<tr><th>Prescription ID</th><th>Doctor SSN</th><th>Trace Name</th><th>Date</th><th>Quantity</th></tr>";

      while ($prescriptionRow = $prescriptionResult->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $prescriptionRow['prescription_id'] . "</td>";
        echo "<td>" . $prescriptionRow['doctor_SSN'] . "</td>";
        echo "<td>" . $prescriptionRow['trace_name'] . "</td>";
        echo "<td>" . $prescriptionRow['date'] . "</td>";
        echo "<td>" . $prescriptionRow['quantity'] . "</td>";
        echo "</tr>";
      }

      echo "</table>";
    } else {
      echo "No prescription found.";
    }

    // Add a back button
    echo "<button class='back-button'><a href=\"patientpage.php\">Back</a></button>";
  } else {
    echo "Patient not found.";
  }
} else {
  echo "Invalid session. Please login again.";
}

$conn->close();
?>

<style>
    body {
      background-image: url('adminviewusers.jpg'); /* Add the image as the background */
      background-size: cover; /* Make the image fit the screen */
      background-position: center; /* Center the background image */
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding-top: 50px;
      margin: 0;
      font-family: Arial, sans-serif;
      color: black; /* Set the default text color to black */
    }

    .user-info {
      font-weight: bold;
      margin-bottom: 20px;
    }

    h1 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .prescription-table {
      border-collapse: collapse;
      width: 100%;
    }

    .prescription-table th,
    .prescription-table td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    .back-button {
      margin-top: 10px;
      display: inline-block;
      padding: 10px 20px;
      background-color: darkblue; /* Set the button to dark blue */
      color: white;
      text-decoration: none;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .back-button a {
      color: white;
      text-decoration: none;
    }
  </style>
