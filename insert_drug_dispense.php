<?php
require_once("connection.php"); // Include your database connection code here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize data from the POST request
    $prescriptionID = $_POST["prescription_id"];
    $drugID = $_POST["drug_id"];
    $patientSSN = $_POST["patient_SSN"];
    $patientFullName = $_POST["patient_full_name"];
    $doctorSSN = $_POST["doctor_SSN"];
    $doctorFullName = $_POST["doctor_full_name"];
    $traceName = $_POST["trace_name"];
    $date = $_POST["date"];
    $dosage = $_POST["dosage"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];

    // Perform the database insertion here using prepared statements
    $insertQuery = "INSERT INTO drug_dispense (prescription_id, drug_id, patient_SSN, patient_full_name, doctor_SSN, doctor_full_name, trace_name, date, dosage, quantity, price)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($insertQuery);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("sssssssssss", $prescriptionID, $drugID, $patientSSN, $patientFullName, $doctorSSN, $doctorFullName, $traceName, $date, $dosage, $quantity, $price);

        // Execute the statement
        if ($stmt->execute()) {
            // Return a success response
            echo json_encode(['success' => true]);
        } else {
            // Return an error response
            echo json_encode(['error' => 'Error inserting into drug_dispense table: ' . $stmt->error]);
        }
    } else {
        // Return an error response if the statement couldn't be prepared
        echo json_encode(['error' => 'Error preparing the statement: ' . $conn->error]);
    }
}
?>

