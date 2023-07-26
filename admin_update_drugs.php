<?php
require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted form data
    $drugId = $_POST['drug_id'];
    $traceName = $_POST['trace_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Update the drug details in the database
    $query = "UPDATE drugs SET Trace_name='$traceName', price='$price', quantity='$quantity' WHERE drug_id='$drugId'";
    $result = $conn->query($query);

    if ($result) {
        // Redirect to admin_edit_drugs.php
        header("Location: http://localhost/practicephp/admin_edit_drugs.php?drug_id=$drugId");
        exit();
    } else {
        echo "Error updating drug record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>

