<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-image: url('adminmanagedrugs.jpeg');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            padding: 20px;
            margin: 20px;
            width: 80%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .user-info {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center; /* Center-align the user info */
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="submit"] {
            padding: 5px;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: black; /* Update the background color to black */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4b45a0;
        }

        .back-button {
            padding: 5px 0; /* Adjust the vertical padding to make the button the same size */
            width: 100%; /* Set the width to 100% */
            background-color: black; /* Update the background color to black */
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
            text-align: center; /* Center-align the text */
        }

        .back-button:hover {
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <div class="card">
        <?php
        require_once("connection.php");

        // Start the session
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['drug_id'])) {
            $drugID = $_GET['drug_id'];

            // Check if the 'full_name' key is set in the session
            if (isset($_SESSION['full_name'])) {
                // Retrieve the administrator's name from the session
                $full_Name = $_SESSION['full_name'];

                echo "<div class='user-info' style='font-size: 24px;'>";
                echo " $full_Name";
                echo "</div>";
            }

            // Retrieve the drug details from the database
            $query = "SELECT * FROM drugs WHERE drug_id='$drugID'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                // Fetch the drug's details
                $drugRow = $result->fetch_assoc();
                $traceName = $drugRow['Trace_name'];
                $price = $drugRow['price'];
                $quantity = $drugRow['quantity'];

                // Display the form for editing the drug
                echo "<h2>Edit Drug</h2>";
                echo "<form method='POST' action='http://localhost/practicephp/admin_update_drugs.php'>";
                echo "<input type='hidden' name='drug_id' value='$drugID'>";
                echo "<label for='trace_name'>Trace Name:</label>";
                echo "<input type='text' name='trace_name' value='$traceName' required>";
                echo "<br>";
                echo "<label for='price'>Price:</label>";
                echo "<input type='text' name='price' value='$price' required>";
                echo "<br>";
                echo "<label for='quantity'>Quantity:</label>";
                echo "<input type='text' name='quantity' value='$quantity' required>";
                echo "<br>";
                echo "<input type='submit' value='Update Drug'>";
                echo "<a href='admin_view_drugs.php' class='back-button'>Back</a>"; // Move the "Back" button here
                echo "</form>";
            } else {
                echo "Drug not found.";
            }
        } else {
            echo "Invalid request.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
