<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch animal shows from the database
$sql = "SELECT ASH.ID, RT.Name AS RevenueType, ASH.ShowsPerDay, ASH.SeniorPrice, ASH.AdultPrice, ASH.ChildPrice
        FROM AnimalShow AS ASH
        JOIN RevenueType AS RT ON ASH.ID = RT.ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Shows Management</title>
    
</head>
<body>
    <h2>Animal Shows Management</h2>

    <a href="create_animal_show.php">Create New Animal Show</a>

    <!-- Display a paginated list of animal shows with links to update and delete -->
    <table border="1">
        <tr>
            <th>Animal Show ID</th>
            <th>Revenue Type</th>
            <th>Shows Per Day</th>
            <th>Senior Price</th>
            <th>Adult Price</th>
            <th>Child Price</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['RevenueType']; ?></td>
                <td><?php echo $row['ShowsPerDay']; ?></td>
                <td><?php echo $row['SeniorPrice']; ?></td>
                <td><?php echo $row['AdultPrice']; ?></td>
                <td><?php echo $row['ChildPrice']; ?></td>
                <td>
                    <a href="update_animal_show.php?id=<?php echo $row['ID']; ?>">Update</a> |
                    <a href="delete_animal_show.php?id=<?php echo $row['ID']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
