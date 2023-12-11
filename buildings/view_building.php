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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Building</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(144, 238, 144, 0.3); /* Light green with reduced opacity */
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        p {
            margin-bottom: 10px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <h2>View Building</h2>

    <!-- Display building details -->
    <p><strong>Building ID:</strong> <?php echo $building['ID']; ?></p>
    <p><strong>Name:</strong> <?php echo $building['Name']; ?></p>
    <p><strong>Type:</strong> <?php echo $building['Type']; ?></p>

    <a href="view_buildings.php">Back to Buildings</a>
</body>
</html>
