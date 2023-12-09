<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Check if species ID is provided in the URL
if (isset($_GET['id'])) {
    $speciesId = $_GET['id'];

    // Fetch species details
    $fetchSql = "SELECT * FROM Species WHERE ID = ?";
    $fetchStmt = $conn->prepare($fetchSql);
    $fetchStmt->bind_param("i", $speciesId);
    $fetchStmt->execute();
    $speciesResult = $fetchStmt->get_result();

    if ($speciesResult->num_rows == 1) {
        $species = $speciesResult->fetch_assoc();
    } else {
        echo "Species not found.";
        exit();
    }
} else {
    echo "Species ID not provided.";
    exit();
}

// Handle species update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateSpecies"])) {
    $name = $_POST["name"];
    $foodCost = $_POST["foodCost"];

    // Perform the necessary database operations to update the species
    $updateSql = "UPDATE Species SET Name = ?, FoodCost = ? WHERE ID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sii", $name, $foodCost, $speciesId);
    $updateStmt->execute();
    $updateStmt->close();

    echo "Species updated successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Species</title>
</head>
<body>
    <h2>Update Species</h2>

    <!-- Species update form -->
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $species['Name']; ?>" required><br>

        <label for="foodCost">Food Cost:</label>
        <input type="number" name="foodCost" value="<?php echo $species['FoodCost']; ?>" required><br>

        <button type="submit" name="updateSpecies">Update Species</button>
    </form>

    <a href="view_species.php">Back to Species</a>
</body>
</html>
