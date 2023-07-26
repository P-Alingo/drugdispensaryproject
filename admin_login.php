<?php
require_once("connection.php");

// Retrieve the submitted email and password
$email = $_POST['email'];
$password = $_POST['password'];

// Perform the verification logic here (e.g., check if the email and password match a record in the database)
$query = "SELECT * FROM adminstrator WHERE email='$email' AND password='$password'";
$result = $conn->query($query);

if ($result) {
  // Check if any rows were returned
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Start the session
    session_start();

    // Set the 'email' and 'full_name' in the session
    $_SESSION['email'] = $row['email'];
    $_SESSION['full_name'] = $row['full_name'];

    // Redirect to Adminpage.php if the credentials are correct
    header("Location: Adminpage.php");
    exit();
  } else {
    // Redirect back to the login form with an error message if the credentials are incorrect
    header("Location: admin_login.html?error=1");
    exit();
  }
} else {
  // Redirect back to the login form with an error message if there was an error executing the query
  header("Location: admin_login.html?error=2");
  exit();
}

$conn->close();
?>


