<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Start the session
session_start();

// Fetch buildings from the database
$sql = 'SELECT * FROM Building';
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Building Management</title>
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
    <h2>Building Management</h2>

    <a href="create_building.php">Create New Building</a>

    <!-- Display a paginated list of buildings with links to view, update, and delete -->
    <table border="1">
        <tr>
            <th>Building ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['Name']; ?></td>
                <td><?php echo $row['Type']; ?></td>
                <td>
                    <a href="view_building.php?id=<?php echo $row[
                        'ID'
                    ]; ?>">View</a> 
                    <a href="update_building.php?id=<?php echo $row[
                        'ID'
                    ]; ?>">Update</a> 
                    <?php if ($_SESSION['role'] === 'Admin'): ?>
                        <a href="delete_building.php?id=<?php echo $row[
                            'ID'
                        ]; ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
