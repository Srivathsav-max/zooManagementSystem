<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch the ID of the animal show to be deleted
$animalShowID = $_GET['id'];

// Prepare and execute the SQL statement to delete the animal show
$deleteSql = "DELETE FROM animalshow WHERE AnimalShowID = ?";
$deleteStmt = $conn->prepare($deleteSql);
$deleteStmt->bind_param("i", $animalShowID);
$deleteStmt->execute();
$deleteStmt->close();

// Redirect back to the animal shows list page
header("Location: view_animal_shows.php");
exit();
?>
