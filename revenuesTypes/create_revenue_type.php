<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available buildings for dropdown
$buildingSql = "SELECT ID, Name FROM Building";
$buildingResult = $conn->query($buildingSql);

// Define allowed revenue types
$allowedRevenueTypes = ['Animal Show', 'Concession', 'Zoo Admission'];

// Handle revenue type creation form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createRevenueType"])) {
    $name = $_POST["name"];
    $type = $_POST["type"];
    $buildingId = $_POST["buildingId"];

    // Check if the submitted revenue type is allowed
    if (!in_array($type, $allowedRevenueTypes)) {
        echo "Invalid revenue type. Please select a valid type.";
        exit();
    }

    $createSql = "INSERT INTO RevenueType (Name, Type, BuildingID) VALUES (?, ?, ?)";
    $createStmt = $conn->prepare($createSql);
    $createStmt->bind_param("ssi", $name, $type, $buildingId);
    $createStmt->execute();
    $createStmt->close();

    header("Location: revenue_types.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Revenue Type</title>
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
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
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

        a:hover {
            background-color: #2980b9;
        }

    </style>
</head>
<body>
    <h2>Create Revenue Type</h2>

    <!-- Revenue type creation form -->
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="type">Type:</label>
        <select name="type" required>
            <?php foreach ($allowedRevenueTypes as $allowedType) : ?>
                <option value="<?php echo $allowedType; ?>"><?php echo $allowedType; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="buildingId">Building:</label>
        <select name="buildingId" required>
            <?php while ($building = $buildingResult->fetch_assoc()) : ?>
                <option value="<?php echo $building['ID']; ?>"><?php echo $building['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <button type="submit" name="createRevenueType">Create Revenue Type</button>
    </form>

    <a href="revenue_types.php">Back to Revenue Types</a>
</body>
</html>
