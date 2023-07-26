<?php
require_once("connection.php");

// Start the session
session_start();

// Define the $selectedPatientSSN variable
$selectedPatientSSN = "";

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

    if ($doctorResult) {
        // Fetch the doctor's details
        $doctorRow = $doctorResult->fetch_assoc();
        $doctorSSN = $doctorRow['SSN']; // Retrieve the doctor's SSN

        // Check if the form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve the prescription data from the form
            $selectedPatientSSN = $_POST['patient'];
            $patientFullName = $_POST['patient_full_name'];
            $doctorFullName = $doctorRow['full_name'];
            $traceName = $_POST['trace_name'];
            $date = $_POST['date'];
            $dosage = $_POST['dosage'];
            $quantity = $_POST['quantity'];

            // Check if the selected drug exists in the drugs table
            $drugCheckQuery = "SELECT drug_id FROM drugs WHERE trace_name='$traceName'";
            $drugCheckResult = $conn->query($drugCheckQuery);

            if ($drugCheckResult && $drugCheckResult->num_rows > 0) {
                // Fetch the drug ID
                $drugRow = $drugCheckResult->fetch_assoc();
                $drugID = $drugRow['drug_id'];

                // Insert the prescription data into the Prescription table
                $insertQuery = "INSERT INTO prescription (patient_SSN, patient_full_name, doctor_SSN, doctor_full_name, drug_id, trace_name, date, dosage, quantity) 
                                VALUES ('$selectedPatientSSN', '$patientFullName', '$doctorSSN', '$doctorFullName', '$drugID', '$traceName', '$date', '$dosage', '$quantity')";

                if ($conn->query($insertQuery) === TRUE) {
                    echo "Prescription added successfully.";
                } else {
                    echo "Error adding prescription: " . $conn->error;
                }
            } else {
                echo "Selected drug does not exist.";
            }
        }

        // Retrieve the list of patients from the database
        $patientQuery = "SELECT SSN, full_name FROM patient";
        $patientResult = $conn->query($patientQuery);

        // Check if there are patients available
        if ($patientResult && $patientResult->num_rows > 0) {
            // Generate the dropdown list
            echo "<style>
            /* Styles moved to head tag */
            .form-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                /* Align items horizontally at the center */
            }
            .form-container form {
                max-width: 400px;
                /* Add styles to center the form and set a maximum width */
                margin: 0 auto;
            }
            .user-info {
                font-weight: bold;
                margin-bottom: 20px;
            }
            label {
                display: block;
                margin-bottom: 5px;
            }
            select,
            input[type='text'],
            input[type='date'],
            input[type='submit'],
            button {
                margin-bottom: 10px;
                padding: 8px;
                border-radius: 4px;
                border: 1px solid #ccc;
            }
            input[type='submit'],
            button {
                background-color: black;
                color: white;
                cursor: pointer;
            }
            .input-buttons button {
                display: inline-block;
                margin-right: 10px;
                width: 120px; /* Set a fixed width for the buttons */
            }
            a {
                color: white;
                text-decoration: none;
            }
            .back-button {
                margin-top: 10px;
            }
            body {
                background-image: url('doctorprescription.webp');
                background-size: cover;
                background-position: center;
                display: flex;
                flex-direction: column;
                align-items: center; /* Align items horizontally at the center */
                justify-content: center; /* Align items vertically at the center */
                height: 100vh;
                margin: 0;
            }
        </style>";

            echo "<form method='post' action=''>"; // Changed the form action to the same page
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

            echo "<label for='patient_full_name'>Patient Full Name:</label>";
            echo "<input type='text' id='patient_full_name' name='patient_full_name' required><br>";

            // Retrieve the list of drugs from the database
            $drugQuery = "SELECT drug_id, Trace_name FROM drugs";
            $drugResult = $conn->query($drugQuery);

            // Check if there are drugs available
            if ($drugResult && $drugResult->num_rows > 0) {
                // Generate the dropdown list for drug_id
                echo "<label for='trace_name'>Select Drug:</label>";
                echo "<select name='trace_name' id='trace_name'>";

                // Iterate over the drugs and populate the dropdown list
                while ($drugRow = $drugResult->fetch_assoc()) {
                    $drugID = $drugRow['drug_id'];
                    $traceName = $drugRow['Trace_name'];
                    echo "<option value='$traceName'>$drugID - $traceName</option>";
                }

                echo "</select>";
                echo "<br>";
            } else {
                echo "No drugs found.";
            }

            // Prescription input fields
            echo "<label for='date'>Date:</label>";
            echo "<input type='date' name='date' id='date' required><br>";
            echo "<label for='dosage'>Dosage:</label>";
            echo "<input type='text' name='dosage' id='dosage' required><br>";
            echo "<label for='quantity'>Quantity:</label>";
            echo "<input type='text' name='quantity' id='quantity' required><br>";
            echo "<div class='input-buttons'>";
            echo "<input type='submit' value='Submit'>";
            echo "</div>";
            echo "</form>";

            // View Prescription button
            echo "<form method='post' action='doctor_view_prescription.php'>";
            echo "<input type='hidden' name='patient' value='$selectedPatientSSN'>";
            echo "<div class='input-buttons'>";
            echo "<input type='submit' value='View Prescription'>";
            echo "</div>";
            echo "</form>";

            // Back button
            echo "<div class='back-button'>";
            echo "<button onclick=\"window.location.href = 'doctorpage.php';\">Back</button>";
            echo "</div>";
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
