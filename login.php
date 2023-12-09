<?php
session_start();

// Check if the user is already logged in, redirect if true
if (isset($_SESSION['username'])) {
    // Redirect admin to dashboard.php
    if ($_SESSION['role'] === 'Admin') {
        header("Location: dashboard.php");
        exit();
    } elseif ($_SESSION['role'] === 'Manager') {
        // Redirect manager to asset_management.php
        header("Location: asset_management.php");
        exit();
    } else {
        // Redirect other users to their respective pages
        header("Location: index.php");
        exit();
    }
}

// Include the common database connection file
include 'db_connection.php';

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM Users WHERE Username = ? AND Password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['Username'];
        $_SESSION['role'] = $user['Role'];

        // Redirect admin to dashboard.php
        if ($_SESSION['role'] === 'Admin') {
            header("Location: dashboard.php");
            exit();
        } elseif ($_SESSION['role'] === 'Manager') {
            // Redirect manager to asset_management.php
            header("Location: asset_management.php");
            exit();
        } else {
            // Redirect other users to their respective pages
            header("Location: index.php");
            exit();
        }
    } else {
        echo "Invalid username or password";
    }

    $stmt->close();
}
?>
<!-- Rest of your HTML content -->

<!-- Login form -->
<form action="login.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Login</button>
</form>
<p>Don't have an account? <a href="register.php">Sign Up in here</a>.</p>
</body>
</html>
