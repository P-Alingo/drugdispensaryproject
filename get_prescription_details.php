<?php
require_once("connection.php");

// Check if the prescription ID is provided
if (isset($_POST['prescription_id'])) {
    $prescriptionId = $_POST['prescription_id'];

    // Prepare the SQL statement to retrieve the prescription details
    $query = "SELECT * FROM prescription WHERE prescription_id = '$prescriptionId'";
    $result = $conn->query($query);

    // Check if the prescription is found
    if ($result && $result->num_rows > 0) {
        $prescriptionDetails = $result->fetch_assoc();

        // Send the response as JSON
        echo json_encode($prescriptionDetails);
    }
}

$conn->close();
?>
