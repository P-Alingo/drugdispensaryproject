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
      background-image: url('patientappointment.jpg');
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
    }

    .card {
      background-color: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      text-align: left;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    h1 {
      font-size: 24px;
      color: #333;
      margin-bottom: 30px;
    }

    .user-info {
      font-size: 45px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    form label {
      display: block;
      margin-bottom: 10px;
      color: #666;
    }

    form input[type='date'],
    form input[type='time'],
    form input[type='text'],
    form select {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 20px;
      font-size: 16px;
    }

    form input[type='submit'] {
      background-color: darkblue;
      color: white;
      padding: 14px 24px;
      font-size: 18px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    form input[type='submit']:hover {
      background-color: blue;
    }

    .button-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-top: 10px;
    }

    .view-button {
      background-color: darkblue;
      color: white;
      padding: 14px 24px;
      font-size: 18px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .view-button:hover {
      background-color: blue;
    }

    .back-button {
    background-color: darkblue;
    color: white; /* Set text color to white */
    padding: 10px 20px;
    font-size: 16px;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    margin-top: 10px;
    width: 100%;
    text-decoration: none;
    transition: background-color 0.3s;
  }

  .back-button:hover {
    background-color: blue;
  }

  </style>
</head>
<body>
  <div class='user-info'>
    Welcome, <?php echo $fullName; ?>!
  </div>
  <div class="card">
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
     
      <div class="button-container">
        <input type='submit' value='Schedule Appointment'>
        <a href='patient_view_appointments.php' class="view-button">View Appointment</a>
        <form method='POST' action='patient_view_appointments.php'></form>
        <button class="back-button"><a href='patientpage.php'>Back</a></button>
      </div>
    </form>
  </div>
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
