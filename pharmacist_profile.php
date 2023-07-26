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
    // Fetch the pharmacist's details
    $pharmacistRow = $pharmacistResult->fetch_assoc();
    
    // Display the pharmacist's name at the top
    echo "<div class='user-info' style='font-size: 24px;'>";
    echo " " . $pharmacistRow['full_name'];
    echo "</div>";

    echo "<h1>Pharmacist Profile</h1>";
    echo "<p>Employee ID: " . $pharmacistRow['employee_id'] . "</p>";
    echo "<p>Full Name: " . $pharmacistRow['full_name'] . "</p>";
    echo "<p>Gender: " . $pharmacistRow['gender'] . "</p>";
    echo "<p>Email: " . $pharmacistRow['email'] . "</p>";
    echo "<p>Password: " . $pharmacistRow['password'] . "</p>";
    echo "<p>Date of Birth: " . $pharmacistRow['date_of_birth'] . "</p>";
    echo "<p>Phone Number: " . $pharmacistRow['phone_number'] . "</p>";
    echo "<p>Address: " . $pharmacistRow['address'] . "</p>";

    // Edit button
    echo "<form method='post' action='pharmacist_edit.php'>";
    echo "<input type='submit' value='Edit Profile'>";
    echo "</form>";

    // Back button
    echo "<form method='post' action='pharmacistpage.php'>";
    echo "<input type='submit' value='Back'>";
    echo "</form>";
  } else {
    echo "Pharmacist not found.";
  }
} else {
  echo "Invalid session. Please login again.";
}

$conn->close();
?>

<style>
  body {
    background-image: url('pharmacistprofile.jpeg'); /* Add the image as the background */
      background-size: cover; /* Make the image fit the screen */
      background-position: center; /* Center the background image */
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
  }

  h1 {
    color: #333;
  }

  .user-info {
    font-size: 24px;
    margin-bottom: 20px;
  }

  form {
    margin-top: 20px;
  }

  input[type="submit"] {
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

  input[type="submit"]:hover {
    background-color: #6545a0;
  }
</style>


