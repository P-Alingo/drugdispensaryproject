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

        .card {
            width: 350px; /* Set the width of the card */
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
            /* Add a white background */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            float: left; /* Float the card to the left */
            margin-right: 20px; /* Add some right margin for spacing */
        }

        p {
            margin-bottom: 10px;
            font-size: 16px; /* Increase font size for content */
            color: #444; /* Darken text color */
        }

        .button-container {
            text-align: center;
        }

        .button-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 10px; /* Add right margin to separate buttons */
            cursor: pointer;
        }

        .button-container button:last-child {
            margin-right: 0; /* Remove right margin from the last button */
        }

        button:hover {
            background-color: #333;
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
            echo "Welcome, $full_Name!";
            echo "</div>";
            

            // Display the admin's profile within a card
            echo "<div class='card'>";
            echo "<h1 style='color: #333;'>Admin Profile</h1>";
            echo "<p><strong>Admin ID:</strong> " . $adminRow['admin_id'] . "</p>";
            echo "<p><strong>Full Name:</strong> " . $adminRow['full_name'] . "</p>";
            echo "<p><strong>Gender:</strong> " . $adminRow['gender'] . "</p>";
            echo "<p><strong>Email:</strong> " . $adminRow['email'] . "</p>";
            echo "<p><strong>Password:</strong> " . $adminRow['password'] . "</p>";
            echo "<p><strong>Date of Birth:</strong> " . $adminRow['date_of_birth'] . "</p>";
            echo "<p><strong>Phone Number:</strong> " . $adminRow['phone_number'] . "</p>";
            echo "<p><strong>Address:</strong> " . $adminRow['address'] . "</p>";

            // Button container
            echo "<div class='button-container'>";
            
            // Edit button
            echo "<button onclick='goToEdit()'>Edit Profile</button>";
            echo "<script>";
            echo "function goToEdit() {";
            echo "  window.location.href = 'admin_edit.php';";
            echo "}";
            echo "</script>";

            // Back button
            echo "<button onclick=\"window.location.href='Adminpage.php'\">Back</button>";
            
            echo "</div>"; // Close the button container

            echo "</div>"; // Close the card
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
