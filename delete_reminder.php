<?php
require_once("connection.php");

// Check if the reminder ID is provided in the URL query parameter
if (isset($_GET['id'])) {
  $reminderId = $_GET['id'];

  // Delete the reminder from the database
  $deleteQuery = "DELETE FROM Reminder WHERE id='$reminderId'";
  if ($conn->query($deleteQuery) === TRUE) {
    echo "Reminder deleted successfully.";
  } else {
    echo "Error deleting reminder: " . $conn->error;
  }

  // Check if all reminders are deleted
  $remainingRemindersQuery = "SELECT * FROM Reminder";
  $remainingRemindersResult = $conn->query($remainingRemindersQuery);

  if ($remainingRemindersResult->num_rows === 0) {
    // All reminders are deleted, display back button
    echo "<button><a href=\"Patient_reminder.php\">Back</a></button>";
  }

  // Redirect to view_reminders.php
  header("Location: view_reminders.php");
  exit();
} else {
  echo "Invalid request. Reminder ID not specified.";
}

$conn->close();
?>
