<!DOCTYPE html>
<html>

<head>
    <title>Pharmacist Profile</title>
    <style>
        body {
            background-image: url('pharmacistprofile.jpeg'); /* Add the image as the background */
            background-size: cover; /* Make the image fit the screen */
            background-position: center; /* Center the background image */
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

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            text-align: left;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid #ccc;
            margin-right: 20px; /* Push the card to the left */
            float: left; /* Allow the card to float left */
        }

        h1 {
            color: #333;
        }

        .user-info {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 18px;
            background-color: #0074e4; /* Blue background color */
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 10px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3; /* Darker blue on hover */
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
        // Retrieve the pharmacist's email from the session
        $email = $_SESSION['email'];

        // Retrieve the pharmacist's details from the database
        $pharmacistQuery = "SELECT * FROM pharmacist WHERE email='$email'";
        $pharmacistResult = $conn->query($pharmacistQuery);

        if ($pharmacistResult->num_rows > 0) {
            // Fetch the pharmacist's details
            $pharmacistRow = $pharmacistResult->fetch_assoc();
    ?>
            <div class='card'>
                <div class='user-info'>
                    <?php echo $pharmacistRow['full_name']; ?>
                </div>
                <h1>Pharmacist Profile</h1>
                <p>Employee ID: <?php echo $pharmacistRow['employee_id']; ?></p>
                <p>Full Name: <?php echo $pharmacistRow['full_name']; ?></p>
                <p>Gender: <?php echo $pharmacistRow['gender']; ?></p>
                <p>Email: <?php echo $pharmacistRow['email']; ?></p>
                <p>Password: <?php echo $pharmacistRow['password']; ?></p>
                <p>Date of Birth: <?php echo $pharmacistRow['date_of_birth']; ?></p>
                <p>Phone Number: <?php echo $pharmacistRow['phone_number']; ?></p>
                <p>Address: <?php echo $pharmacistRow['address']; ?></p>

                <!-- Edit button -->
                <form method='post' action='pharmacist_edit.php'>
                    <input type='submit' value='Edit Profile'>
                </form>

                <!-- Back button -->
                <form method='post' action='pharmacistpage.php'>
                    <input type='submit' value='Back'>
                </form>
            </div>
    <?php
        } else {
            echo "Pharmacist not found.";
        }
    } else {
        echo "Invalid session. Please login again.";
    }

    $conn->close();
    ?>
</body>

</html>
