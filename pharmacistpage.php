<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the pharmacist's email from the session
  $email = $_SESSION['email'];

  // Retrieve the pharmacist's details from the database
  $pharmacistQuery = "SELECT * FROM pharmacist WHERE email='$email'";
  $pharmacistResult = $conn->query($pharmacistQuery);

  if ($pharmacistResult->num_rows > 0) {
    $pharmacistRow = $pharmacistResult->fetch_assoc();
    // Store the pharmacist's full name in the session
    $_SESSION['full_name'] = $pharmacistRow['full_name'];
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Pharmacist Page</title>
  <style>
       body {
      display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  text-align: center;
  padding-top: 150px;
  background-color: #f2f2f2;
  margin: 0;
  padding: 20px;
  font-family: Arial, sans-serif;
  background-image: url('pharmacist2.jpeg');
  background-size: cover;
  animation: slideshow 5s infinite;
}

    h1 {
      color: #333;
    }

    .button {
      display: block;
      padding: 10px 20px;
      font-size: 18px;
      background-color: #774caf;
      color: white;
      border: none;
      border-radius: 4px;
      text-decoration: none;
      margin-right: 10px;
      margin-bottom: 10px;
      cursor: pointer;
    }

    .button:hover {
      background-color: #6545a0;
    }

    .user-info {
      font-size: 24px;
      margin-bottom: 20px;
    }
        
@keyframes slideshow {      
  0%, 100% {
    background-image: url('pharmacist2.jpeg');
  }
  50% {
    background-image: url('pharmacist.jpeg');
  }}
  </style>
</head>
<body>
  <?php if (isset($_SESSION['full_name'])) : ?>
    <div class="user-info">Welcome, <?php echo $_SESSION['full_name']; ?>!</div>
  <?php endif; ?>
  
  <a href="pharmacist_profile.php" class="button">Profile</a>
  <a href="pharmacist_view_prescription.php" class="button">Prescriptions</a> 
  <a href="pharmacist_view_drugs.php" class="button">Available Drugs</a>
  <a href="pharmacist_all_dispensed.php" class="button">All Dispensed Drugs</a>
  <a href="pharmacist_manage_dispense.php" class="button">Dispense Drugs</a>
  <a href="project.html" class="button">Log Out</a>
</body>
</html>

