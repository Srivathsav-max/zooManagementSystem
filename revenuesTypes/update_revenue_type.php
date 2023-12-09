<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available buildings for dropdown
$buildingSql = "SELECT ID, Name FROM Building";
$buildingResult = $conn->query($buildingSql);

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing revenue type details
    $selectSql = "SELECT * FROM RevenueType WHERE ID = ?";
    $selectStmt = $conn->prepare($selectSql);
    $selectStmt->bind_param("i", $id);
    $selectStmt->execute();
    $result = $selectStmt->get_result();
    $revenueType = $result->fetch_assoc();
    $selectStmt->close();

    // Handle revenue type update form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateRevenueType"])) {
        $name = $_POST["name"];
        $type = $_POST["type"];
        $buildingId = $_POST["buildingId"];

        // Prepare and execute the SQL statement to update the revenue type
        $updateSql = "UPDATE RevenueType SET Name = ?, Type = ?, BuildingID = ? WHERE ID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ssii", $name, $type, $buildingId, $id);
        $updateStmt->execute();
        $updateStmt->close();

        // Redirect back to the revenue types list page
        header("Location: revenue_types.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Revenue Type</title>
</head>
<body>
    <h2>Update Revenue Type</h2>

    <!-- Revenue type update form -->
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $revenueType['Name']; ?>" required><br>

        <label for="type">Type:</label>
        <input type="text" name="type" value="<?php echo $revenueType['Type']; ?>" required><br>

        <label for="buildingId">Building:</label>
        <select name="buildingId" required>
            <?php while ($building = $buildingResult->fetch_assoc()) : ?>
                <option value="<?php echo $building['ID']; ?>" <?php echo ($building['ID'] == $revenueType['BuildingID']) ? 'selected' : ''; ?>>
                    <?php echo $building['Name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <button type="submit" name="updateRevenueType">Update Revenue Type</button>
    </form>

    <a href="revenue_types.php">Back to Revenue Types</a>
</body>
</html>
