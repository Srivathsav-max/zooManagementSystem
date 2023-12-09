<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Handle species creation form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createSpecies"])) {
    $name = $_POST["name"];
    $foodCost = $_POST["foodCost"];

    // Perform the necessary database operations to create a new species
    $createSql = "INSERT INTO Species (Name, FoodCost) VALUES (?, ?)";
    $createStmt = $conn->prepare($createSql);
    $createStmt->bind_param("si", $name, $foodCost);
    $createStmt->execute();
    $createStmt->close();

    echo "Species created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Species</title>
</head>
<body>
    <h2>Create Species</h2>

    <!-- Species creation form -->
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="foodCost">Food Cost:</label>
        <input type="number" name="foodCost" required><br>

        <button type="submit" name="createSpecies">Create Species</button>
    </form>

    <a href="view_species.php">Back to Species</a>
</body>
</html>
