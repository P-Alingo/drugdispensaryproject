<?php
// Start the session
session_start();

// Check if the 'full_name' key is set in the session
if (isset($_SESSION['full_name'])) {
    // Retrieve the user's name from the session
    $full_Name = $_SESSION['full_name'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Administrator Page</title>
  <style>
    body {
      background-image: url('adminviewusers.jpg');
                            background-size: cover;
                            background-position: center;
      text-align: center;
      padding-top: 150px;
      font-family: Arial, sans-serif;
    }
    
    .button {
      padding: 10px 20px;
      font-size: 18px;
      background-color: black; /* Update the background color to black */
      color: white;
      border: none;
      border-radius: 4px;
      text-decoration: none;
      margin-right: 10px;
    }
    
    .button:hover {
      background-color: #333; /* Darker shade of black on hover */
    }
    
    .user-info {
      font-size: 24px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <?php if (isset($full_Name)) : ?>
    <div class="user-info">
      <?php echo $full_Name; ?>
    </div>
  <?php endif; ?>
  
  <h1>View users</h1>
  
  <a href="http://localhost/practicephp/admin_view_patients.php" class="button">Patient</a>
  <a href="http://localhost/practicephp/admin_view_doctors.php" class="button">Doctors</a>
  <a href="http://localhost/practicephp/admin_view_pharmacists.php" class="button">Pharmacists</a> 
  <a href="Adminpage.php" class="button">Back</a>
</body>
</html>

