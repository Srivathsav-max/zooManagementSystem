<?php
// Include the common database connection file
include '../includes/db_connection.php';

session_start();

// Fetch species
$sql = "SELECT * FROM Species";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Species</title>
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
    <h2>View Species</h2>
    <a href="create_species.php">Create New Species</a>
    <!-- Display species in a table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Food Cost</th>
            <th>Updated Date</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($species = $result->fetch_assoc()) :
        ?>
            <tr>
                <td><?php echo $species['ID']; ?></td>
                <td><?php echo $species['Name']; ?></td>
                <td><?php echo $species['FoodCost']; ?></td>
                <td><?php echo $species['updated_date']; ?></td>
                <td>
                    <a href="view_specie.php?id=<?php echo $species['ID']; ?>">View</a>
                    <a href="update_species.php?id=<?php echo $species['ID']; ?>">Update</a>
                    <?php if ($_SESSION['role'] === 'Admin') : ?>
                        <a href="delete_species.php?id=<?php echo $species['ID']; ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href = "../dashboard.php">Back to Dashboard</a>
</body>
</html>
