<?php
// Include the common database connection file
include '../includes/db_connection.php';
session_start();
// Fetch revenue types with related building information
$sql = "SELECT RevenueType.ID, RevenueType.Name, RevenueType.Type, Building.Name AS BuildingName
        FROM RevenueType
        LEFT JOIN Building ON RevenueType.BuildingID = Building.ID";
$result = $conn->query($sql);

// Display a list of revenue types with links to view, update, and delete
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Type Management</title>
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
    <h2>Revenue Type Management</h2>

    <a href="create_revenue_type.php">Create New Revenue Type</a>

    <!-- Display a paginated list of revenue types with links to view, update, and delete -->
    <table border="1">
        <tr>
            <th>Revenue Type ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Building Name</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo isset($row['Name']) ? $row['Name'] : 'N/A'; ?></td>
                <td><?php echo isset($row['Type']) ? $row['Type'] : 'N/A'; ?></td>
                <td><?php echo isset($row['BuildingName']) ? $row['BuildingName'] : 'N/A'; ?></td>
                <td>
                    <a href="view_revenue_type.php?id=<?php echo $row['ID']; ?>">View</a> 
                    <a href="update_revenue_type.php?id=<?php echo $row['ID']; ?>">Update</a> 
                    <?php if ($_SESSION['role'] === 'Admin') : ?>
                        <a href="delete_revenue_type.php?id=<?php echo $row['ID']; ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href = "../dashboard.php">Back to Dashboard</a>
</body>
</html>
