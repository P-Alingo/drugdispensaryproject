<?php
require_once("connection.php");

// Check if the dispense ID is provided
if (isset($_GET['dispense_id'])) {
  $dispenseID = $_GET['dispense_id'];

  // Delete the dispensed drug from the drug_dispense table
  $deleteQuery = "DELETE FROM drug_dispense WHERE dispense_id = '$dispenseID'";
  $deleteResult = $conn->query($deleteQuery);

  if ($deleteResult === true) {
    header("Location: pharmacist_all_dispense.php");
    exit();
  } else {
    echo "Error deleting dispensed drug: " . $conn->error;
  }
} else {
  echo "Invalid request.";
}

$conn->close();
?>
