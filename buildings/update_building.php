<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve building details based on the ID from the query parameters
if (isset($_GET['id'])) {
    $buildingId = $_GET['id'];
    $sql = "SELECT * FROM Building WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $buildingId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $building = $result->fetch_assoc();
    } else {
        echo "Building not found.";
        exit();
    }

    $stmt->close();
} else {
    echo "Invalid request.";
    exit();
}

// Handle form submission to update the building
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateBuilding"])) {
    $name = $_POST["name"];
    $type = $_POST["type"];

    // Perform the necessary database operations to update the building
    $updateSql = "UPDATE Building SET Name = ?, Type = ? WHERE ID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssi", $name, $type, $buildingId);
    $updateStmt->execute();
    $updateStmt->close();

    echo "Building updated successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Building</title>
</head>
<body>
    <h2>Update Building</h2>

    <!-- Building update form -->
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $building['Name']; ?>" required><br>

        <label for="type">Type:</label>
        <input type="text" name="type" value="<?php echo $building['Type']; ?>" required><br>

        <button type="submit" name="updateBuilding">Update Building</button>
    </form>

    <a href="view_buildings.php">Back to Buildings</a>
</body>
</html>

