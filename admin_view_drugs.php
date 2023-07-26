<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'full_name' key is set in the session
if (isset($_SESSION['full_name'])) {
    // Retrieve the administrator's name from the session
    $full_Name = $_SESSION['full_name'];

    echo "<div class='user-info' style='font-size: 24px;'>";
    echo " $full_Name";
    echo "</div>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Manage Drugs</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .user-info {
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: black; /* Update the background color to black */
            color: white;
        }

        a {
            color: black; /* Update the color to black */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .edit-button {
            background-color: black; /* Update the background color to black */
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .delete-button {
            background-color: black; /* Update the background color to black */
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .back-button {
            display: inline-block;
            padding: 5px 10px;
            background-color: black; /* Update the background color to black */
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
    // Handle delete request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['drug_id'])) {
        $drugId = $_POST['drug_id'];
        // Perform deletion operation
        $deleteQuery = "DELETE FROM drugs WHERE drug_id = $drugId";
        if ($conn->query($deleteQuery) === TRUE) {
            echo "Record deleted successfully.<br>";
        } else {
            echo "Error deleting record: " . $conn->error . "<br>";
        }
    }

    // Fetch all drugs from the database
    $query = "SELECT * FROM drugs";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Display the table header
        echo "<table>";
        echo "<tr>";
        echo "<th>Drug ID</th>";
        echo "<th>Trace Name</th>";
        echo "<th>Price</th>";
        echo "<th>Quantity</th>";
        echo "<th>Edit</th>";
        echo "<th>Delete</th>";
        echo "</tr>";

        // Fetch and display each drug's details
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['drug_id']."</td>";
            echo "<td>".$row['Trace_name']."</td>";
            echo "<td>".$row['price']."</td>";
            echo "<td>".$row['quantity']."</td>";
            echo "<td><a class='edit-button' href='admin_edit_drugs.php?drug_id=".$row['drug_id']."'>Edit</a></td>";
            echo "<td>";
            echo "<form method='POST' action=''>"; // Submit the form to the same page
            echo "<input type='hidden' name='drug_id' value='".$row['drug_id']."'>";
            echo "<input type='submit' class='delete-button' value='Delete'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No drugs found.";
    }

    $conn->close();
    ?>

    <a class="back-button" href="admin_manage_drugs.php">Back</a>
</body>
</html>
