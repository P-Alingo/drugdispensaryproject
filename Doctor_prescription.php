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
            .card {
                background-color: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                max-width: 400px;
                text-align: left;
                transition: transform 0.2s, box-shadow 0.2s;
                border: 1px solid #ccc;
                margin: 0 auto;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            .form-container {
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                border: 1px solid #ccc;
                margin-top: 20px;
            }

            label {
                display: block;
                margin-bottom: 5px;
                color: #333;
            }

            input[type='text'],
            input[type='date'],
            input[type='submit'] {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 6px;
                margin-bottom: 15px;
                font-size: 16px;
                color: #555;
            }

            input[type='submit'] {
                background-color: #0074e4;
                color: #fff;
                font-weight: bold;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            input[type='submit']:hover {
                background-color: #0056b3;
            }

            /* Improved styling for the back button */
            .back-button {
                color: white;
                padding: 14px 24px;
                font-size: 16px; /* Reduced font size */
                border: none; /* Remove the border */
                border-radius: 6px;
                cursor: pointer;
                margin-top: 10px;
                width: fit-content; /* Adjusted width to fit content */
                text-decoration: none;
                transition: background-color 0.3s;
                text-align: center; /* Center text horizontally */
                margin: 0 auto; /* Center the button horizontally */
                display: block;
            }

            .back-button:hover {
                background-color: transparent; /* Remove background color on hover */
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
                width: 120px;
            }

            a {
                color: white;
                text-decoration: none;
            }

            body {
                background-image: url('doctorprescription.webp');
                background-size: cover;
                background-position: center;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
            }
            </style>";
        echo "<div class='card'>"; // Added a div with a class for styling
        echo "<div class='user-info'>"; // Added a div for user info
        echo "<h2>$fullName</h2>"; // Display user's name
        echo "</div>"; // Close user info div
        echo "<div class='form-container'>"; // Added a div with a class for styling
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
        echo "</div>"; // Close the form-container div
        echo "</div>"; // Close the card div

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
