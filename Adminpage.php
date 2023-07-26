<?php
// Start the session
session_start();

// Check if the 'full_name' key is set in the session
if (isset($_SESSION['full_name'])) {
  // Retrieve the administrator's name from the session
  $adminName = $_SESSION['full_name'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Administrator Page</title>
  <style>
    body {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      height: 100vh;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-image: url('admin2.jpeg');
      background-size: cover;
      background-position: center;
      animation: slideshow 5s infinite;
    }

    h1 {
      color: #333;
    }

    .button-container {
      margin-top: 20px;
    }

    .button {
      display: block;
      padding: 10px 20px;
      font-size: 18px;
      background-color: black;
      color: white;
      border: none;
      border-radius: 4px;
      text-decoration: none;
      margin-bottom: 10px;
      cursor: pointer;
    }

    .button:hover {
      background-color: #333;
    }

    @keyframes slideshow {
      0%, 100% {
        background-image: url('admin2.jpeg');
      }
      50% {
        background-image: url('admin.jpeg');
      }
    }
  </style>
</head>
<body>
  <?php if (isset($adminName)) { ?>
    <h1>Welcome, <?php echo $adminName; ?>!</h1>

    <div class="button-container">
      <a href="http://localhost/practicephp/admin_profile.php" class="button">Profile</a>
      <a href="http://localhost/practicephp/admin_view_users.php" class="button">View Users</a>
      <a href="http://localhost/practicephp/admin_manage_drugs.php" class="button">Drugs</a>
      <a href="project.html" class="button">Log Out</a>
    </div>
  <?php } ?>
</body>
</html>
