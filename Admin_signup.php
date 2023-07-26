<?php
require_once("connection.php");

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the form data
  $fullName = $_POST['full_name'];
  $gender = $_POST['gender'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $dateOfBirth = $_POST['date_of_birth'];
  $phoneNumber = $_POST['phone_number'];
  $address = $_POST['address'];

  // Check if the administrator is already registered
  $checkQuery = "SELECT * FROM adminstrator WHERE email='$email'";
  $checkResult = $conn->query($checkQuery);

  if ($checkResult->num_rows > 0) {
    // Administrator is already registered
    $conn->close();
    header("Location: Admin_Signup.html?message=already_registered");
    exit();
  }

  // Insert the form data into the admin table
  $insertQuery = "INSERT INTO adminstrator (full_name, gender, email, password, date_of_birth, phone_number, address)
                  VALUES ('$fullName', '$gender', '$email', '$password', '$dateOfBirth', '$phoneNumber', '$address')";

  // Execute the query
  if ($conn->query($insertQuery) === TRUE) {
    // Admin data saved successfully
    $conn->close();
    header("Location: admin_login.html"); // Redirect to adminpage.html
    exit();
  } else {
    echo "Error: " . $conn->error;
  }
}

$conn->close();
?>
