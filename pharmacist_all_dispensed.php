<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
  // Retrieve the pharmacist's email from the session
  $email = $_SESSION['email'];

  // Get the pharmacist's full name
  $query = "SELECT full_name FROM pharmacist WHERE email = '$email'";
  $result = $conn->query($query);

  if ($result !== false && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fullName = $row['full_name'];

    // Display the pharmacist's full name
    echo "<h2>Welcome, $fullName</h2>";
  } else {
    echo "Pharmacist not found.";
  }
} else {
  echo "Invalid session. Please login again.";
}

// Fetch all dispensed drugs from the view_drug_dispense table
$query = "SELECT * FROM view_drug_dispense";
$result = $conn->query($query);

if ($result !== false && $result->num_rows > 0) {
  echo "<h1>Dispensed Drugs</h1>";
  echo "<table>";
  echo "<tr><th>Dispense ID</th><th>Prescription ID</th><th>Patient SSN</th><th>Patient Full Name</th><th>Doctor SSN</th><th>Doctor Full Name</th><th>Drug ID</th><th>Trace Name</th><th>Dosage</th><th>Quantity</th><th>Price</th><th>Date</th><th>Actions</th></tr>";

  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['dispense_id'] . "</td>";
    echo "<td>" . $row['prescription_id'] . "</td>";
    echo "<td>" . $row['patient_SSN'] . "</td>";
    echo "<td>" . $row['patient_full_name'] . "</td>";
    echo "<td>" . $row['doctor_SSN'] . "</td>";
    echo "<td>" . $row['doctor_full_name'] . "</td>";
    echo "<td>" . $row['drug_id'] . "</td>";
    echo "<td>" . $row['trace_name'] . "</td>";
    echo "<td>" . $row['dosage'] . "</td>";
    echo "<td>" . $row['quantity'] . "</td>";
    echo "<td>" . $row['price'] . "</td>";
    echo "<td>" . $row['date'] . "</td>";
    echo "<td>";
    echo "<a href=\"pharmacist_edit_dispense.php?dispense_id=" . $row['dispense_id'] . "\" class='action-button'>Edit</a> | ";
    echo "<a href=\"pharmacist_delete_dispense.php?dispense_id=" . $row['dispense_id'] . "\" class='action-button'>Delete</a>";
    echo "</td>";
    echo "</tr>";
  }

  echo "</table>";
  echo "<form method='GET' action='pharmacistpage.php'>";
  echo "<input type='submit' value='Back' class='back-button'>";
  echo "</form>";
} else {
  echo "No dispensed drugs found.";
}

$conn->close();
?>

<style>
  h2 {
    color: #333;
    margin-bottom: 20px;
  }

  h1 {
    color: #333;
    margin-bottom: 10px;
  }

  table {
    border-collapse: collapse;
    width: 100%;
  }

  th,
  td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
  }

  th {
    background-color: #f2f2f2;
  }

  .action-button {
    display: inline-block;
    padding: 4px 8px;
    background-color: indigo;
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 5px;
  }

  .action-button:hover {
    background-color: #4b0082;
  }

  .back-button {
    display: inline-block;
    padding: 8px 16px;
    background-color: indigo;
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .back-button:hover {
    background-color: #4b0082;
  }

  form {
    margin-top: 20px;
  }
  body{
  background-image: url('adminviewusers.jpg'); /* Add the image as the background */
      background-size: cover; /* Make the image fit the screen */
      background-position: center; /* Center the background image */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: Arial, sans-serif;}
</style>
