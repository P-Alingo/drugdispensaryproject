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
      padding-top: 50px;
      background-color: #f2f2f2;
      margin: 0;
      padding: 20px;
      font-family: Arial, sans-serif;
      background-image: url('user2.jpeg');
      background-size: cover;
      animation: slideshow 5s infinite;
    }

    .card-container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      animation: slide-in 1s ease-in-out; /* Add slide-in animation */
    }

    .card {
      border-radius: 10px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      width: 200px; /* Adjust the card width as needed */
      padding: 20px;
      margin: 20px;
      text-align: center;
      background-color: #fff;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.3);
    }

    .button {
      display: inline-block;
      padding: 10px 20px;
      font-size: 18px;
      background-color: #0a209e; /* Change to your desired button color */
      color: white;
      border: none;
      border-radius: 4px;
      text-decoration: none;
      margin-bottom: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .button:hover {
      background-color: #4553a0; /* Change to your desired button hover color */
      transform: scale(1.05);
    }

    .button i {
      margin-right: 8px;
    }

    .user-info {
      font-size: 24px;
      font-weight: bold;
      color: #333;
      margin-bottom: 20px;
    }
    
    .logout-button {
      display: block;
      padding: 8px 16px;
      font-size: 16px;
      background-color: #0a209e; /* Change to your desired button color */
      color: white;
      border: none;
      border-radius: 4px;
      text-decoration: none;
      margin-top: 20px; /* Add some margin to separate it from the cards */
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .logout-button:hover {
      background-color: #4553a0; /* Change to your desired button hover color */
      transform: scale(1.05);
    }

    @keyframes slide-in {
      0% {
        opacity: 0;
        transform: translateY(50px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }
    @keyframes slideshow {
      0%, 100% {
        background-image: url('admin2.jpeg');
      }
      50% {
        background-image: url('admin1.jpeg');
      }
    }
  </style>
</head>
<body>
  <?php if (isset($adminName)) { ?>
    <h1>Welcome, <?php echo $adminName; ?>!</h1>
  <?php } ?>

  <div class="card-container">
  <div class="card">
    <a href="admin_profile.php" class="button">Profile</a>
    <p>Click here to view your profile.</p>
    </div>
    <div class="card"> 
    <a href="admin_view_users.php" class="button">View Users</a>
    <p>Click here to view the users details.</p>
    </div>
    <div class="card">
    <a href="admin_manage_drugs.php" class="button">Drugs</a>
    <p>Click here to manage the drugs in the system</p>
    </div>
    <div class="card">
    <a href="admin_add_drug.php" class="button">Add Drugs</a>
    <p>Click here to manage the drugs in the system</p>
    </div>
    </div>
  
    <a href="project.html" class="button">Log Out</a>
 
  <script>
    // Function to display the registration success message
    function displayRegistrationSuccess() {
      // Check if the registration success session variable is set and true
      var registrationSuccess = <?php echo isset($_SESSION['registration_success']) && $_SESSION['registration_success'] ? 'true' : 'false'; ?>;
      
      if (registrationSuccess) {
        var feedbackDiv = document.createElement("div");
        feedbackDiv.innerText = "User successfully registered";
        feedbackDiv.style.color = "black";
        feedbackDiv.style.marginTop = "100px";
        feedbackDiv.style.fontWeight = "bold"; // Set the text to bold
        document.body.appendChild(feedbackDiv);

        // Automatically remove the feedback message after 5 seconds
        setTimeout(function () {
          feedbackDiv.style.display = "none";
        }, 5000);
      }
    }

    // Call the function when the page loads
    window.onload = displayRegistrationSuccess;
  </script>
</body>
</html>

