<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is an admin, otherwise deny access
if ($_SESSION['role'] !== 'Admin') {
    echo "Access denied. Only admins can access this page.";
    exit();
}

// Include the common database connection file
include 'db_connection.php';

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Logout form -->
    <form method="post" action="">
        <button type="submit" name="logout">Logout</button>
    </form>

    <!-- View Users link -->
    <p><a href="view_users.php">View All Users</a></p>

    <ul>
        <li><a href="animal/animal.php">Animal Management</a></li>
        <li><a href="building.php">Building Management</a></li>
        <li><a href="attraction.php">Attraction Management</a></li>
        <li><a href="employee/employee.php">Employee Management</a></li>
        <li><a href="employee_hourly_wage.php">Employee Hourly Wages Management</a></li>
        <!-- Add more navigation links for other features -->
    </ul>
</body>
</html>
