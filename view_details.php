<!DOCTYPE html>
<html>
<head>
    <title>Drug Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .drug-card {
            background-color: #fff;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .drug-card img {
            max-width: 200px;
            max-height: 200px;
            margin: 0 auto 10px;
            display: block;
        }

        .drug-card h2 {
            color: #333;
            font-size: 24px;
            margin: 10px 0;
        }

        .drug-card p {
            color: #333; /* Updated text color to match h2 */
            margin: 5px 0;
            font-size: 16px;
            text-align: left; /* Align text to the left */
        }

        /* Make specific texts bold */
        .drug-card p strong {
            font-weight: bold;
        }

        /* Go Back link style */
        .go-back {
            text-align: center;
            margin-top: 20px;
        }

        .go-back a {
            text-decoration: none;
            color: #007BFF;
            font-size: 18px;
            font-weight: bold;
        }

        /* Add hover effect on the Go Back link */
        .go-back a:hover {
            text-decoration: underline;
        }
    </style>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Drug Details</h1>

    <?php
    // Include the database connection code
    require("connection.php");

    // Check if the drug_id parameter is set in the URL
    if (isset($_GET['drug_id'])) {
        $drugId = $_GET['drug_id'];

        // Determine the table based on the referring page
        $table = '';
        $referringPage = $_SERVER['HTTP_REFERER'];

        if (strpos($referringPage, 'drug_antibiotics.php') !== false) {
            $table = 'antibiotics';
        } elseif (strpos($referringPage, 'drug_vitamins.php') !== false) {
            $table = 'vitamins';
        } elseif (strpos($referringPage, 'drug_antiviral.php') !== false) {
            $table = 'antiviral';
        } elseif (strpos($referringPage, 'drug_antiallergy.php') !== false) {
            $table = 'antiallergy';
        }

        if (!empty($table)) {
            // Prepare and execute the SQL statement to retrieve drug details
            $sql = "SELECT * FROM $table WHERE drug_id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("i", $drugId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                    $row = $result->fetch_assoc();

                    // Display drug details in a card-like container
                    echo "<div class='drug-card'>"; // Add a container for drug details
                    echo "<img src='{$row['image_url']}' alt='Drug Image'>";
                    echo "<h2>Drug Name: {$row['trace_name']}</h2>";
                    echo "<p><strong>Description:</strong> {$row['description']}</p>";
                    echo "<p><strong>Side Effects:</strong> {$row['side_effects']}</p>";
                    echo "<p><strong>Quantity:</strong> {$row['quantity']}</p>";
                    echo "<p><strong>Storage:</strong> {$row['storage']}</p>";
                    echo "<p><strong>Price:</strong> {$row['price']}</p>";
                    echo "</div>"; // Close the drug-card container

                    // Go Back link
                    echo "<div class='go-back'><a href='javascript:history.go(-1)'>Go Back</a></div>";
                    ?>
                    <script>
                        // Use jQuery to apply the fade-in animation to the drug-card container
                        $(document).ready(function () {
                            $('.drug-card').css('opacity', '1'); // Set opacity to 1 for fade-in
                        });
                    </script>
                    <?php
                } else {
                    echo "<p>Drug not found.</p>";
                }

                $stmt->close();
            } else {
                echo "<p>Error preparing SQL statement.</p>";
            }
        } else {
            echo "<p>Invalid referring page.</p>";
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "<p>No drug selected.</p>";
    }
    ?>
</body>
</html>

