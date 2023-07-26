<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the patient's email from the session
  $email = $_SESSION['email'];

  // Retrieve the patient's full name from the database using their email
  $patientQuery = "SELECT full_name FROM patient WHERE email='$email'";
  $patientResult = $conn->query($patientQuery);

  if ($patientResult->num_rows > 0) {
    $patientRow = $patientResult->fetch_assoc();
    $fullName = $patientRow['full_name'];

    // Retrieve the patient's SSN from the database using their email
    $patientQuery = "SELECT SSN FROM patient WHERE email='$email'";
    $patientResult = $conn->query($patientQuery);

    if ($patientResult->num_rows > 0) {
      $patientRow = $patientResult->fetch_assoc();
      $patientSSN = $patientRow['SSN'];

      // Retrieve the patient's appointments from the database
      $appointmentsQuery = "SELECT * FROM appointment WHERE patient_SSN='$patientSSN'";
      $appointmentsResult = $conn->query($appointmentsQuery);

      if ($appointmentsResult === false) {
        // Handle the query execution error
        echo "Error executing the query: " . $conn->error;
      } else {
        if ($appointmentsResult->num_rows > 0) {
          echo "<!DOCTYPE html>";
          echo "<html>";
          echo "<head>";
          echo "<title>Appointments</title>";
          echo "<style>";
          echo "h1 {
            font-size: 24px;
            margin-bottom: 10px;
          }
          .user-info {
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 45px; /* Increase the font size to 45px */
          }
          table {
            border-collapse: collapse;
            width: 100%;
          }
          th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
          }
          th {
            background-color: #f2f2f2;
          }
          form {
            display: inline-block;
          }
          input[type='submit'] {
            padding: 6px 12px;
            background-color: darkblue; /* Set the buttons to dark blue */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
          }
          input[type='submit']:hover {
            background-color: #4b0082;
          }
          .back-button {
            display: inline-block;
            padding: 6px 12px;
            background-color: darkblue; /* Set the buttons to dark blue */
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
          }
          .back-button:hover {
            background-color: #4b0082;
          }";
          echo "</style>";
          echo "</head>";
          echo "<body>";
          
          echo "<div class='user-info'>";
          echo "$fullName";
          echo "</div>";

          echo "<h1>Appointments</h1>";
          echo "<table>";
          echo "<tr><th>Appointment Date</th><th>Appointment Time</th><th>Appointment Purpose</th><th>Doctor SSN</th><th>Action</th></tr>";

          while ($appointmentRow = $appointmentsResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $appointmentRow['appointment_date'] . "</td>";
            echo "<td>" . $appointmentRow['appointment_time'] . "</td>";
            echo "<td>" . $appointmentRow['appointment_purpose'] . "</td>";
            echo "<td>" . $appointmentRow['doctor_SSN'] . "</td>";
            echo "<td>";
            echo "<form method='POST' action='patient_delete_appointment.php'>";
            echo "<input type='hidden' name='appointmentID' value='" . $appointmentRow['appointment_id'] . "'>";
            echo "<input type='submit' value='Delete'>";
            echo "</form>";
            echo "<form method='POST' action='patient_edit_appointment.php'>";
            echo "<input type='hidden' name='appointmentID' value='" . $appointmentRow['appointment_id'] . "'>";
            echo "<input type='submit' value='Edit'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
          }

          echo "</table>";

          // Add a back button
          echo "<button class='back-button'><a href='patient_appointment.php'>Back</a></button>";
          echo "</body>";
          echo "</html>";
        } else {
          echo "No appointments found.";
        }
      }
    } else {
      echo "Patient not found.";
    }
  } else {
    echo "Full name not found.";
  }
} else {
  echo "Invalid session. Please login again.";
}

$conn->close();
?>
