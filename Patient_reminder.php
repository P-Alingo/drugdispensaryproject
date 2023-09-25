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
    background-image: url('patientreminder.jpeg');
    background-size: cover;
    background-position: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding-top: 50px;
    margin: 0;
    font-family: Arial, sans-serif;
    font-size: 24px;
    color: black;
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
    font-size: 28px;
    margin-bottom: 10px;
  }
  label {
    display: block;
    margin-bottom: 5px;
  }
  input[type='text'],
  input[type='date'],
  input[type='time'],
  input[type='submit'],
  button {
    margin-bottom: 10px;
    padding: 14px 24px; /* Fixed padding for all buttons */
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 18px;
    transition: background-color 0.3s, color 0.3s; /* Add transition for color change */
  }
  input[type='submit'],
  button {
    background-color: #0074e4; /* Set the background color of buttons to blue */
    color: white;
    text-decoration: none;
    width: 200px; /* Set a fixed width for all buttons */
    text-align: center;
  }
  input[type='submit']:hover, /* Add hover effect for submit button */
  button:hover { /* Add hover effect for all buttons */
    background-color: #0057a3; /* Darken the background color on hover */
  }
  button a {
    color: white;
    text-decoration: none;
  }
  .card {
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    text-align: center;
    transition: box-shadow 0.3s; /* Add transition for box shadow */
  }
  .card:hover { /* Add hover effect for the card */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add a subtle shadow on hover */
  }
</style>";

echo "<div class='card'>";
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

echo "<button style='background-color: #0074e4; width: 200px;'><a href=\"view_reminders.php\">View Details</a></button>";
// Add a back button
echo "<button style='background-color: #0074e4; width: 200px;'><a href=\"patientpage.php\">Back</a></button>";
echo "</div>"; // Close the content container
echo "</div>"; // Close the card


} else {
  echo "Patient not found.";
}

 } else {
    echo "Invalid session. Please log in again.";
  }
}

$conn->close();
?>
