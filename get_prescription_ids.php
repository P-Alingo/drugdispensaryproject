<?php
require_once("connection.php");

// Fetch prescription IDs from the database and return as JSON
$query = "SELECT prescription_id FROM prescription";
$result = $conn->query($query);
$prescriptionIDs = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $prescriptionIDs[] = $row['prescription_id'];
  }
}
echo json_encode($prescriptionIDs);

$conn->close();
?>
