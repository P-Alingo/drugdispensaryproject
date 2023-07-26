<?php
// Include the connection file
require_once "connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Retrieve form data
  $full_name = $_POST['full_name'];
  $gender = $_POST['gender'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $date_of_birth = $_POST['date_of_birth'];
  $age = $_POST['age'];
  $phone_number = $_POST['phone_number'];
  $address = $_POST['address'];

  // Check if the user is already registered
  $checkQuery = "SELECT * FROM patient WHERE email='$email'";
  $checkResult = $conn->query($checkQuery);

  if ($checkResult->num_rows > 0) {
    // User is already registered
    $conn->close();
    header("Location: http://localhost/practicephp/Patient_Signup.html?message=already_registered");
    exit();
  }

  // Create the SQL query to insert the data into the patient table
  $query = "INSERT INTO patient (full_name, gender, email, password, date_of_birth, age, phone_number, address) VALUES ('$full_name', '$gender', '$email', '$password', '$date_of_birth', '$age', '$phone_number', '$address')";

  // Execute the query
  if ($conn->query($query) === TRUE) {
    // Patient data saved successfully
    $conn->close();
    header("Location: http://localhost/practicephp/Patient_login.html");
    exit();
  } else {
    echo "Error: " . $conn->error;
  }
}

// Close the database connection
$conn->close();
?>
