<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the admin's email from the session
  $email = $_SESSION['email'];

  // Retrieve the updated profile data from the form
  $adminID = $_POST['admin_id'];
  $fullName = $_POST['full_name'];
  $gender = $_POST['gender'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $dateOfBirth = $_POST['date_of_birth'];
  $phoneNumber = $_POST['phone_number'];
  $address = $_POST['address'];

  // Update the admin's profile in the database
  $updateQuery = "UPDATE adminstrator SET full_name='$fullName', gender='$gender', email='$email', password='$password', date_of_birth='$dateOfBirth', phone_number='$phoneNumber', address='$address' WHERE email='$email'";

  if ($conn->query($updateQuery) === TRUE) {
    // Profile updated successfully
    $conn->close();
    header("Location: admin_profile.php"); // Redirect to admin_profile.php
    exit();
  } else {
    echo "Error updating profile: " . $conn->error;
  }
} else {
  echo "Invalid session. Please login again.";
}

$conn->close();
?>
