<?php
require_once("connection.php"); // Include your database connection code here

// Handle prescription retrieval
if (isset($_GET['patient'])) {
    $selectedPatient = $_GET['patient'];

    // Query to fetch prescription details
    $query = "SELECT prescription_id, drug_id, patient_SSN, patient_full_name, doctor_SSN, doctor_full_name, trace_name, date, dosage, quantity, price
              FROM prescription
              WHERE patient_SSN = ?";

    // Prepare the statement
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $selectedPatient); // Bind the parameter
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $prescriptionRow = $result->fetch_assoc();

            // Return prescription details as JSON
            echo json_encode($prescriptionRow);
        } else {
            echo json_encode(['error' => 'Prescription not found']);
        }

        $stmt->close(); // Close the statement
    } else {
        echo json_encode(['error' => 'Error preparing statement']);
    }
}
?>
