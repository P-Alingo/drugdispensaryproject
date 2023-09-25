<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-image: url('pharmacistprofile.jpeg');
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

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            padding: 20px;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .user-info {
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type='text'],
        input[type='password'] {
            padding: 8px;
            width: 250px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input[type='submit'] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #00008B; /* Dark blue background color */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type='submit']:hover {
            background-color: #0000CD; /* Darker blue color on hover */
        }

        form input[type='submit'] {
            margin-right: 10px;
        }

        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="card">
        <?php
        require_once("connection.php");

        // Start the session
        session_start();

        // Check if the 'email' key is set in the session
        if (isset($_SESSION['email'])) {
            // Retrieve the pharmacist's email from the session
            $email = $_SESSION['email'];

            // Retrieve the pharmacist's details from the database
            $pharmacistQuery = "SELECT * FROM pharmacist WHERE email='$email'";
            $pharmacistResult = $conn->query($pharmacistQuery);

            if ($pharmacistResult->num_rows > 0) {
                // Fetch the pharmacist's details
                $pharmacistRow = $pharmacistResult->fetch_assoc();

                // Display the welcome message with the pharmacist's name at the top
                echo "<div class='user-info' style='font-size: 24px;'>";
                echo "Welcome, " . $pharmacistRow['full_name'] . "!";
                echo "</div>";

                echo "<h1>Pharmacist Profile</h1>";
                echo "<form method='post' action='pharmacist_update.php'>";
                echo "<label for='fullName'>Full Name:</label>";
                echo "<input type='text' id='fullName' name='fullName' value='" . $pharmacistRow['full_name'] . "' required><br>";
                echo "<label for='gender'>Gender:</label>";
                echo "<input type='text' id='gender' name='gender' value='" . $pharmacistRow['gender'] . "' required><br>";
                echo "<label for='email'>Email:</label>";
                echo "<input type='text' id='email' name='email' value='" . $pharmacistRow['email'] . "' required><br>";
                echo "<label for='password'>Password:</label>";
                echo "<input type='password' id='password' name='password' value='" . $pharmacistRow['password'] . "' required><br>";
                echo "<label for='dateOfBirth'>Date of Birth:</label>";
                echo "<input type='text' id='dateOfBirth' name='dateOfBirth' value='" . $pharmacistRow['date_of_birth'] . "' required><br>";
                echo "<label for='phoneNumber'>Phone Number:</label>";
                echo "<input type='text' id='phoneNumber' name='phoneNumber' value='" . $pharmacistRow['phone_number'] . "' required><br>";
                echo "<label for='address'>Address:</label>";
                echo "<input type='text' id='address' name='address' value='" . $pharmacistRow['address'] . "' required><br>";
                echo "<input type='submit' value='Update Profile'>";
                echo "</form>";

                // Back button
                echo "<form method='post' action='pharmacist_profile.php'>";
                echo "<input type='submit' value='Back'>";
                echo "</form>";
            } else {
                echo "Pharmacist not found.";
            }
        } else {
            echo "Invalid session. Please login again.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
