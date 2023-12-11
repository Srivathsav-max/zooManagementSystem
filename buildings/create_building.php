<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Handle form submission to create a new building
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createBuilding"])) {
    $name = $_POST["name"];
    $type = $_POST["type"];

    // Perform the necessary database operations to create a new building
    $sql = "INSERT INTO Building (Name, Type) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $type);
    $stmt->execute();
    $stmt->close();

    echo "Building created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Building</title>
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
    <h2>Create New Building</h2>

    <!-- Building creation form -->
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="type">Type:</label>
        <input type="text" name="type" required><br>

        <button type="submit" name="createBuilding">Create Building</button>
    </form>

    <a href="view_buildings.php">Back to Buildings</a>
</body>
</html>
