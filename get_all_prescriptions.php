<?php
require_once("connection.php");

$query = "SELECT prescription_id, drug_id, patient_SSN, patient_full_name, doctor_SSN, doctor_full_name, trace_name, date, dosage, quantity
          FROM view_prescription";
$result = $conn->query($query);

if ($result !== false && $result->num_rows > 0) {
  echo "<h2>All Patients' Prescription Details</h2>";
  echo "<table>";
  echo "<tr><th>Prescription ID</th><th>Drug ID</th><th>Patient SSN</th><th>Patient Full Name</th><th>Doctor SSN</th><th>Doctor Full Name</th><th>Trace Name</th><th>Date</th><th>Dosage</th><th>Quantity</th></tr>";

  while ($prescriptionRow = $result->fetch_assoc()) {
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
} else {
  echo "No prescriptions found.";
}

$conn->close();
?>
