<!DOCTYPE html>
<html>
<head>
  <title>Admin Profile</title>
  <style>
    body {
      background-image: url('adminprofile.jpeg');
      background-size: cover;
      background-position: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 20px;
      font-family: Arial, sans-serif;
      margin: 0;
    }

    h1 {
      color: #333;
      margin-bottom: 20px;
    }

    .user-info {
      font-size: 24px; /* Increase the font size */
      font-weight: bold;
      margin-bottom: 20px;
    }

    form {
      display: flex;
      flex-direction: column;
      align-items: center; /* Center the form items horizontally */
      width: 400px; /* Increase the width of the form */
      background-color: #f5f5f5; /* Light gray background color */
      padding: 40px; /* Increase the padding to 40px */
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    label {
      font-weight: bold;
      margin-bottom: 5px;
    }

    input,
    select {
      padding: 5px;
      margin-bottom: 10px;
      width: 100%;
      box-sizing: border-box;
    }

    input[type="submit"] {
      background-color: #000; /* Set the button background color to black */
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #333; /* Darken the button on hover */
    }

    button {
      display: block;
      padding: 10px 20px;
      font-size: 16px;
      background-color: #000; /* Set the button background color to black */
      color: white;
      border: none;
      border-radius: 4px;
      text-decoration: none;
      margin-top: 10px;
      cursor: pointer;
    }

    button:hover {
      background-color: #333; /* Darken the button on hover */
    }
  </style>
</head>
<body>
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
      echo " $full_Name";
      echo "</div>";

      // Display the edit profile form
      echo "<h1>Edit Profile</h1>";
      echo "<form method='POST' action='admin_update.php'>";
      echo "<label for='admin_id'>Admin ID:</label>";
      echo "<input type='text' id='admin_id' name='admin_id' value='" . $adminRow['admin_id'] . "' readonly><br>";

      echo "<label for='full_name'>Full Name:</label>";
      echo "<input type='text' id='full_name' name='full_name' value='" . $adminRow['full_name'] . "' required><br>";

      echo "<label for='gender'>Gender:</label>";
      echo "<select id='gender' name='gender'>";
      echo "<option value='male'" . ($adminRow['gender'] === 'male' ? ' selected' : '') . ">Male</option>";
      echo "<option value='female'" . ($adminRow['gender'] === 'female' ? ' selected' : '') . ">Female</option>";
      echo "<option value='not_mention'" . ($adminRow['gender'] === 'not_mention' ? ' selected' : '') . ">Not Mention</option>";
      echo "</select><br>";

      echo "<label for='email'>Email:</label>";
      echo "<input type='email' id='email' name='email' value='" . $adminRow['email'] . "' required><br>";

      echo "<label for='password'>Password:</label>";
      echo "<input type='password' id='password' name='password' value='" . $adminRow['password'] . "' required><br>";

      echo "<label for='date_of_birth'>Date of Birth:</label>";
      echo "<input type='date' id='date_of_birth' name='date_of_birth' value='" . $adminRow['date_of_birth'] . "' required><br>";

      echo "<label for='phone_number'>Phone Number:</label>";
      echo "<input type='tel' id='phone_number' name='phone_number' value='" . $adminRow['phone_number'] . "' required><br>";

      echo "<label for='address'>Address:</label>";
      echo "<input type='text' id='address' name='address' value='" . $adminRow['address'] . "' required><br>";

      echo "<input type='submit' value='Update Profile'>";
      echo "</form>";

      // Back button
      echo "<button onclick=\"window.location.href='admin_profile.php'\">Back</button>";
    } else {
      echo "Admin not found.";
    }
  } else {
    echo "Invalid session. Please login again.";
  }

  $conn->close();
  ?>
</body>
</html>
