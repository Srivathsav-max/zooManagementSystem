<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the Hourly Rate ID from the URL parameter
$hourlyRateID = $_GET['id'];

// Fetch the current hourly rate details
$sql = "SELECT * FROM HourlyRate WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hourlyRateID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

// Handle form submission for updating the hourly rate
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateHourlyRate"])) {
    $newHourlyRate = $_POST["newHourlyRate"];

    // Update the hourly rate in the database
    $updateSql = "UPDATE HourlyRate SET HourlyRate = ? WHERE ID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("si", $newHourlyRate, $hourlyRateID);
    $stmt->execute();
    $stmt->close();

    echo "Hourly Rate updated successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Hourly Rate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            width: 50%;
            margin: 20px auto;
            background-color: rgba(144, 238, 144, 0.3);
            padding: 20px;
            border-radius: 8px;
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
        }

        button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a {
            display: block;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            color: #333;
        }

    </style>
</head>
<body>
    <h2>Update Hourly Rate</h2>

    <!-- Hourly rate update form -->
    <form method="post" action="">
        <label for="newHourlyRate">New Hourly Rate:</label>
        <input type="text" name="newHourlyRate" value="<?php echo $row['HourlyRate']; ?>" required><br>

        <button type="submit" name="updateHourlyRate">Update Hourly Rate</button>
    </form>

    <a href="view_hourly_rates.php">Back to Hourly Rates</a>
</body>
</html>
