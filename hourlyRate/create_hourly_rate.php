<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Handle form submission for creating a new hourly rate
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createHourlyRate"])) {
    $hourlyRate = $_POST["hourlyRate"];

    // Insert the new hourly rate into the database
    $sql = "INSERT INTO HourlyRate (HourlyRate) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $hourlyRate);
    $stmt->execute();
    $stmt->close();

    echo "Hourly Rate created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Hourly Rate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(144, 238, 144, 0.3); /* Light green with reduced opacity */
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        a:hover {
            background-color: #2980b9;
        }

    </style>
</head>
<body>
    <h2>Create Hourly Rate</h2>

    <!-- Hourly rate creation form -->
    <form method="post" action="">
        <label for="hourlyRate">Hourly Rate:</label>
        <input type="text" name="hourlyRate" required><br>

        <button type="submit" name="createHourlyRate">Create Hourly Rate</button>
    </form>

    <a href="view_hourly_rates.php">Back to Hourly Rates</a>
</body>
</html>
