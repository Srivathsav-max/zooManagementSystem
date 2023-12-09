<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Check if the user is not logged in, redirect to login page
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Check if the user is an admin, otherwise deny access
if ($_SESSION['role'] !== 'Admin') {
    echo "Access denied. Only admins can access this page.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enclosure Management</title>
</head>
<body>
    <h1>Enclosure Management</h1>
    
    <ul>
        <li><a href="view_enclosures.php">View Enclosures</a></li>
        <li><a href="create_enclosure.php">Create New Enclosure</a></li>
        <!-- Add more links for other features (update, delete, etc.) if needed -->
    </ul>

    <a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>
