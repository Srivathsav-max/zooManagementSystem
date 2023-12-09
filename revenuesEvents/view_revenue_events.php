<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch revenue events from the database
$sql = "SELECT * FROM RevenueEvents";
$result = $conn->query($sql);

// Display a list of revenue events with links to view, update, and delete
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Events Management</title>
</head>
<body>
    <h2>Revenue Events Management</h2>

    <a href="create_revenue_event.php">Create New Revenue Event</a>

    <!-- Display a paginated list of revenue events with links to view, update, and delete -->
    <table border="1">
        <tr>
            <th>Revenue Type ID</th>
            <th>Date and Time</th>
            <th>Revenue</th>
            <th>Tickets Sold</th>
            <!-- Add more columns as needed -->
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['DateTime']; ?></td>
                <td><?php echo $row['Revenue']; ?></td>
                <td><?php echo $row['TicketsSold']; ?></td>
                <!-- Display more columns as needed -->
                <td>
                    <a href="view_revenue_event.php?id=<?php echo $row['ID']; ?>">View</a> |
                    <a href="update_revenue_event.php?id=<?php echo $row['ID']; ?>">Update</a> |
                    <a href="delete_revenue_event.php?id=<?php echo $row['ID']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
