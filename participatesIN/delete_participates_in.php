<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the ID from the URL parameters
$id = $_GET['id'];

// Delete the Participates In relationship record from the database
$deleteSql = "DELETE FROM ParticipatesIN WHERE ID = ?";
$stmt = $conn->prepare($deleteSql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: view_participates_in.php");
exit();
?>
