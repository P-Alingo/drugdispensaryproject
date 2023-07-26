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

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Retrieve the submitted form data
      $prescriptionID = $_POST['prescription_id'];
      $drugID = $_POST['drug_id'];
      $patientSSN = $_POST['patient_SSN'];
      $patientFullName = $_POST['patient_full_name'];
      $doctorSSN = $_POST['doctor_SSN'];
      $doctorFullName = $_POST['doctor_full_name'];
      $traceName = $_POST['trace_name'];
      $date = $_POST['date'];
      $dosage = $_POST['dosage'];
      $quantity = $_POST['quantity'];
      $price = $_POST['price'];

      // Validate form fields
      if (empty($prescriptionID) || empty($drugID) || empty($patientSSN) || empty($patientFullName) || empty($doctorSSN) || empty($doctorFullName) || empty($traceName) || empty($date) || empty($dosage) || empty($quantity) || empty($price)) {
        header("Location: pharmacist_manage_dispense.php");
      } else {
        // Check if the prescription is already dispensed
        $checkQuery = "SELECT * FROM drug_dispense WHERE prescription_id = '$prescriptionID'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult !== false && $checkResult->num_rows > 0) {
          header("Location: pharmacist_manage_dispense.php");
          echo "Prescription already dispensed.";
        } else {
          // Insert the drug dispense details into the database
          $insertQuery = "INSERT INTO drug_dispense (prescription_id, drug_id, patient_SSN, patient_full_name, doctor_SSN, doctor_full_name, trace_name, date, dosage, quantity, price) VALUES ('$prescriptionID', '$drugID', '$patientSSN', '$patientFullName', '$doctorSSN', '$doctorFullName', '$traceName', '$date', '$dosage', '$quantity', '$price')";
          $insertResult = $conn->query($insertQuery);

          if ($insertResult === true) {
            // Redirect to pharmacist_manage_dispense.php
            header("Location: pharmacist_manage_dispense.php");
            exit(); // Make sure to exit after redirection
          } else {
            echo "Error dispensing drug: " . $conn->error;
          }
        }
      }
    } else {
      echo "Invalid request. Please submit the form.";
    }
  } else {
    echo "Pharmacist not found.";
  }
} else {
  echo "Invalid session. Please login again.";
}

$conn->close();
?>

