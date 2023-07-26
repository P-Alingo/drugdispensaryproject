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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the form data
  $dispenseID = $_POST['dispense_id'];
  $prescriptionID = $_POST['prescription_id'];
  $patientSSN = $_POST['patient_SSN'];
  $patientFullName = $_POST['patient_full_name'];
  $doctorSSN = $_POST['doctor_SSN'];
  $doctorFullName = $_POST['doctor_full_name'];
  $drugID = $_POST['drug_id'];
  $traceName = $_POST['trace_name'];
  $dosage = $_POST['dosage'];
  $quantity = $_POST['quantity'];
  $price = $_POST['price'];
  $date = $_POST['date'];

  // Update the dispensed drug details in the drug_dispense table
  $updateQuery = "UPDATE drug_dispense SET
                  prescription_id = '$prescriptionID',
                  patient_SSN = '$patientSSN',
                  patient_full_name = '$patientFullName',
                  doctor_SSN = '$doctorSSN',
                  doctor_full_name = '$doctorFullName',
                  drug_id = '$drugID',
                  trace_name = '$traceName',
                  dosage = '$dosage',
                  quantity = '$quantity',
                  price = '$price',
                  date = '$date'
                  WHERE dispense_id = '$dispenseID'";
  $updateResult = $conn->query($updateQuery);

  if ($updateResult === true) {
    header("Location: pharmacist_all_dispensed.php");
    exit;
  } else {
    echo "Error updating dispensed drug: " . $conn->error;
  }

  $conn->close();
}

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
    echo "<button type=\"submit\" class=\"indigo-button\">Update</button>";
    echo "</form>";

    // Back button
    echo "<form action=\"pharmacist_all_dispensed.php\">";
    echo "<button type=\"submit\" class=\"indigo-button\">Back</button>";
    echo "</form>";
  } else {
    echo "Dispensed drug not found.";
  }
} else {
  echo "Invalid request.";
}

$conn->close();
?>

<style>
  h2 {
    color: #333;
  }

  h1 {
    color: #333;
    margin-bottom: 10px;
  }

  form {
    margin-bottom: 10px;
  }

  input[type='text'] {
    padding: 8px;
    width: 250px;
    margin-bottom: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
  }

  .indigo-button {
    display: inline-block;
    padding: 8px 16px;
    background-color: indigo;
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 10px;
  }

  .indigo-button:hover {
    background-color: #4b0082;
  }
</style>
