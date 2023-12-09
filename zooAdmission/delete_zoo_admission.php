<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the Zoo Admission ID from the URL parameter
$zooAdmissionId = $_GET['id'];

// Delete the Zoo Admission record from the database
$deleteSql = "DELETE FROM ZooAdmission WHERE ID = ?";
$stmt = $conn->prepare($deleteSql);
$stmt->bind_param("i", $zooAdmissionId);
$stmt->execute();
$stmt->close();

header("Location: view_zoo_admissions.php");
exit();
?>
