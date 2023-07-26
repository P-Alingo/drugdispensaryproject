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
    $full_name = $patientRow['full_name'];

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
      // Check if the 'id' is provided in the URL
      if (isset($_GET['id'])) {
        $reminderID = $_GET['id'];

        // Fetch the reminder from the database based on the ID
        $query = "SELECT * FROM Reminder WHERE id='$reminderID'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();

          // Display the edit form
          echo "<style>
        body {
          background-image: url('patientreminder.jpeg');
          /* Add the image as the background */
          background-size: cover;
          /* Make the image fit the screen */
          background-position: center;
          /* Center the background image */
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          text-align: center;
          padding-top: 50px;
          margin: 0;
          font-family: Arial, sans-serif;
          font-size: 20px; /* Increase the font size to 20px */
          color: black; /* Set the default text color to black */
        }
        .user-info {
          font-weight: bold;
          margin-bottom: 20px;
        }
        input[type='text'],
        button {
          margin-bottom: 10px;
          padding: 8px;
          border-radius: 4px;
          border: 1px solid #ccc;
          font-size: 20px; /* Increase the font size to 20px */
          width: 300px; /* Set the width of the text fields to 300px */
        }
        input[type='submit'] {
          background-color: #4b0082; /* Set the background color to dark blue */
          color: white; /* Set the text color to white */
          cursor: pointer;
        }
        button {
          background-color: #4b0082; /* Set the background color of buttons to dark blue */
          color: white;
          cursor: pointer;
          font-size: 20px; /* Increase the font size of buttons to 20px */
          width: 150px; /* Set the width of the buttons to 150px */
        }
        button a {
          color: white;
          text-decoration: none;
        }
      </style>";

          echo "<div class='user-info'>";
          echo $full_name;
          echo "</div>";
          echo "<form action=\"edit_reminder.php\" method=\"post\">";
          echo "<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\">";
          echo "Details: <input type=\"text\" name=\"details\" value=\"" . $row['details'] . "\" required><br>";
          echo "Date: <input type=\"text\" name=\"date\" value=\"" . $row['date'] . "\" required><br>";
          echo "Time: <input type=\"text\" name=\"time\" value=\"" . $row['time'] . "\" required><br>";
          echo "<button type=\"submit\">Update</button>";
          echo "</form>";

          // Add a back button
          echo "<button><a href=\"view_reminders.php\">Back</a></button>";
        } else {
          echo "Reminder not found.";
        }
      } else {
        echo "Invalid request.";
      }
    }
  } else {
    echo "Patient not found.";
  }
} else {
  echo "Invalid session. Please login again.";
}

$conn->close();
?>
