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
</head>
<body>
    <h2>View Species</h2>

    <!-- Display species in a table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Food Cost</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($species = $result->fetch_assoc()) :
        ?>
            <tr>
                <td><?php echo $species['ID']; ?></td>
                <td><?php echo $species['Name']; ?></td>
                <td><?php echo $species['FoodCost']; ?></td>
                <td>
                    <a href="update_species.php?id=<?php echo $species['ID']; ?>">Update</a> |
                    <?php if ($_SESSION['role'] === 'Admin') : ?>
                        <a href="delete_species.php?id=<?php echo $species['ID']; ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="create_species.php">Create New Species</a>
</body>
</html>
