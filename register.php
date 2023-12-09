<?php
// Include the common database connection file
include 'db_connection.php';

// Handle form submission for user registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registerUser"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $role = "User"; // Set a default role for registered users

    // Check if the username already exists
    $checkUsernameQuery = "SELECT * FROM Users WHERE Username = ?";
    $checkStmt = $conn->prepare($checkUsernameQuery);
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "Username already exists. Please choose a different username.";
    } elseif ($password !== $confirmPassword) {
        echo "Password and Confirm Password do not match.";
    } else {
        // Perform the necessary database operations to register a new user
        $insertQuery = "INSERT INTO Users (Username, Password, Role) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("sss", $username, $password, $role);
        $insertStmt->execute();
        $insertStmt->close();

        echo "Registration successful. You can now log in.";
    }

    $checkStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>
    <h2>User Registration</h2>

    <!-- User Registration form -->
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword" required><br>

        <button type="submit" name="registerUser">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Log in here</a>.</p>

    <ul>
        <!-- Add more navigation links if needed -->
    </ul>
</body>
</html>
