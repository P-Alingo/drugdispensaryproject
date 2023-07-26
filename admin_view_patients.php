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
    <title>Admin View Patients</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
            background-color: black;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 10px;
        }

        .button:hover {
            background-color: #333; /* Update the hover background color to a darker shade of black */
        }
    </style>
</head>
<body>
<?php
// Retrieve all patients from the patient table
$query = "SELECT * FROM patient";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Display patient information in a table
    echo "<table>";
    echo "<tr>
            <th>SSN</th>
            <th>Full Name</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Date of Birth</th>
            <th>Age</th>
            <th>Phone Number</th>
            <th>Address</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['SSN']."</td>";
        echo "<td>".$row['full_name']."</td>";
        echo "<td>".$row['gender']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['date_of_birth']."</td>";
        echo "<td>".$row['age']."</td>";
        echo "<td>".$row['phone_number']."</td>";
        echo "<td>".$row['address']."</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No patients found.";
}

$conn->close();
?>

<a href="admin_view_users.php" class="button">Back</a>

</body>
</html>



