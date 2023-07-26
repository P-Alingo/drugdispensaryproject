<?php
require_once("connection.php");

// Fetch the dispensed drug details from the view_drug_dispense view
$query = "SELECT * FROM view_drug_dispense";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dispensed Drugs</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <h1>Dispensed Drugs</h1>

  <table>
    <tr>
      <th>Dispense ID</th>
      <th>Prescription ID</th>
      <th>Patient SSN</th>
      <th>Patient Full Name</th>
      <th>Doctor SSN</th>
      <th>Doctor Full Name</th>
      <th>Drug ID</th>
      <th>Trace Name</th>
      <th>Dosage</th>
      <th>Quantity</th>
      <th>Price</th>
      <th>Date</th>
    </tr>
    
    <?php
    if ($result !== false && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['dispense_id']."</td>";
        echo "<td>".$row['prescription_id']."</td>";
        echo "<td>".$row['patient_SSN']."</td>";
        echo "<td>".$row['patient_full_name']."</td>";
        echo "<td>".$row['doctor_SSN']."</td>";
        echo "<td>".$row['doctor_full_name']."</td>";
        echo "<td>".$row['drug_id']."</td>";
        echo "<td>".$row['trace_name']."</td>";
        echo "<td>".$row['dosage']."</td>";
        echo "<td>".$row['quantity']."</td>";
        echo "<td>".$row['price']."</td>";
        echo "<td>".$row['date']."</td>";
        echo "</tr>";
      }
    } else {
      echo "<tr><td colspan='12'>No dispensed drugs found.</td></tr>";
    }
    ?>
  </table>

  <br>
  <a href="pharmacist_dispense_drug.php">Back</a>
</body>
</html>

<?php
$conn->close();
?>
