<?php
require_once("connection.php");

// Retrieve the submitted email and password
$email = $_POST['email'];
$password = $_POST['password'];

// Perform the verification logic here (e.g., check if the email and password match a record in the database)
$query = "SELECT * FROM pharmacist WHERE email='$email' AND password='$password'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  
  // Start the session
  session_start();

  // Set the 'email' value in the session
  $_SESSION['email'] = $row['email'];

  // Redirect to pharmacistpage.html if the credentials are correct
  header("Location: pharmacistpage.php");
  exit();
} else {
  // Redirect back to the login form with an error message if the credentials are incorrect
  header("Location: pharmacist_login.html");
  exit();
}

$conn->close();
?>
