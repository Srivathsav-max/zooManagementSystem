<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Check if species ID is provided in the URL
if (isset($_GET['id'])) {
    $speciesId = $_GET['id'];

    // Perform the necessary database operations to delete the species
    $deleteSql = "DELETE FROM Species WHERE ID = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $speciesId);
    $deleteStmt->execute();
    $deleteStmt->close();

    echo "Species deleted successfully.";
} else {
    echo "Species ID not provided.";
}
?>
