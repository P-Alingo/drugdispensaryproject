<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
    // Retrieve the doctor's email from the session
    $email = $_SESSION['email'];
    $fullName = $_SESSION['full_name'];

    // Retrieve the doctor's details from the database
    $doctorQuery = "SELECT * FROM doctor WHERE email='$email'";
    $doctorResult = $conn->query($doctorQuery);

    if ($doctorResult->num_rows > 0) {
        // Fetch the doctor's details
        $doctorRow = $doctorResult->fetch_assoc();
        $doctorSSN = $doctorRow['SSN']; // Retrieve the doctor's SSN
        $doctorFullName = $doctorRow['full_name']; // Retrieve the doctor's full name

        // Check if the form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve the appointment data from the form
            $selectedPatientSSN = $_POST['patient'];
            $appointmentDate = $_POST['appointment_date'];
            $appointmentTime = $_POST['appointment_time'];
            $appointmentPurpose = $_POST['appointment_purpose'];

            // Retrieve the full name of the selected patient
            $patientQuery = "SELECT full_name FROM patient WHERE SSN = '$selectedPatientSSN'";
            $patientResult = $conn->query($patientQuery);

            if ($patientResult->num_rows > 0) {
                $patientRow = $patientResult->fetch_assoc();
                $patientFullName = $patientRow['full_name'];

                // Insert the appointment data into the Appointments table
                $insertQuery = "INSERT INTO appointment (doctor_SSN, doctor_full_name, patient_SSN, patient_full_name, appointment_date, appointment_time, appointment_purpose) 
                                VALUES ('$doctorSSN', '$doctorFullName', '$selectedPatientSSN', '$patientFullName', '$appointmentDate', '$appointmentTime', '$appointmentPurpose')";

                if ($conn->query($insertQuery) === TRUE) {
                    echo "Appointment added successfully.";
                } else {
                    echo "Error adding appointment: " . $conn->error;
                }
            } else {
                echo "Selected patient not found.";
            }
        }

        // Retrieve the list of patients from the database
        $patientQuery = "SELECT SSN, full_name FROM patient";
        $patientResult = $conn->query($patientQuery);

        // Check if there are patients available
        if ($patientResult->num_rows > 0) {
            echo "<div class='user-info'>";
            echo "<h2>$fullName</h2>";
            echo "</div>";

            echo "<div class='appointment-container'>";
            echo "<h1>Add Appointment</h1>";

            // Generate the dropdown list
            echo "<form class='appointment-form' method='post' action='doctor_appointment.php'>";
            echo "<label for='patient'>Select Patient:</label>";
            echo "<select name='patient' id='patient'>";

            // Iterate over the patients and populate the dropdown list
            while ($patientRow = $patientResult->fetch_assoc()) {
                $ssn = $patientRow['SSN'];
                $fullName = $patientRow['full_name'];
                echo "<option value='$ssn'>$ssn - $fullName</option>";
            }

            echo "</select>";
            echo "<br>";

            // Appointment input fields
            echo "<label for='appointment_date'>Appointment Date:</label>";
            echo "<input type='date' name='appointment_date' id='appointment_date' class='field' required>";
            echo "<br>";
            echo "<label for='appointment_time'>Appointment Time:</label>";
            echo "<input type='time' name='appointment_time' id='appointment_time' class='field' required>";
            echo "<br>";
            echo "<label for='appointment_purpose'>Appointment Purpose:</label>";
            echo "<input type='text' name='appointment_purpose' id='appointment_purpose' class='field' required>";
            echo "<br>";
            echo "<input type='submit' value='Add Appointment' class='add-appointment-button'>";
            echo "</form>";

            // View Appointments button
            echo "<button class='view-appointments-button' onclick='viewAppointments()'>View Appointments</button>";
            echo "<script>";
            echo "function viewAppointments() {";
            echo "  window.location.href = 'doctor_view_appointments.php';";
            echo "}";
            echo "</script>";

            // Back button
            echo "<button class='back-button' onclick='goBack()'>Back</button>";
            echo "<script>";
            echo "function goBack() {";
            echo "  window.location.href = 'doctorpage.php';";
            echo "}";
            echo "</script>";

            echo "</div>"; // Close the appointment-container div
        } else {
            echo "No patients found.";
        }
    } else {
        echo "Doctor not found.";
    }
} else {
    echo "Invalid session. Please login again.";
}

$conn->close();
?>

<style>
    .user-info {
        text-align: center;
        margin-bottom: 20px;
    }

    .user-info h2 {
        color: #333;
    }

    body {
        background-image: url('doctorappointment.webp');
        background-size: cover;
        background-position: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
    }

    .appointment-container {
        text-align: center;
        margin-top: 20px;
    }

    .appointment-form {
        display: inline-block;
        text-align: left;
        margin-bottom: 10px;
    }

    .appointment-form label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }

    .appointment-form select,
    .appointment-form input[type="text"],
    .appointment-form input[type="date"],
    .appointment-form input[type="time"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 10px;
    }

    .add-appointment-button,
    .view-appointments-button,
    .back-button {
        display: block;
        width: 150px;
        padding: 8px 12px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin: 5px auto;
    }

    .add-appointment-button:hover,
    .view-appointments-button:hover,
    .back-button:hover {
        background-color: #555;
    }
</style>
