<?php
// Include the database connection code
require("connection.php");

// Start the session
session_start();

// Check if the 'full_name' key is set in the session
$adminName = $_SESSION['full_name'] ?? null;


if (!$adminName) {
    // Redirect to the login page if the user is not logged in
    header("Location: Admin_login.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected category from the form
    $category = $_POST['Category'];

    // Define an array of allowed categories to prevent injection
    $allowedCategories = ["antibiotics", "antiviral", "vitamins", "antiallergy"];

    if (in_array($category, $allowedCategories)) {
        // Get drug details from the form
        $traceName = $_POST['traceName'];
        $description = $_POST['drugDescription'];
        $sideEffects = $_POST['sideeffects'];
        $quantity = $_POST['quantity'];
        $storage = $_POST['storage'];
        $price = $_POST['price'];

        // Check if the "uploads" directory exists, and if not, create it
        $uploadDirectory = 'uploads/';

        if (!is_dir($uploadDirectory)) {
            if (!mkdir($uploadDirectory, 0755, true)) {
                die('Failed to create the "uploads" directory.');
            }
        }

        if (isset($_FILES['my_image'])) {
            $img_name = $_FILES['my_image']['name'];
            $img_size = $_FILES['my_image']['size'];
            $tmp_name = $_FILES['my_image']['tmp_name'];
            $error = $_FILES['my_image']['error'];

            if ($error === 0) {
                if ($img_size > 1250000) {
                    $em = "Sorry, your file is too large.";
                } else {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);
                    $allowed_exs = array("jpg", "jpeg", "png");

                    if (in_array($img_ex_lc, $allowed_exs)) {
                        // Use the original file name as it is stored
                        $new_img_name = $img_name;
                        $img_upload_path = $uploadDirectory . $new_img_name;

                        if (move_uploaded_file($tmp_name, $img_upload_path)) {
                            // Image moved successfully, now construct the full image URL
                            $imageURL = "http://localhost/myproject/drugdispensaryproject/" . $new_img_name; // Replace with your actual image URL

                            // Prepare SQL statement using a parameterized query
                            $sql = "INSERT INTO $category (trace_name, description, side_effects, quantity, storage, price, image_url)
                                    VALUES (?, ?, ?, ?, ?, ?, ?)";
                            $stmt = $conn->prepare($sql);

                            if ($stmt) {
                                // Bind parameters and execute the SQL statement
                                $stmt->bind_param("sssssss", $traceName, $description, $sideEffects, $quantity, $storage, $price, $imageURL);

                                if ($stmt->execute()) {
                                    // Redirect to admin_add_drug.php or show a success message
                                    header("Location: admin_add_drug.php?success=Drug%20added%20successfully");
                                    exit;
                                } else {
                                    $em = "Failed to execute SQL statement: " . $stmt->error;
                                }

                                $stmt->close();
                            } else {
                                $em = "Failed to prepare SQL statement: " . $conn->error;
                            }
                        } else {
                            $em = "Failed to move uploaded image.";
                        }
                    } else {
                        $em = "You can't upload files of this type.";
                    }
                }
            } else {
                $em = "Unknown error occurred.";
            }
        } else {
            $em = "Image not uploaded.";
        }
    } else {
        $em = "Invalid category selected.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Drug Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"],
        textarea {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php if (isset($_GET['error'])): ?>
<p><?php echo $_GET['error']; ?></p>
<?php endif; ?>
<?php if (isset($_GET['success'])): ?>
<p><?php echo $_GET['success']; ?></p>
<?php endif; ?>

    <div class="container">
    <div>
    <p>Welcome, <?php echo $adminName; ?>!</p> <!-- Display the user's name -->
</div>
        <h1>Add Drug Details</h1>
        <form id="drugForm" enctype="multipart/form-data" action="admin_add_drug.php" method="POST">
            <label for="Category">Category:</label>
            <select id="Category" name="Category" required>
                <option value="antibiotics">Antibiotics</option>
                <option value="antiviral">Antiviral</option>
                <option value="vitamins">Vitamins</option>
                <option value="antiallergy">Antiallergy</option>
            </select>

            <label for="traceName">Trade Name:</label>
            <input type="text" id="traceName" name="traceName" required>
            
            <label for="drugDescription">Description:</label>
            <textarea id="drugDescription" name="drugDescription" required></textarea>
           
            <label for="sideeffects">Side Effects:</label>
            <input type="text" id="sideeffects" name="sideeffects" required>

            <label for="quantity">Quantity:</label>
            <input type="text" id="quantity" name="quantity" required>

            <label for="storage">Storage:</label>
            <input type="text" id="storage" name="storage" required>
            
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" required>
            
            <label for="my_image">Image:</label>
            <input type="file" name="my_image" required>
            
            <input type="submit" value="Add Drug">
            
            <div class="container">
                <a href="Adminpage.php" class="back-button">Back to Admin Page</a> <!-- Back button -->
            </div>
        </form>
    </div>
</body>
</html>
