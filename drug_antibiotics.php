<!DOCTYPE html>
<html>
<head>
    <title>Antibiotics</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            background-color: #3498db;
            color: #fff;
            padding: 20px 0;
            margin: 0;
        }

        .drug-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }

        .drug {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease-in-out;
        }

        .drug:hover {
            transform: scale(1.05); /* Add a scaling effect on hover */
        }

        .drug img {
            max-width: 200px;
            max-height: 200px;
            margin-bottom: 10px;
            transition: opacity 0.2s ease-in-out;
        }

        .drug:hover img {
            opacity: 0.7; /* Reduce image opacity on hover */
        }

        .drug p {
            font-size: 18px;
        }

        .drug a {
            display: inline-block;
            margin-top: 10px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            padding: 5px 15px;
            border-radius: 3px;
            transition: background-color 0.2s ease-in-out;
        }

        .drug a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h1>Antibiotics</h1>
    <div class="drug-container">
    <?php
        // Include the database connection code
        require("connection.php");

        // Prepare and execute SQL query to retrieve data from the "antiallergy" table
        $sql = "SELECT drug_id, trace_name, image_url FROM antibiotics";
        $result = $conn->query($sql);

        // Check if the query execution was successful
        if (!$result) {
            echo "Error: " . $conn->error;
        } elseif ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="drug">
                    <img src="<?php echo $row['image_url']; ?>" alt="<?php echo htmlspecialchars($row['trace_name']); ?>">
                    <p><?php echo htmlspecialchars($row['trace_name']); ?></p>
                    <a href="view_details.php?drug_id=<?php echo $row['drug_id']; ?>">View Details</a>
                </div>
                <?php
            }
        } else {
            echo "No antibiotics drugs found.";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>

