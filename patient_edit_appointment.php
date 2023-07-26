<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the appointmentID is set
if (isset($_POST['appointmentID'])) {
  // Retrieve the appointmentID from the form
  $appointmentID = $_POST['appointmentID'];

  // Check if the full_name session variable is set
  if (isset($_SESSION['full_name'])) {
    $fullName = $_SESSION['full_name'];

    // Retrieve the appointment details from the database
    $appointmentQuery = "SELECT * FROM appointment WHERE appointment_id='$appointmentID'";
    $appointmentResult = $conn->query($appointmentQuery);

    if ($appointmentResult->num_rows > 0) {
      // Fetch the appointment details
      $appointmentRow = $appointmentResult->fetch_assoc();
      $appointmentDate = $appointmentRow['appointment_date'];
      $appointmentTime = $appointmentRow['appointment_time'];
      $appointmentPurpose = $appointmentRow['appointment_purpose'];
      
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Appointment</title>
  <style>
    body {
      background-image: url('patientappointment.jpg'); /* Add the image as the background */
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
      color: black; /* Set the text color to black */
    }

    .user-info {
      font-weight: bold;
      margin-bottom: 20px;
      font-size: 45px; /* Increase the font size to 45px */
    }

    h1 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    input[type='date'],
    input[type='time'],
    textarea {
      margin-bottom: 10px;
      padding: 8px;
      border-radius: 4px;
      border: 1px solid #ccc;
      width: 100%; /* Make the text fields 100% wide */
    }

    input[type='submit'] {
      padding: 8px 16px;
      background-color: darkblue; /* Set the buttons to dark blue */
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type='submit']:hover {
      background-color: #4b0082;
    }

    button {
      display: inline-block;
      padding: 8px 16px;
      background-color: darkblue; /* Set the buttons to dark blue */
      color: white;
      text-decoration: none;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
    }

    button a {
      color: white;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class='user-info'>
    Welcome, <?php echo $fullName; ?>!
  </div>
  <h1>Edit Appointment</h1>
  <form method='POST' action='patient_update_appointment.php'>
    <input type='hidden' name='appointmentID' value='<?php echo $appointmentID; ?>'>
    <label for='appointmentDate'>Appointment Date:</label>
    <input type='date' id='appointmentDate' name='appointmentDate' value='<?php echo $appointmentDate; ?>' required><br><br>
    <label for='appointmentTime'>Appointment Time:</label>
    <input type='time' id='appointmentTime' name='appointmentTime' value='<?php echo $appointmentTime; ?>' required><br><br>
    <label for='appointmentPurpose'>Appointment Purpose:</label>
    <textarea id='appointmentPurpose' name='appointmentPurpose' required><?php echo $appointmentPurpose; ?></textarea><br><br>
    <input type='submit' value='Update Appointment'>
  </form>
  <button><a href='patient_view_appointments.php'>Back</a></button>
</body>
</html>

<?php
    } else {
      echo "Appointment not found.";
    }
  } else {
    echo "Invalid session. Please login again.";
  }
} else {
  echo "Invalid request.";
}

$conn->close();
?>
