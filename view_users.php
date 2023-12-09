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

// Handle delete user action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['username'])) {
    $usernameToDelete = $_GET['username'];

    // Perform the necessary database operations to delete the user
    $sql = "DELETE FROM Users WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usernameToDelete);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the view_users.php page after deletion
    header("Location: view_users.php");
    exit();
}

// Fetch all users from the database
$sql = "SELECT * FROM Users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>
    <h2>View All Users</h2>

    <!-- Create User button -->
    <a href="create_user.php">Create User</a>

    <!-- Display users in a table -->
    <table border="1">
        <tr>
            <th>Username</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['Username']; ?></td>
                <td><?= $row['Role']; ?></td>
                <td>
                    <a href="edit_user.php?username=<?= $row['Username']; ?>">Update</a>
                    <a href="view_users.php?action=delete&username=<?= $row['Username']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <ul>
        <li><a href="dashboard.php">Back to Dashboard</a></li>
    </ul>
</body>
</html>