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
    $row = $result->fetch_assoc();

    // Store the patient's full name in the session
    $_SESSION['full_name'] = $row['full_name'];

    // Retrieve the full name from the session
    $full_Name = $_SESSION['full_name'];
    ?>

<!DOCTYPE html>
<html>
<head>
  <title>Patient Profile</title>
  <style>
    body {
      background-image: url('patientprofile2.jpg');
      background-size: cover;
      background-position: center;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      justify-content: center;
      height: 100vh;
      padding: 20px;
      font-family: Arial, sans-serif;
    }

    .user-info {
      font-weight: bold;
      margin-bottom: 20px;
      font-size: 45px;
      color: #333;
    }

    .user-details {
      background-color: rgba(255, 255, 255, 0.7);
      padding: 40px;
      border-radius: 8px;
      max-width: 500px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-align: left;
      transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
    }

    .user-details:hover {
      transform: scale(1.02);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
      background-color: rgba(255, 255, 255, 0.9);
    }

    h1 {
      font-size: 23px;
      margin-bottom: 10px;
      color: #1E90FF;
    }

    p {
      margin-bottom: 5px;
      font-size: 18px;
    }

    .edit-profile-button,
    .back-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #1E90FF;
      color: white;
      text-decoration: none;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-right: 10px;
      transition: background-color 0.3s ease;
    }

    .edit-profile-button:hover,
    .back-button:hover {
      background-color: #007ACC;
    }

    .edit-profile-button a,
    .back-button a {
      color: white;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="user-info">
    Welcome, <?php echo $full_Name; ?>!
  </div>

  <div class="user-details">
    <h1>Patient Profile</h1>
    <p>SSN: <?php echo $row['SSN']; ?></p>
    <p>Full Name: <?php echo $row['full_name']; ?></p>
    <p>Gender: <?php echo $row['gender']; ?></p>
    <p>Email: <?php echo $row['email']; ?></p>
    <p>Password: <?php echo $row['PASSWORD']; ?></p>
    <p>Date of Birth: <?php echo $row['date_of_birth']; ?></p>
    <p>Age: <?php echo $row['age']; ?></p>
    <p>Phone Number: <?php echo $row['phone_number']; ?></p>
    <p>Address: <?php echo $row['address']; ?></p>

    <!-- Provide an option to edit the profile -->
    <button class="edit-profile-button"><a href='Patient_edit.php'>Edit Profile</a></button>

    <!-- Add a "Back" button -->
    <button class="back-button"><a href='Patientpage.php'>Back</a></button>
  </div>
</body>
</html>

    <?php
  } else {
    echo "Patient not found.";
  }
} else {
  echo "Invalid session. Please login again.";
}

$conn->close();
?>

