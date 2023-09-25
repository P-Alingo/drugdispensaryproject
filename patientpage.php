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

  if ($result->num_rows > 0) {
    // Retrieve the patient's full name from the database
    $row = $result->fetch_assoc();
    $full_name = $row['full_name'];
  } else {
    // If the patient's details are not found, redirect to the login page
    header("Location: patient_login.php");
    exit();
  }
} else {
  // If the 'email' key is not set in the session, redirect to the login page
  header("Location: patient_login.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Patient Page</title>
  <style>
    body {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding-top: 50px;
      background-color: #f2f2f2;
      margin: 0;
      padding: 20px;
      font-family: Arial, sans-serif;
      background-image: url('user2.jpeg');
      background-size: cover;
      animation: slideshow 5s infinite;
    }

    .card-container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      animation: slide-in 1s ease-in-out; /* Add slide-in animation */
    }

    .card {
      border-radius: 10px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      width: 250px; /* Adjust the card width as needed */
      padding: 20px;
      margin: 20px;
      text-align: center;
      background-color: #fff;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.3);
    }

    .button {
      display: inline-block;
      padding: 10px 20px;
      font-size: 18px;
      background-color: #0a209e; /* Change to your desired button color */
      color: white;
      border: none;
      border-radius: 4px;
      text-decoration: none;
      margin-bottom: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .button:hover {
      background-color: #4553a0; /* Change to your desired button hover color */
      transform: scale(1.05);
    }

    .button i {
      margin-right: 8px;
    }

    .user-info {
      font-size: 24px;
      font-weight: bold;
      color: #333;
      margin-bottom: 20px;
    }

    @keyframes slideshow {
      0%, 100% {
        background-image: url('patient.jpg');
      }
      50% {
        background-image: url('patient3.webp');
      }
    }

    /* Add slide-in animation keyframes */
    @keyframes slide-in {
      0% {
        opacity: 0;
        transform: translateY(50px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
  <div class="user-info">
    Welcome, <?php echo $full_name; ?>
  </div>

  <div class="card-container">
    <div class="card">
      <a href="Patient_profile.php" class="button">Profile</a>
      <p>Click here to view your profile</p>
    </div>
    <div class="card">
      <a href="patient_appointment.php" class="button">Appointments</a>
      <p>Click here to set and view your appointment details.</p>
    </div>
    <div class="card">
      <a href="Patient_prescription.php" class="button">Prescription</a>
      <p>Click here to view your prescription details.</p>
    </div>
    <div class="card">
      <a href="Patient_reminder.php" class="button">Set Reminder</a>
      <p>Click here to set and view your reminder details.</p>
    </div>
  </div>

  <a href="project.html" class="button">Log Out</a>

  <script>
    // Function to display the registration success message
    function displayRegistrationSuccess() {
      // Check if the registration success session variable is set and true
      var registrationSuccess = <?php echo isset($_SESSION['registration_success']) && $_SESSION['registration_success'] ? 'true' : 'false'; ?>;
      
      if (registrationSuccess) {
        var feedbackDiv = document.createElement("div");
        feedbackDiv.innerText = "User successfully registered";
        feedbackDiv.style.color = "black";
        feedbackDiv.style.marginTop = "100px";
        feedbackDiv.style.fontWeight = "bold"; // Set the text to bold
        document.body.appendChild(feedbackDiv);

        // Automatically remove the feedback message after 5 seconds
        setTimeout(function () {
          feedbackDiv.style.display = "none";
        }, 5000);
      }
    }

    // Call the function when the page loads
    window.onload = displayRegistrationSuccess;
  </script>
</body>
</html>

