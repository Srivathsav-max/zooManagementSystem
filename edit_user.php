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

// Fetch user details based on the provided username
if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $sql = "SELECT * FROM Users WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "Username not provided.";
    exit();
}

// Handle form submission for updating user details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateUser"])) {
    $newRole = $_POST["role"];

    // Perform the necessary database operations to update the user's role
    $sql = "UPDATE Users SET Role = ? WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $newRole, $username);
    $stmt->execute();
    $stmt->close();
    echo "User role updated successfully.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>
    <h2>Edit User - <?= $user['Username']; ?></h2>

    <!-- Display user details and form for updating role -->
    <p>Current Role: <?= $user['Role']; ?></p>
    
    <form method="post" action="">
        <label for="role">Select New Role:</label>
        <select name="role" id="role">
            <option value="Admin" <?= ($user['Role'] === 'Admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="User" <?= ($user['Role'] === 'User') ? 'selected' : ''; ?>>User</option>
            <option value="Manager" <?= ($user['Role'] === 'Manager') ? 'selected' : ''; ?>>Manager</option>
            <!-- Add more options if needed -->
        </select>
        <button type="submit" name="updateUser">Update Role</button>
    </form>

    <ul>
        <li><a href="view_users.php">Back to View Users</a></li>
    </ul>
</body>
</html>
