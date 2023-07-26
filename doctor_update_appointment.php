<?php
require_once("connection.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the appointment ID and updated details from the form
    $appointmentID = $_POST['appointment_id'];
    $appointmentDate = $_POST['date'];
    $appointmentTime = $_POST['time'];

    // Update the appointment details in the database
    $updateQuery = "UPDATE appointment SET appointment_date='$appointmentDate', appointment_time='$appointmentTime' WHERE appointment_id='$appointmentID'";

    if ($conn->query($updateQuery) === TRUE) {
        // Appointment updated successfully, redirect to doctor_view_appointments.php
        header("Location: doctor_view_appointments.php");
        exit(); // Make sure to exit the script after redirecting
    } else {
        echo "Error updating appointment: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();

