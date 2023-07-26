<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the patient's email from the session
  $email = $_SESSION['email'];

  if (isset($_SESSION['full_name'])) {
    // Retrieve the patient's full name from the session
    $fullName = $_SESSION['full_name'];
  } else {
    // If the 'fullName' session variable is not set, redirect to the login page
    header("Location: Patient_login.html");
    exit();
  }

  // Check if the form is submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the appointment details from the form
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];
    $appointmentPurpose = $_POST['appointmentPurpose'];
    $doctorSSN = $_POST['doctorSelection'];

    // Retrieve the patient's SSN and full name from the database using their email
    $patientQuery = "SELECT SSN FROM patient WHERE email='$email'";
    $patientResult = $conn->query($patientQuery);

    if ($patientResult->num_rows > 0) {
      $patientRow = $patientResult->fetch_assoc();
      $patientSSN = $patientRow['SSN'];

      // Retrieve the selected doctor's full name from the database
      $doctorQuery = "SELECT full_name FROM doctor WHERE SSN='$doctorSSN'";
      $doctorResult = $conn->query($doctorQuery);

      if ($doctorResult->num_rows > 0) {
        $doctorRow = $doctorResult->fetch_assoc();
        $doctorFullName = $doctorRow['full_name'];

        // Insert the appointment into the database
        $insertQuery = "INSERT INTO appointment (patient_SSN, patient_full_name, doctor_SSN, doctor_full_name, appointment_date, appointment_time, appointment_purpose, appointment_status) 
                        VALUES ('$patientSSN', '$fullName', '$doctorSSN', '$doctorFullName', '$appointmentDate', '$appointmentTime', '$appointmentPurpose', 'Scheduled')";
        
        if ($conn->query($insertQuery) === TRUE) {
          echo "Appointment scheduled successfully.";
        } else {
          echo "Error scheduling appointment: " . $conn->error;
        }
      } else {
        echo "Doctor not found.";
      }
    } else {
      echo "Patient not found.";
    }
  }

  // Retrieve the available doctors from the database
  $query = "SELECT SSN, full_name, specialization FROM doctor";
  $result = $conn->query($query);

  if ($result === false) {
    // Handle the query execution error
    echo "Error executing the query: " . $conn->error;
  } else {
    if ($result->num_rows > 0) {
      // Display the appointment form with the doctor selection dropdown
?>

<!DOCTYPE html>
<html>
<head>
  <title>Schedule Appointment</title>
  <style>
    body {
      background-image: url('patientappointment.jpg'); /* Add the image as the background */
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
    }

    h1 {
      font-size: 20px;
      color: #333;
      margin-bottom: 30px;
    }

    .user-info {
      font-size: 45px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    form {
      max-width: 400px;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.7); /* Add a semi-transparent background for better readability */
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    label {
      display: block;
      margin-bottom: 8px;
      color: #666;
    }

    input[type='date'],
    input[type='time'],
    input[type='text'],
    select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 12px;
    }

    input[type='submit'] {
      background-color: darkblue;
      color: white;
      padding: 10px 20px;
      font-size: 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type='submit']:hover {
      background-color: #4b0082;
    }

    button {
      display: inline-block;
      padding: 10px 20px;
      background-color: darkblue;
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
  <h1>Schedule Appointment</h1>
  <form method='POST' action='patient_appointment.php'>
    <label for='appointmentDate'>Date:</label>
    <input type='date' id='appointmentDate' name='appointmentDate' required><br>
    <label for='appointmentTime'>Time:</label>
    <input type='time' id='appointmentTime' name='appointmentTime' required><br>
    <label for='appointmentPurpose'>Purpose:</label>
    <input type='text' id='appointmentPurpose' name='appointmentPurpose' required><br>
    <label for='doctorSelection'>Select Doctor:</label>
    <select id='doctorSelection' name='doctorSelection'>
      <?php
        while ($row = $result->fetch_assoc()) {
          echo "<option value='" . $row['SSN'] . "'>" . $row['full_name'] . " - " . $row['specialization'] . "</option>";
        }
      ?>
    </select><br>
    <input type='submit' value='Schedule Appointment'>
  </form>
  <form method='POST' action='patient_view_appointments.php'>
    <input type='submit' value='View Appointments'>
  </form>
  <button><a href='patientpage.php'>Back</a></button>
</body>
</html>

<?php
    } else {
      echo "No doctors available.";
    }
  }

  $conn->close();
} else {
  echo "Invalid session. Please login again.";
}
?>
