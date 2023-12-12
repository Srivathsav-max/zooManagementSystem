<?php
// Include the common database connection file
include '../includes/db_connection.php';
// Start the session
session_start();
// Fetch concessions from the database
$sql = "SELECT C.ID, RT.Name AS RevenueType, C.Product
        FROM Concession AS C
        JOIN RevenueType AS RT ON C.ID = RT.ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concessions Management</title>
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
    <h2>Concessions Management</h2>

    <a href="create_concession.php">Create New Concession</a>

    <!-- Display a paginated list of concessions with links to update and delete -->
    <table border="1">
        <tr>
            <th>Concession ID</th>
            <th>Revenue Type</th>
            <th>Product</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['RevenueType']; ?></td>
                <td><?php echo $row['Product']; ?></td>
                <td>
                    <a href="update_concession.php?id=<?php echo $row['ID']; ?>">Update</a>
                    <?php if ($_SESSION['role'] === 'Admin') : ?>
                        <a href="delete_concession.php?id=<?php echo $row['ID']; ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href = "../dashboard.php"> Go to Dashboard</a>
</body>
</html>
