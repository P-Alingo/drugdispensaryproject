<?php
require_once("connection.php");

// Start the session
session_start();

// Check if the 'email' key is set in the session
if (isset($_SESSION['email'])) {
    // Retrieve the doctor's email from the session
    $email = $_SESSION['email'];
    $fullName = $_SESSION['full_name'];

    echo "<div class='user-info'>";
    echo "<h2>$fullName</h2>";
    echo "</div>";

    // Retrieve the doctor's details from the database
    $doctorQuery = "SELECT * FROM doctor WHERE email='$email'";
    $doctorResult = $conn->query($doctorQuery);

    if ($doctorResult->num_rows > 0) {
        // Fetch the doctor's details
        $doctorRow = $doctorResult->fetch_assoc();
        $doctorSSN = $doctorRow['SSN']; // Retrieve the doctor's SSN

        // Retrieve the list of prescriptions created by the doctor
        $prescriptionQuery = "SELECT * FROM Prescription WHERE doctor_SSN='$doctorSSN'";
        $prescriptionResult = $conn->query($prescriptionQuery);

        // Check if there are prescriptions available
        if ($prescriptionResult->num_rows > 0) {
            echo "<style>
                    .user-info {
                        font-weight: bold;
                        margin-bottom: 20px;
                    }
                    h1 {
                        font-size: 24px;
                        margin-bottom: 10px;
                    }
                    table {
                        border-collapse: collapse;
                        width: 100%;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: left;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                    button {
                        display: inline-block;
                        padding: 8px 16px;
                        background-color: black;
                        color: white;
                        text-decoration: none;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                        margin-top: 10px;
                    }
                    button a {
                        color: white;
                        text-decoration: none;
                    }
                    .back-button {
                        margin-top: 10px;
                    }
                </style>";

            echo "<h1>Doctor Prescriptions</h1>";
            echo "<table>";
            echo "<tr><th>Prescription ID</th><th>Patient SSN</th><th>Patient Full Name</th><th>Trace Name</th><th>Date</th><th>Dosage</th><th>Quantity</th><th>Action</th></tr>";

            while ($prescriptionRow = $prescriptionResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $prescriptionRow['prescription_id'] . "</td>";
                echo "<td>" . $prescriptionRow['patient_SSN'] . "</td>";
                echo "<td>" . $prescriptionRow['patient_full_name'] . "</td>";
                echo "<td>" . $prescriptionRow['trace_name'] . "</td>";
                echo "<td>" . $prescriptionRow['date'] . "</td>";
                echo "<td>" . $prescriptionRow['dosage'] . "</td>";
                echo "<td>" . $prescriptionRow['quantity'] . "</td>";
                echo "<td>";
                echo "<form method='post' action='doctor_update_prescription.php'>";
                echo "<input type='hidden' name='prescription_id' value='" . $prescriptionRow['prescription_id'] . "'>";
                echo "<button type='submit'>Edit Prescription</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";

            // Back button
            echo "<div class='back-button'>";
            echo "<button onclick=\"window.location.href = 'Doctor_prescription.php';\">Back</button>";
            echo "</div>";
        } else {
            echo "No prescriptions found.";
        }
    } else {
        echo "Doctor not found.";
    }
} else {
    echo "Invalid session. Please login again.";
}

$conn->close();
?>
