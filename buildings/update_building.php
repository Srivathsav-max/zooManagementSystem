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

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a {
            display: block;
            margin-top: 15px;
            text-align: center;
            text-decoration: none;
            color: #333;
        }
    </style>
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

