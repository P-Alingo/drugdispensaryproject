<?php

require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the patient's email from the session
  $email = $_SESSION['email'];

  // Check if the 'id', 'details', 'date', and 'time' are set in the form
  if (isset($_POST['id']) && isset($_POST['details']) && isset($_POST['date']) && isset($_POST['time'])) {
    // Retrieve the reminder ID and updated details from the form
    $reminderID = $_POST['id'];
    $reminderDetails = $_POST['details'];
    $reminderDate = $_POST['date'];
    $reminderTime = $_POST['time'];

    // Update the reminder details in the database
    $updateQuery = "UPDATE reminder SET details='$reminderDetails', date='$reminderDate', time='$reminderTime' WHERE id='$reminderID'";
    $updateResult = $conn->query($updateQuery);

    if ($updateResult === true) {
      // Redirect the user to view_reminders.php
      header("Location: view_reminders.php");
      exit();
    } else {
      echo "Error updating the reminder: " . $conn->error;
    }
  } else {
    // Retrieve the patient's SSN and full name from the database using their email
    $patientQuery = "SELECT SSN, full_name FROM patient WHERE email='$email'";
    $patientResult = $conn->query($patientQuery);

    if ($patientResult->num_rows > 0) {
      $patientRow = $patientResult->fetch_assoc();
      $patientSSN = $patientRow['SSN'];
      $full_name = $patientRow['full_name'];

      // Fetch reminders specific to the patient's SSN
      $query = "SELECT * FROM reminder WHERE patient_SSN='$patientSSN'";
      $result = $conn->query($query);

      if ($result->num_rows > 0) {
        echo "<div class='user-info'>";
        echo "Welcome, $full_name!";
        echo "</div>";
        // Display the reminders
        echo "<style>
                h1 {
                  font-size: 24px;
                  margin-bottom: 10px;
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
                a {
                  color: #4CAF50;
                  text-decoration: none;
                }
                .edit-button {
                  display: inline-block;
                  padding: 8px 16px;
                  background-color: indigo;
                  color: white;
                  text-decoration: none;
                  border: none;
                  border-radius: 4px;
                  cursor: pointer;
                  margin-top: 10px;
                }
                .delete-button {
                  display: inline-block;
                  padding: 8px 16px;
                  background-color: indigo;
                  color: white;
                  text-decoration: none;
                  border: none;
                  border-radius: 4px;
                  cursor: pointer;
                  margin-top: 10px;
                }
                .edit-button a,
                .delete-button a {
                  color: white;
                  text-decoration: none;
                }
                .back-button {
                  display: inline-block;
                  padding: 8px 16px;
                  background-color: indigo;
                  color: white;
                  text-decoration: none;
                  border: none;
                  border-radius: 4px;
                  cursor: pointer;
                  margin-top: 10px;
                }
                .back-button a {
                  color: white;
                  text-decoration: none;
                }
              </style>";

        echo "<h1>Reminder Details</h1>";
        echo "<table>";
        echo "<tr><th>Details</th><th>Date</th><th>Time</th><th>Action</th></tr>";

        while ($row = $result->fetch_assoc()) {
          // Display the reminder details
          echo "<tr>";
          echo "<td>" . $row['details'] . "</td>";
          echo "<td>" . $row['date'] . "</td>";
          echo "<td>" . $row['time'] . "</td>";
          echo "<td>";
          echo "<button class='edit-button'><a href=\"edit_reminder.php?id=" . $row['id'] . "\">Edit</a></button> ";
          echo "<button class='delete-button'><a href=\"delete_reminder.php?id=" . $row['id'] . "\">Delete</a></button>";
          echo "</td>";
          echo "</tr>";
        }

        echo "</table>";

        // Add a back button
        echo "<button class='back-button'><a href=\"Patient_reminder.php\">Back</a></button>"; // Replace 'Patient_reminder.php' with the actual page URL where the reminder form is displayed
      } else {
        echo "No reminders found.";
      }
    } else {
      echo "Patient not found.";
    }
  }
} else {
  echo "Invalid session. Please login again.";
}

$conn->close();

?>

