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
    if (isset($_GET['search'])) {
      $search = $_GET['search'];

      $query = "SELECT prescription_id, drug_id, patient_SSN, patient_full_name, doctor_SSN, doctor_full_name, trace_name, date, dosage, quantity
                FROM view_prescription
                WHERE patient_SSN LIKE '%$search%' OR patient_full_name LIKE '%$search%'";
      $result = $conn->query($query);
    } else {
      $query = "SELECT prescription_id, drug_id, patient_SSN, patient_full_name, doctor_SSN, doctor_full_name, trace_name, date, dosage, quantity
                FROM view_prescription";
      $result = $conn->query($query);
    }

    if ($result !== false && $result->num_rows > 0) {
      echo "<h1>Select a Patient</h1>";
      echo "<form method='POST' action=''>";
      echo "<select name='patient'>";

      $result->data_seek(0);
      while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['patient_SSN'] . "'>" . $row['patient_full_name'] . "</option>";
      }

      echo "</select>";
      echo "<input type='submit' value='View Prescription'>";
      echo "</form>";

      if (isset($_POST['patient'])) {
        $selectedPatient = $_POST['patient'];

        $prescriptionQuery = "SELECT prescription_id, drug_id, patient_SSN, patient_full_name, doctor_SSN, doctor_full_name, trace_name, date, dosage, quantity
                              FROM view_prescription
                              WHERE patient_SSN = '$selectedPatient'";
        $prescriptionResult = $conn->query($prescriptionQuery);

        if ($prescriptionResult !== false && $prescriptionResult->num_rows > 0) {
          echo "<h2>Selected Patient's Prescription Details</h2>";
          echo "<table>";
          echo "<tr><th>Prescription ID</th><th>Drug ID</th><th>Patient SSN</th><th>Patient Full Name</th><th>Doctor SSN</th><th>Doctor Full Name</th><th>Trace Name</th><th>Date</th><th>Dosage</th><th>Quantity</th></tr>";

          while ($prescriptionRow = $prescriptionResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $prescriptionRow['prescription_id'] . "</td>";
            echo "<td>" . $prescriptionRow['drug_id'] . "</td>";
            echo "<td>" . $prescriptionRow['patient_SSN'] . "</td>";
            echo "<td>" . $prescriptionRow['patient_full_name'] . "</td>";
            echo "<td>" . $prescriptionRow['doctor_SSN'] . "</td>";
            echo "<td>" . $prescriptionRow['doctor_full_name'] . "</td>";
            echo "<td>" . $prescriptionRow['trace_name'] . "</td>";
            echo "<td>" . $prescriptionRow['date'] . "</td>";
            echo "<td>" . $prescriptionRow['dosage'] . "</td>";
            echo "<td>" . $prescriptionRow['quantity'] . "</td>";
            echo "</tr>";
          }

          echo "</table>";

          // Dispense Drug form
          echo "<h1>Dispense Drugs</h1>";
          echo "<form action=\"\" method=\"post\">";
          echo "<input type=\"hidden\" name=\"patient\" value=\"$selectedPatient\">";
          echo "Prescription ID: <input type=\"text\" name=\"prescription_id\"><br>";
          echo "Drug ID: <input type=\"text\" name=\"drug_id\"><br>";
          echo "Patient SSN: <input type=\"text\" name=\"patient_SSN\"><br>";
          echo "Patient Full Name: <input type=\"text\" name=\"patient_full_name\"><br>";
          echo "Doctor SSN: <input type=\"text\" name=\"doctor_SSN\"><br>";
          echo "Doctor Full Name: <input type=\"text\" name=\"doctor_full_name\"><br>";
          echo "Trace Name: <input type=\"text\" name=\"trace_name\"><br>";
          echo "Date: <input type=\"text\" name=\"date\"><br>";
          echo "Dosage: <input type=\"text\" name=\"dosage\"><br>";
          echo "Quantity: <input type=\"text\" name=\"quantity\"><br>";
          echo "Price: <input type=\"text\" name=\"price\"><br>";
          echo "<button type=\"submit\" class=\"indigo-button\" name=\"dispense\">Dispense Drug</button>";
          echo "</form>";
        } else {
          echo "No prescription found for the selected patient.";
        }
      }

      // Check if the dispense form is submitted
      if (isset($_POST['dispense'])) {
        $selectedPatient = $_POST['patient'];

        // Get the patient's prescription details
        $prescriptionQuery = "SELECT prescription_id, drug_id, patient_SSN, patient_full_name, doctor_SSN, doctor_full_name, trace_name, date, dosage, quantity
                              FROM view_prescription
                              WHERE patient_SSN = '$selectedPatient'";
        $prescriptionResult = $conn->query($prescriptionQuery);

        if ($prescriptionResult !== false && $prescriptionResult->num_rows > 0) {
          $prescriptionRow = $prescriptionResult->fetch_assoc();

          $prescriptionID = $prescriptionRow['prescription_id'];
          $drugID = $prescriptionRow['drug_id'];
          $patientSSN = $prescriptionRow['patient_SSN'];
          $patientFullName = $prescriptionRow['patient_full_name'];
          $doctorSSN = $prescriptionRow['doctor_SSN'];
          $doctorFullName = $prescriptionRow['doctor_full_name'];
          $traceName = $prescriptionRow['trace_name'];
          $date = $prescriptionRow['date'];
          $dosage = $prescriptionRow['dosage'];
          $quantity = $prescriptionRow['quantity'];
          $price = $_POST['price'];

          // Check if any required field is empty
          if (empty($prescriptionID) || empty($drugID) || empty($patientSSN) || empty($patientFullName) || empty($doctorSSN) || empty($doctorFullName) || empty($traceName) || empty($date) || empty($dosage) || empty($quantity) || empty($price)) {
            echo "Please fill in all the required fields.";
          } else {
            // Check if the drug is already dispensed for the prescription
            $checkQuery = "SELECT * FROM drug_dispense WHERE prescription_id = '$prescriptionID' AND drug_id = '$drugID'";
            $checkResult = $conn->query($checkQuery);

            if ($checkResult !== false && $checkResult->num_rows > 0) {
              echo "This drug has already been dispensed for the selected prescription.";
            } else {
              // Insert the drug dispense details into the database
              $insertQuery = "INSERT INTO drug_dispense (prescription_id, drug_id, patient_SSN, patient_full_name, doctor_SSN, doctor_full_name, trace_name, date, dosage, quantity, price) VALUES ('$prescriptionID', '$drugID', '$patientSSN', '$patientFullName', '$doctorSSN', '$doctorFullName', '$traceName', '$date', '$dosage', '$quantity', '$price')";
              $insertResult = $conn->query($insertQuery);

              if ($insertResult === true) {
                echo "Drug dispensed successfully.";
              } else {
                echo "Error dispensing drug: " . $conn->error;
              }
            }
          }
        } else {
          echo "No prescription found for the selected patient.";
        }
      }

      // Display the back button
      echo "<form method='GET' action='pharmacistpage.php'>";
      echo "<input type='submit' value='Back' class='indigo-button'>";
      echo "</form>";
    } else {
      echo "No prescriptions found.";
    }
  } else {
    echo "Pharmacist not found.";
  }
} else {
  echo "Invalid session. Please login again.";
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

  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
  }

  th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  th {
    background-color: #f2f2f2;
  }
  body {
    background-image: url('pharmacistdispense.jpg'); /* Add the image as the background */
      background-size: cover; /* Make the image fit the screen */
      background-position: center; /* Center the background image */
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    text-align: center;
    padding-top: 150px;
    background-color: #f2f2f2;
    margin: 0;
    padding: 20px;
    font-family: Arial, sans-serif;
  }
</style>
