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
  }
}

// Fetch prescription data from view_prescriptions
$query = "SELECT prescription_id, drug_id, patient_SSN, patient_full_name, doctor_SSN, doctor_full_name, trace_name, date, dosage, quantity, price FROM view_prescription";
$result = $conn->query($query);

if ($result !== false && $result->num_rows > 0) {
  echo "<h1>All Prescriptions</h1>";
  echo "<table>";
  echo "<tr>
          <th style='color: black;'>Prescription ID</th>
          <th style='color: black;'>Drug ID</th>
          <th style='color: black;'>Patient SSN</th>
          <th style='color: black;'>Patient Full Name</th>
          <th style='color: black;'>Doctor SSN</th>
          <th style='color: black;'>Doctor Full Name</th>
          <th style='color: black;'>Trace Name</th>
          <th style='color: black;'>Date</th>
          <th style='color: black;'>Dosage</th>
          <th style='color: black;'>Quantity</th>
          <th style='color: black;'>Price</th>
        </tr>";

  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td style='color: black;'>" . $row['prescription_id'] . "</td>";
    echo "<td style='color: black;'>" . $row['drug_id'] . "</td>";
    echo "<td style='color: black;'>" . $row['patient_SSN'] . "</td>";
    echo "<td style='color: black;'>" . $row['patient_full_name'] . "</td>";
    echo "<td style='color: black;'>" . $row['doctor_SSN'] . "</td>";
    echo "<td style='color: black;'>" . $row['doctor_full_name'] . "</td>";
    echo "<td style='color: black;'>" . $row['trace_name'] . "</td>";
    echo "<td style='color: black;'>" . $row['date'] . "</td>";
    echo "<td style='color: black;'>" . $row['dosage'] . "</td>";
    echo "<td style='color: black;'>" . $row['quantity'] . "</td>";
    echo "<td style='color: black;'>" . $row['price'] . "</td>";
    echo "</tr>";
  }

  echo "</table>";

  // Display the back button
  echo "<form method='GET' action='pharmacistpage.php'>";
  echo "<input type='submit' value='Back' class='back-button'>";
  echo "</form>";
} else {
  echo "No prescriptions found.";
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

  body {
    background-image: url('adminviewusers.jpg'); /* Add the image as the background */
    background-size: cover; /* Make the image fit the screen */
    background-position: center; /* Center the background image */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding-top: 50px;
    margin: 0;
    font-family: Arial, sans-serif;
    color: white; /* Set the default text color to white */
  }
</style>
