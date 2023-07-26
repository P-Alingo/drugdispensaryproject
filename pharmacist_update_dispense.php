<?php
require_once("connection.php");

// Check if the dispense ID is provided
if (isset($_GET['dispense_id'])) {
  $dispenseID = $_GET['dispense_id'];

  // Retrieve the dispensed drug details based on the dispense ID
  $query = "SELECT * FROM view_drug_dispense WHERE dispense_id = '$dispenseID'";
  $result = $conn->query($query);

  if ($result !== false && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Display the edit form
    echo "<h1>Edit Dispensed Drug</h1>";
    echo "<form action=\"pharmacist_edit_dispense.php\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"dispense_id\" value=\"" . $row['dispense_id'] . "\">";
    echo "Prescription ID: <input type=\"text\" name=\"prescription_id\" value=\"" . $row['prescription_id'] . "\" required><br>";
    echo "Patient SSN: <input type=\"text\" name=\"patient_SSN\" value=\"" . $row['patient_SSN'] . "\" required><br>";
    echo "Patient Full Name: <input type=\"text\" name=\"patient_full_name\" value=\"" . $row['patient_full_name'] . "\" required><br>";
    echo "Doctor SSN: <input type=\"text\" name=\"doctor_SSN\" value=\"" . $row['doctor_SSN'] . "\" required><br>";
    echo "Doctor Full Name: <input type=\"text\" name=\"doctor_full_name\" value=\"" . $row['doctor_full_name'] . "\" required><br>";
    echo "Drug ID: <input type=\"text\" name=\"drug_id\" value=\"" . $row['drug_id'] . "\" required><br>";
    echo "Trace Name: <input type=\"text\" name=\"trace_name\" value=\"" . $row['trace_name'] . "\" required><br>";
    echo "Dosage: <input type=\"text\" name=\"dosage\" value=\"" . $row['dosage'] . "\" required><br>";
    echo "Quantity: <input type=\"text\" name=\"quantity\" value=\"" . $row['quantity'] . "\" required><br>";
    echo "Price: <input type=\"text\" name=\"price\" value=\"" . $row['price'] . "\" required><br>";
    echo "Date: <input type=\"text\" name=\"date\" value=\"" . $row['date'] . "\" required><br>";
    echo "<button type=\"submit\">Update</button>";
    echo "</form>";

    // Back button
    echo "<form action=\"pharmacist_all_dispense.php\">";
    echo "<button type=\"submit\">Back</button>";
    echo "</form>";
  } else {
    echo "Dispensed drug not found.";
  }
} else {
  echo "Invalid request.";
}

$conn->close();
?>
