<?php
// Include your database connection here

if (isset($_POST['patientSearch'])) {
    $patientName = $_POST['patientSearch'];

    // Perform a query to search for the patient by name in the prescription table
    // Fetch the prescription details for the selected patient

    // Return the prescription details as a JSON response
    $response = [
        'prescriptionId' => 123, // Replace with the actual prescription ID
        // Include other prescription details here
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}

if (isset($_POST['dispenseData'])) {
    $dispenseData = json_decode($_POST['dispenseData'], true);

    // Insert the dispenseData into the drug_dispense table

    // Return a success message or error message as needed
}
?>
