<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the admin's email from the session
  $email = $_SESSION['email'];
  $full_Name = $_SESSION['full_name'];

  // Retrieve the admin's details from the database
  $adminQuery = "SELECT * FROM adminstrator WHERE email='$email'";
  $adminResult = $conn->query($adminQuery);

  if ($adminResult->num_rows > 0) {
    $adminRow = $adminResult->fetch_assoc();

    echo "<div class='user-info'>";
    echo "Welcome, $full_Name!";
    echo "</div>";

    // Display the admin's profile
    echo "<h1>Admin Profile</h1>";
    echo "<p>Admin ID: " . $adminRow['admin_id'] . "</p>";
    echo "<p>Full Name: " . $adminRow['full_name'] . "</p>";
    echo "<p>Gender: " . $adminRow['gender'] . "</p>";
    echo "<p>Email: " . $adminRow['email'] . "</p>";
    echo "<p>Password: " . $adminRow['password'] . "</p>";
    echo "<p>Date of Birth: " . $adminRow['date_of_birth'] . "</p>";
    echo "<p>Phone Number: " . $adminRow['phone_number'] . "</p>";
    echo "<p>Address: " . $adminRow['address'] . "</p>";

    // Edit button
    echo "<button onclick='goToEdit()'>Edit Profile</button>";
    echo "<script>";
    echo "function goToEdit() {";
    echo "  window.location.href = 'admin_edit.php';";
    echo "}";
    echo "</script>";

    // Back button
    echo "<button onclick=\"window.location.href='Adminpage.php'\">Back</button>";
  } else {
    echo "Admin not found.";
  }
} else {
  echo "Invalid session. Please login again.";
}

$conn->close();
?>

<style>
  body {
    background-image: url('adminprofile.jpeg');
                            background-size: cover;
                            background-position: center;
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
    margin-bottom: 20px;
  }

  .user-info {
    font-weight: bold;
    font-size: 24px; /* Increase the font size as desired */
    margin-bottom: 20px;
  }

  p {
    margin-bottom: 5px;
  }

  button {
    display: block;
    padding: 10px 20px;
    font-size: 16px;
    background-color: black;
    color: white;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    margin-bottom: 10px;
    cursor: pointer;
  }

  button:hover {
    background-color: #333;
  }
</style>
