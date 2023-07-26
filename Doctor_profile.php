<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the doctor's email from the session
  $email = $_SESSION['email'];

  // Retrieve the doctor's details from the database
  $query = "SELECT * FROM doctor WHERE email='$email'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Store the doctor's full name in the session
    $_SESSION['full_name'] = $row['full_name'];

    // Retrieve the full name from the session
    $full_Name = $_SESSION['full_name'];

    // Welcome message
    echo "<div class='user-info'>";
    echo "<h2> $full_Name</h2>";
    echo "</div>";

    
    // Content container for the doctor's profile details
    echo "<div class='content-container'>";

    echo "<h1>Doctor Profile</h1>";
    echo "<div class='profile-details'>";
  }
    if (isset($row['doctor_id'])) {
      echo "<p><strong>Doctor ID:</strong> " . $row['doctor_id'] . "</p>";
    }

    if (isset($row['full_name'])) {
      echo "<p><strong>Full Name:</strong> " . $row['full_name'] . "</p>";
    }

    if (isset($row['gender'])) {
      echo "<p><strong>Gender:</strong> " . $row['gender'] . "</p>";
    }

    if (isset($row['specialization'])) {
      echo "<p><strong>Specialization:</strong> " . $row['specialization'] . "</p>";
    }

    if (isset($row['years_of_experience'])) {
      echo "<p><strong>Years of Experience:</strong> " . $row['years_of_experience'] . "</p>";
    }

    if (isset($row['email'])) {
      echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
    }

    if (isset($row['password'])) {
      echo "<p><strong>Password:</strong> " . $row['password'] . "</p>";
    }

    if (isset($row['Date_of_birth'])) {
      echo "<p><strong>Date of Birth:</strong> " . $row['Date_of_birth'] . "</p>";
    }

    if (isset($row['phone_number'])) {
      echo "<p><strong>Phone Number:</strong> " . $row['phone_number'] . "</p>";
    }

    if (isset($row['address'])) {
      echo "<p><strong>Address:</strong> " . $row['address'] . "</p>";
    }

    echo "</div>";
    echo "</div>"; // Close the content-container div

    // Provide an option to edit the profile
    echo "<button class='edit-profile'><a href=\"Doctor_edit.php\">Edit Profile</a></button>"; // Updated link to Doctor_edit.php wrapped in a button

    // Add a "Back" button
    echo "<button class='back-button'><a href=\"doctorpage.php\">Back</a></button>";
  } else {
    echo "Doctor not found.";
  
  echo "Invalid session. Please login again.";
}

$conn->close();
?>


<style>


 body {
          background-image: url('doctorprofile.webp'); /* Add the image as the background */
          background-size: cover; /* Make the image fit the screen */
          background-position: center; /* Center the background image */
          display: flex;
          flex-direction: column;
          align-items: flex-start; /* Align content to the left */
          justify-content: center; /* Center the content vertically */
          height: 100vh; /* Set the height of the body to fill the viewport */
          padding: 20px;
          font-family: Arial, sans-serif;
        }
.user-info {
  text-align: center;
  margin-bottom: 20px;
}

.user-info h2 {
  color: #333;
}

h1 {
  text-align: center;
  color: #333;
  margin-bottom: 10px;
}

.profile-details {
  margin-top: 20px;
  border: 1px solid #ddd;
  padding: 10px;
  border-radius: 4px;
}

.profile-details p {
  margin-bottom: 5px;
}

.edit-profile,
.back-button {
  padding: 8px 12px;
  background-color: #333;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 10px;
}

.edit-profile:hover,
.back-button:hover {
  background-color: #555;
}

.edit-profile a,
.back-button a {
  text-decoration: none;
  color: #fff;
}
.content-container {
  background-color: #fff;
  padding: 20px;
  border-radius: 4px;
}
</style>

