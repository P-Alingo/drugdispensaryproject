<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the doctor's email from the session
  $email = $_SESSION['email'];
  $fullName = $_SESSION['full_name'];

  // Retrieve the doctor's details from the database
  $query = "SELECT * FROM doctor WHERE email='$email'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Display the edit profile form
    echo "<div class='user-info'>";
    echo "<h2>$fullName</h2>";
    echo "</div>";

    echo "<div class='edit-profile-container'>";
    echo "<h1>Edit Profile</h1>";
    echo "<p>Welcome, $fullName!</p>"; // Add the user's name to the content container
    echo "<form class='edit-profile-form' method=\"POST\" action=\"Doctor_update.php\">";
    echo "<label for=\"fullName\">Full Name:</label>";
    echo "<input type=\"text\" id=\"fullName\" name=\"fullName\" value=\"" . $row['full_name'] . "\" required><br><br>";

    echo "<label for=\"gender\">Gender:</label>";
    echo "<select id=\"gender\" name=\"gender\">";
    echo "<option value=\"male\" " . ($row['gender'] === 'male' ? 'selected' : '') . ">Male</option>";
    echo "<option value=\"female\" " . ($row['gender'] === 'female' ? 'selected' : '') . ">Female</option>";
    echo "<option value=\"not_mention\" " . ($row['gender'] === 'not_mention' ? 'selected' : '') . ">Not Mention</option>";
    echo "</select><br><br>";

    echo "<label for=\"specialization\">Specialization:</label>";
    echo "<input type=\"text\" id=\"specialization\" name=\"specialization\" value=\"" . $row['specialization'] . "\" required><br><br>";

    echo "<label for=\"yearsOfExperience\">Years of Experience:</label>";
    echo "<input type=\"number\" id=\"yearsOfExperience\" name=\"yearsOfExperience\" value=\"" . $row['years_of_experience'] . "\" required><br><br>";

    echo "<label for=\"email\">Email:</label>";
    echo "<input type=\"email\" id=\"email\" name=\"email\" value=\"" . $row['email'] . "\" required><br><br>";

    echo "<label for=\"password\">Password:</label>";
    echo "<input type=\"password\" id=\"password\" name=\"password\" value=\"" . $row['password'] . "\" required><br><br>";

    echo "<label for=\"dateOfBirth\">Date of Birth:</label>";
    echo "<input type=\"date\" id=\"dateOfBirth\" name=\"dateOfBirth\" value=\"" . $row['Date_of_birth'] . "\" required><br><br>";

    echo "<label for=\"phoneNumber\">Phone Number:</label>";
    echo "<input type=\"tel\" id=\"phoneNumber\" name=\"phoneNumber\" value=\"" . $row['phone_number'] . "\" required><br><br>";

    echo "<label for=\"address\">Address:</label>";
    echo "<input type=\"text\" id=\"address\" name=\"address\" value=\"" . $row['address'] . "\" required><br><br>";

    echo "<input class=\"update-profile-button\" type=\"submit\" value=\"Update Profile\">";
    echo "</form>";

    // Add a back button
    echo "<button class=\"back-button\" onclick=\"window.location.href='Doctor_profile.php'\">Back</button>";
    echo "</div>";
  } else {
    echo "Doctor not found.";
  }
} else {
  echo "Invalid session. Please login again.";
}
?>

<style>
  body {
    background-image: url('doctorprofile.webp');
    /* Add the image as the background */
    background-size: cover;
    /* Make the image fit the screen */
    background-position: center;
    /* Center the background image */
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    /* Align content to the left */
    justify-content: center;
    /* Center the content vertically */
    height: 100vh;
    /* Set the height of the body to fill the viewport */
  }

  .user-info {
    text-align: center;
    margin-bottom: 20px;
  }

  .user-info h2 {
    color: #333;
  }

  .edit-profile-container {
    margin: 20px auto;
    width: 500px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #fff;
    /* Add a white background */
  }

  .edit-profile-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
  }

  .edit-profile-form input[type="text"],
  .edit-profile-form input[type="email"],
  .edit-profile-form input[type="password"],
  .edit-profile-form input[type="date"],
  .edit-profile-form input[type="tel"],
  .edit-profile-form select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 10px;
  }

  .edit-profile-form select {
    height: 38px;
  }

  .edit-profile-form .update-profile-button {
    padding: 8px 12px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .edit-profile-form .update-profile-button:hover {
    background-color: #555;
  }

  .back-button {
    padding: 8px 12px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
  }

  .back-button:hover {
    background-color: #555;
  }

  .back-button a {
    text-decoration: none;
    color: #fff;
  }
</style>

