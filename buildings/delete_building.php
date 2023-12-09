<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Handle the deletion of the building based on the ID from the query parameters
if (isset($_GET['id'])) {
    $buildingId = $_GET['id'];

    // Perform the necessary database operations to delete the building
    $deleteSql = "DELETE FROM Building WHERE ID = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $buildingId);
    $deleteStmt->execute();
    $deleteStmt->close();

    echo "Building deleted successfully.";
} else {
    echo "Invalid request.";
}

header("Location: view_buildings.php");
exit();
?>