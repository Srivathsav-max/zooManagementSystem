<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Handle form submission to create a new building
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createBuilding"])) {
    $name = $_POST["name"];
    $type = $_POST["type"];

    // Perform the necessary database operations to create a new building
    $sql = "INSERT INTO Building (Name, Type) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $type);
    $stmt->execute();
    $stmt->close();

    echo "Building created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Building</title>
</head>
<body>
    <h2>Create New Building</h2>

    <!-- Building creation form -->
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="type">Type:</label>
        <input type="text" name="type" required><br>

        <button type="submit" name="createBuilding">Create Building</button>
    </form>

    <a href="view_buildings.php">Back to Buildings</a>
</body>
</html>
