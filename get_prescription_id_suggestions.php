<?php
require_once("connection.php");

$query = "SELECT prescription_id FROM prescription";
$result = $conn->query($query);

$prescriptionIds = array();
if ($result !== false && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $prescriptionIds[] = $row['prescription_id'];
  }
}

echo json_encode($prescriptionIds);

$conn->close();
?>
