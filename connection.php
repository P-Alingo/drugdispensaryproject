<?php
// Database configuration with port 3307
$servername = "localhost:3307"; // Change the port number to 3307
$username = "root";
$password = "";
$dbname = "web";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "connected successfully";
  
}

// Set the character set to UTF-8 (optional)
if (!$conn->set_charset("utf8")) {
    echo "Error setting character set: " . $conn->error;
}

// You can now use the $conn variable to perform database operations

// Don't forget to close the connection when you're done
//$conn->close();
?>
