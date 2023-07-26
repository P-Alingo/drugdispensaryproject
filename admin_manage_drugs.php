<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'full_name' key is set in the session
if (isset($_SESSION['full_name'])) {
    // Retrieve the user's name from the session
    $full_Name = $_SESSION['full_name'];
}

echo "<div class='user-info' style='font-size: 24px;'>";
echo " $full_Name";
echo "</div>";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $full_Name = $_SESSION['full_name'];
    $traceName = $_POST['trace_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Insert the new drug into the database
    $insertQuery = "INSERT INTO drugs (Trace_name, price, quantity) VALUES ('$traceName', '$price', '$quantity')";
    if ($conn->query($insertQuery) === TRUE) {
        echo "Drug added successfully.";
    } else {
        echo "Error adding drug: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Manage Drug</title>
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

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 300px;
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
            background-color: #333; /* Update the hover background color to a darker shade of black */
        }
    </style>
</head>
<body>
    <form method="POST" action="admin_manage_drugs.php">
        <label for="trace_name">Trace Name:</label>
        <input type="text" name="trace_name" id="trace_name" required>
        <br>
        <label for="price">Price:</label>
        <input type="text" name="price" id="price" required>
        <br>
        <label for="quantity">Quantity:</label>
        <input type="text" name="quantity" id="quantity" required>
        <br>
        <input type="submit" value="Add Drug">
    </form>

    <form method="GET" action="admin_view_drugs.php">
        <input type="submit" value="View All Drugs">
    </form>
    <form method="GET" action="adminpage.php">
        <input type="submit" value="Back">
    </form>
</body>
</html>



