<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the doctor's email from the session
  $email = $_SESSION['email'];
  $fullName = $_SESSION['full_name'];

  // Retrieve the doctor's details from the database
  $doctorQuery = "SELECT * FROM doctor WHERE email='$email'";
  $doctorResult = $conn->query($doctorQuery);

  if ($doctorResult->num_rows > 0) {
    // Fetch the doctor's details
    $doctorRow = $doctorResult->fetch_assoc();
    $doctorSSN = $doctorRow['SSN']; // Retrieve the doctor's SSN

    // Retrieve the list of appointments for the doctor
    $appointmentQuery = "SELECT * FROM appointment WHERE doctor_SSN='$doctorSSN'";
    $appointmentResult = $conn->query($appointmentQuery);

    // Display the list of appointments
    if ($appointmentResult->num_rows > 0) {
      echo "<div class='user-info'>";
      echo "<h2>$fullName</h2>";
      echo "</div>";
      echo "<div class='appointment-list'>";
      echo "<h1>Doctor Appointments</h1>";

      echo "<table class='appointment-table'>";
      echo "<tr>";
      echo "<th>Appointment Date</th>";
      echo "<th>Appointment Time</th>";
      echo "<th>Patient SSN</th>";
      echo "<th>Appointment Purpose</th>";
      echo "<th>Delete</th>";
      echo "<th>Edit</th>";
      echo "</tr>";

      while ($appointmentRow = $appointmentResult->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $appointmentRow['appointment_date'] . "</td>";
        echo "<td>" . $appointmentRow['appointment_time'] . "</td>";
        echo "<td>" . $appointmentRow['patient_SSN'] . "</td>";
        echo "<td>" . $appointmentRow['appointment_purpose'] . "</td>";

        echo "<td>";
        echo "<form method='post' action='doctor_delete_appointment.php'>";
        echo "<input type='hidden' name='appointment_id' value='" . $appointmentRow['appointment_id'] . "'>";
        echo "<input class='delete-appointment-button' type='submit' value='Delete'>";
        echo "</form>";
        echo "</td>";

        echo "<td>";
        echo "<form method='post' action='doctor_edit_appointment.php'>";
        echo "<input type='hidden' name='appointment_id' value='" . $appointmentRow['appointment_id'] . "'>";
        echo "<input class='edit-appointment-button' type='submit' value='Edit'>";
        echo "</form>";
        echo "</td>";

        echo "</tr>";
      }

      echo "</table>";

      // Back button
      echo "<button class='back-button' onclick='goBack()'>Back</button>";
      echo "<script>";
      echo "function goBack() {";
      echo "  window.location.href = 'doctor_appointment.php';";
      echo "}";
      echo "</script>";

      echo "</div>"; // Close the appointment-list div
    } else {
      echo "<p>No appointments found.</p>";
    }
  } else {
    echo "<p>Doctor not found.</p>";
  }
} else {
  echo "<p>Invalid session. Please login again.</p>";
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

  .appointment-list {
    margin-top: 20px;
  }

  .appointment-list h1 {
    text-align: center;
    color: #333;
    margin-bottom: 10px;
  }

  .appointment-table {
    width: 100%;
    border-collapse: collapse;
  }

  .appointment-table th,
  .appointment-table td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  .appointment-table th {
    background-color: #f2f2f2;
    font-weight: bold;
  }

  .delete-appointment-button,
  .edit-appointment-button {
    padding: 5px 10px;
    background-color: #333;
    color: #fff;
    border: none;
    cursor: pointer;
  }

  .delete-appointment-button:hover,
  .edit-appointment-button:hover {
    background-color: #555;
  }

  p.no-appointments {
    text-align: center;
    color: #888;
  }
  .back-button {
  padding: 5px 10px;
  background-color: #333;
  color: #fff;
  border: none;
  cursor: pointer;
  margin-bottom: 20px;
}

.back-button:hover {
  background-color: #555;
}

</style>


