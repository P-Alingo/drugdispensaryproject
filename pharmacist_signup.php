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

  // Check if the pharmacist is already registered
  $checkQuery = "SELECT * FROM pharmacist WHERE email='$email'";
  $checkResult = $conn->query($checkQuery);

  if ($checkResult->num_rows > 0) {
    // Pharmacist is already registered
    $conn->close();
    header("Location:pharmacist_Signup.html?message=already_registered");
    exit();
  }

  // Insert the form data into the pharmacist table
  $insertQuery = "INSERT INTO pharmacist (full_name, gender, email, password, date_of_birth, phone_number, address) 
  VALUES ('$fullName', '$gender', '$email', '$password', '$dateOfBirth', '$phoneNumber', '$address')";
                   
                   // Execute the query
     if ($conn->query($insertQuery) === TRUE) {
      // Start the session
      session_start();
  
      // Set the 'email' and 'full_name' in the session
      $_SESSION['email'] = $email;
      $_SESSION['full_name'] = $fullname;
  
      // After successful registration
      $_SESSION['registration_success'] = true;

  // Execute the query
  if ($conn->query($insertQuery) === TRUE) {
    // Pharmacist data saved successfully
    $conn->close();
    header("Location:http://localhost/myproject/drugdispensaryproject/pharmacistpage.php"); // Redirect to pharmacist page
    exit();
  } else {
    echo "Error: " . $conn->error;
  }
}}

$conn->close();
?>
