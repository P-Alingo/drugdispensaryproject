<?php
require_once("connection.php");

$searchTerm = $_GET['term'];

$query = "SELECT prescription_id FROM prescription WHERE prescription_id LIKE '%$searchTerm%'";
$result = $conn->query($query);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row['prescription_id'];
    }
}

echo json_encode($data);

$conn->close();
?>
