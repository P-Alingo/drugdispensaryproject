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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin View Pharmacists</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 20px; /* Update the padding to create space at the top */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

        .user-info {
            margin-bottom: 20px;
        }

        .button {
            padding: 10px 20px;
            font-size: 18px;
            background-color: black; /* Update the background color to black */
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php
// Retrieve all pharmacists from the database
$query = "SELECT * FROM pharmacist";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Display the table header
    echo "<table>";
    echo "<tr>";
    echo "<th>Employee ID</th>"; // Updated 'SSN' to 'Employee ID'
    echo "<th>Full Name</th>";
    echo "<th>Gender</th>";
    echo "<th>Email</th>";
    echo "<th>Date of Birth</th>";
    echo "<th>Phone Number</th>";
    echo "<th>Address</th>";
    echo "</tr>";

    // Display each pharmacist as a table row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['employee_id']."</td>";
        echo "<td>".$row['full_name']."</td>";
        echo "<td>".$row['gender']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['date_of_birth']."</td>";
        echo "<td>".$row['phone_number']."</td>";
        echo "<td>".$row['address']."</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No pharmacists found.";
}

$conn->close();
?>

<a href="admin_view_users.php" class="button">Back</a>
</body>
</html>
