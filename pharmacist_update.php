<?php
require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted form data
    $fullName = $_POST['fullName'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];

    // Start the session
    session_start();

    // Check if the 'email' key is set in the session
    if (isset($_SESSION['email'])) {
        // Retrieve the pharmacist's email from the session
        $sessionEmail = $_SESSION['email'];

        // Update the pharmacist's details in the database
        $query = "UPDATE pharmacist SET full_name='$fullName', gender='$gender', email='$email', password='$password', date_of_birth='$dateOfBirth', phone_number='$phoneNumber', address='$address' WHERE email='$sessionEmail'";
        $result = $conn->query($query);

        if ($result) {
            // Redirect back to pharmacist_profile.php
            header("Location: pharmacist_profile.php");
            exit();
        } else {
            echo "Error updating pharmacist record: " . $conn->error;
        }
    } else {
        echo "Invalid session. Please login again.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
