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
if ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Manager') {
    echo "Access denied. Only admins can access this page.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Species Management</title>
</head>
<body>
    <h1>Species Management</h1>
    
    <ul>
        <li><a href="view_species.php">View Species</a></li>
        <li><a href="create_species.php">Create New Species</a></li>
        <!-- Add more navigation links for other features -->
    </ul>

</body>
</html>
