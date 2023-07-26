<?php
// Include the connection file
require_once "connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Retrieve form data
  $full_name = $_POST['full_name'];
  $gender = $_POST['gender'];
  $specialization = $_POST['specialization'];
  $years_of_experience = $_POST['years_of_experience'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $date_of_birth = $_POST['date_of_birth'];
  $phone_number = $_POST['phone_number'];
  $address = $_POST['address'];

  // Check if the doctor is already registered
  $checkQuery = "SELECT * FROM doctor WHERE email='$email'";
  $checkResult = $conn->query($checkQuery);

  if ($checkResult->num_rows > 0) {
    // Doctor is already registered
    $conn->close();
    header("Location: Doctor_Signup.html?message=already_registered");
    exit();
  }

  // Create the SQL query to insert the data into the doctor table
  $query = "INSERT INTO doctor (full_name, gender, specialization, years_of_experience, email, password, date_of_birth, phone_number, address) VALUES ('$full_name', '$gender', '$specialization', '$years_of_experience', '$email', '$password', '$date_of_birth', '$phone_number', '$address')";

  // Execute the query
  if ($conn->query($query) === TRUE) {
    // Doctor data saved successfully
    $conn->close();
    header("Location: Doctor_login.html");
    exit();
  } else {
    echo "Error: " . $conn->error;
  }
}

// Close the database connection
$conn->close();
?>
