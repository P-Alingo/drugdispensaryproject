<?php
require_once("connection.php");

// Check if the appointment_id is set
if (isset($_POST['appointment_id'])) {
    // Retrieve the appointment_id from the form
    $appointmentID = $_POST['appointment_id'];

    // Delete the appointment from the database
    $deleteQuery = "DELETE FROM appointment WHERE appointment_id='$appointmentID'";

    if ($conn->query($deleteQuery) === TRUE) {
        // Appointment deleted successfully, redirect to doctor_view_appointments.php
        header("Location: doctor_view_appointments.php");
        exit(); // Make sure to exit the script after redirecting
    } else {
        echo "Error deleting appointment: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
