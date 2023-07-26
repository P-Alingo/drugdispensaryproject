<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the patient's email from the session
  $email = $_SESSION['email'];

  // Retrieve the patient's SSN from the database using their email
  $patientQuery = "SELECT SSN FROM patient WHERE email='$email'";
  $patientResult = $conn->query($patientQuery);

  // Check if the 'full_name' session variable is set
  if (isset($_SESSION['full_name'])) {
    // Retrieve the patient's full name from the session
    $full_name = $_SESSION['full_name'];

    // Display the welcome message
    echo "<div class='user-info'>";
    echo "Welcome, $full_name!";
    echo "</div>";

    if ($patientResult->num_rows > 0) {
      $patientRow = $patientResult->fetch_assoc();
      $patientSSN = $patientRow['SSN'];

      // Check if the form is submitted
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the reminder details from the form
        $details = $_POST['details'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        // Insert the reminder into the database
        $insertQuery = "INSERT INTO reminder (patient_SSN, details, date, time) VALUES ('$patientSSN', '$details', '$date', '$time')";
        if ($conn->query($insertQuery) === TRUE) {
          // Display a notification on the user's computer screen
          echo "<script>
                  if ('Notification' in window) {
                    if (Notification.permission === 'granted') {
                      new Notification('Reminder Created', { body: 'Your reminder has been successfully created.' });
                    } else if (Notification.permission !== 'denied') {
                      Notification.requestPermission().then(function (permission) {
                        if (permission === 'granted') {
                          new Notification('Reminder Created', { body: 'Your reminder has been successfully created.' });
                        }
                      });
                    }
                  }
               </script>";
        } else {
          echo "Error creating reminder: " . $conn->error;
        }
      }

      // Display the reminder form
      echo "<style>
      body {
        background-image: url('patientreminder.jpeg'); /* Add the image as the background */
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
        font-size: 24px; /* Increase the font size to 24px */
        color: black; /* Set the default text color to black */
      }
      .user-info {
        font-weight: bold;
        margin-bottom: 20px;
      }
      .content-container {
        display: flex;
        flex-direction: column;
        align-items: center;
      }
      h1 {
        font-size: 28px; /* Increase the font size of h1 to 28px */
        margin-bottom: 10px;
      }
      label {
        display: block;
        margin-bottom: 5px;
      }
      input[type='text'],
      input[type='date'],
      input[type='time'],
      input[type='submit'] {
        margin-bottom: 10px;
        padding: 8px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 24px; /* Increase the font size of input elements to 24px */
      }
      input[type='submit'] {
        background-color: #4b0082; /* Set the background color to dark blue */
        color: white; /* Set the text color to white */
        cursor: pointer;
      }
      button {
        padding: 8px 20px; /* Equal padding of 8px vertically and 20px horizontally */
        background-color: #4b0082; /* Set the background color of buttons to dark blue */
        color: white;
        text-decoration: none;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 24px; /* Increase the font size of buttons to 24px */
      }
    
      a {
        color: white;
        text-decoration: none;
      }
    </style>";

      echo "<h1>Create Reminder</h1>";
      echo "<div class='content-container'>";
      echo "<form method=\"POST\" action=\"Patient_reminder.php\">";
      echo "<label for=\"details\">Details:</label>";
      echo "<input type=\"text\" id=\"details\" name=\"details\" required><br>";
      echo "<label for=\"date\">Date:</label>";
      echo "<input type=\"date\" id=\"date\" name=\"date\" required><br>";
      echo "<label for=\"time\">Time:</label>";
      echo "<input type=\"time\" id=\"time\" name=\"time\" required><br>";
      echo "<input type=\"submit\" value=\"Create Reminder\">";
      echo "</form>";

      echo "<button><a href=\"view_reminders.php\">View Details</a></button>";
      // Add a back button
      echo "<button><a href=\"patientpage.php\">Back</a></button>";
      echo "</div>"; // Close the content container
    } else {
      echo "Patient not found.";
    }
  } else {
    echo "Invalid session. Please log in again.";
  }
}

$conn->close();
?>
