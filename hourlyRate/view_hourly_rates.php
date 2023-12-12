<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch hourly rates from the database
$sql = "SELECT * FROM HourlyRate";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Hourly Rates</title>
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

        a {
            display: block;
            width: 200px;
            margin: 10px auto; /* Reduced margin */
            padding: 10px 20px;
            background-color: rgba(144, 238, 144, 0.3); /* Light transparent green */
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: rgba(144, 238, 144, 0.3); /* Light transparent green */
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }


    </style>
</head>
<body>
    <h2>Hourly Rates</h2>

    <a href="create_hourly_rate.php">Create New Hourly Rate</a>

    <!-- Display a paginated list of hourly rates with links to update and delete -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Hourly Rate</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['HourlyRate']; ?></td>
                <td>
                    <a href="update_hourly_rate.php?id=<?php echo $row['ID']; ?>">Update</a> 
                    <a href="delete_hourly_rate.php?id=<?php echo $row['ID']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
