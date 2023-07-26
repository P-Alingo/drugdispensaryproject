<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to UTF-8 (optional)
$conn->set_charset("utf8");

 

// You can now use the $conn variable to perform database operations

?>

