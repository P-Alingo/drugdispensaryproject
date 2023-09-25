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
    echo "<h2>  $fullName</h2>";
    echo "</div>";

    // Retrieve the doctor's details from the database
    $doctorQuery = "SELECT * FROM doctor WHERE email='$email'";
    $doctorResult = $conn->query($doctorQuery);

    if ($doctorResult->num_rows > 0) {
        // Fetch the doctor's details
        $doctorRow = $doctorResult->fetch_assoc();
        $doctorSSN = $doctorRow['SSN']; // Retrieve the doctor's SSN

        // Check if the form was submitted and the prescription ID is set
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prescription_id'])) {
            // Retrieve the prescription ID from the form
            $prescriptionID = $_POST['prescription_id'];

            // Retrieve the prescription details from the database
            $prescriptionQuery = "SELECT * FROM Prescription WHERE prescription_id='$prescriptionID' AND doctor_SSN='$doctorSSN'";
            $prescriptionResult = $conn->query($prescriptionQuery);

            if ($prescriptionResult->num_rows > 0) {
                // Fetch the prescription details
                $prescriptionRow = $prescriptionResult->fetch_assoc();
                $patientSSN = $prescriptionRow['patient_SSN'];
                $patientFullName = $prescriptionRow['patient_full_name'];
                $traceName = $prescriptionRow['trace_name'];
                $date = $prescriptionRow['date'];
                $dosage = $prescriptionRow['dosage'];
                $quantity = $prescriptionRow['quantity'];

                // Check if the form was submitted and the required fields are set
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trace_name']) && isset($_POST['date']) && isset($_POST['dosage']) && isset($_POST['quantity'])) {
                    // Retrieve the updated prescription details from the form
                    $updatedTraceName = $_POST['trace_name'];
                    $updatedDate = $_POST['date'];
                    $updatedDosage = $_POST['dosage'];
                    $updatedQuantity = $_POST['quantity'];

                    // Update the prescription details in the database
                    $updateQuery = "UPDATE Prescription SET trace_name='$updatedTraceName', date='$updatedDate', dosage='$updatedDosage', quantity='$updatedQuantity' WHERE prescription_id='$prescriptionID' AND doctor_SSN='$doctorSSN'";

                    if ($conn->query($updateQuery) === TRUE) {
                        echo "Prescription updated successfully.";
                        // Redirect to doctor_view_prescription.php
                        header("Location: doctor_view_prescription.php");
                        exit;
                    } else {
                        echo "Error updating prescription: " . $conn->error;
                    }
                }

                // Add <style> tag for CSS
                echo "<style>
                        .user-info {
                            font-weight: bold;
                            margin-bottom: 20px;
                        }
                       
                      
                        input[type='text'],
                        input[type='date'] {
                            width: 200px;
                            margin-bottom: 10px;
                        }
                        input[type='submit'],
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
                        .user-info {
                            font-weight: bold;
                            margin-bottom: 20px;
                        }
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
                            margin-top: 20px;
                        }
                        h1 {
                            font-size: 24px;
                            margin-bottom: 10px;
                        }
                        label {
                            display: inline-block;
                            width: 120px;
                            margin-bottom: 10px;
                        }
                        input[type='text'],
                        input[type='date'] {
                            width: 200px;
                            margin-bottom: 10px;
                        }
                        input[type='submit'],
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
                            background-color: black;
                            color: white;
                            padding: 14px 24px;
                            font-size: 16px;
                            border: none;
                            border-radius: 6px;
                            cursor: pointer;
                            margin-top: 10px;
                            text-decoration: none;
                            width: fit-content;
                            display: inline-block;
                        }
                        .button-container {
                            margin-top: 10px;
                        }
                    </style>";

                // Display the prescription update form in a card
                echo "<div class='card'>";
                echo "<h1>Edit Prescription</h1>";
                echo "<form method='POST' action=''>";
                echo "<input type='hidden' name='prescription_id' value='$prescriptionID'>";
                echo "<label for='patient_ssn'>Patient SSN:</label>";
                echo "<input type='text' id='patient_ssn' name='patient_ssn' value='$patientSSN' readonly><br><br>";
                echo "<label for='patient_full_name'>Patient Full Name:</label>";
                echo "<input type='text' id='patient_full_name' name='patient_full_name' value='$patientFullName' readonly><br><br>";
                echo "<label for='trace_name'>Trace Name:</label>";
                echo "<input type='text' id='trace_name' name='trace_name' value='$traceName' required><br><br>";
                echo "<label for='date'>Date:</label>";
                echo "<input type='date' id='date' name='date' value='$date' required><br><br>";
                echo "<label for='dosage'>Dosage:</label>";
                echo "<input type='text' id='dosage' name='dosage' value='$dosage' required><br><br>";
                echo "<label for='quantity'>Quantity:</label>";
                echo "<input type='text' id='quantity' name='quantity' value='$quantity' required><br><br>";
                echo "<div class='button-container'>";
                echo "<input type='submit' value='Update Prescription'>";
                echo "<button onclick=\"window.location.href = 'doctor_view_prescription.php';\">Back</button>";
                echo "</div>";
                echo "</form>";
                echo "</div>";

            } else {
                echo "Prescription not found.";
            }
        } else {
            echo "Invalid request.";
        }
    } else {
        echo "Doctor not found.";
    }
} else {
    echo "Invalid session. Please login again.";
}

$conn->close();
?>


