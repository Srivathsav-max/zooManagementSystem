<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch species for dropdown
$speciesSql = "SELECT * FROM Species";
$speciesResult = $conn->query($speciesSql);

// Fetch buildings for dropdown
$buildingSql = "SELECT * FROM Building";
$buildingResult = $conn->query($buildingSql);

// Fetch enclosures for dropdown
$enclosureSql = "SELECT * FROM Enclosure";
$enclosureResult = $conn->query($enclosureSql);

// Handle animal creation form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createAnimal"])) {
    $status = $_POST["status"];
    $birthYear = $_POST["birthYear"];
    $speciesId = $_POST["species"];
    $buildingId = $_POST["building"];
    $enclosureId = $_POST["enclosure"];

    // Perform the necessary database operations to create a new animal
    $createSql = "INSERT INTO Animal (Status, BirthYear, SpeciesID, BuildingID, EnclosureID)
                  VALUES (?, ?, ?, ?, ?)";
    $createStmt = $conn->prepare($createSql);
    $createStmt->bind_param("ssiii", $status, $birthYear, $speciesId, $buildingId, $enclosureId);
    $createStmt->execute();
    $createStmt->close();

    echo "Animal created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Animal</title>
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
    <h2>Create Animal</h2>

    <!-- Animal creation form -->
    <!-- Animal creation form -->
    <form method="post" action="">
        <label for="status">Status:</label>
        <input type="text" name="status" required><br>

        <label for="birthYear">Birth Year:</label>
        <select name="birthYear" required>
            <?php
            // Generate options for birth year dropdown
            $currentYear = date("Y");
            for ($year = $currentYear; $year >= $currentYear - 30; $year--) {
                echo "<option value=\"$year\">$year</option>";
            }
            ?>
        </select><br>

        <label for="species">Species:</label>
        <select name="species" required>
            <?php
            // Reset the pointer to the beginning of the species result set
            $speciesResult->data_seek(0);
            while ($species = $speciesResult->fetch_assoc()) :
            ?>
                <option value="<?php echo $species['ID']; ?>"><?php echo $species['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="building">Building:</label>
        <select name="building" required>
            <?php
            // Reset the pointer to the beginning of the building result set
            $buildingResult->data_seek(0);
            while ($building = $buildingResult->fetch_assoc()) :
            ?>
                <option value="<?php echo $building['ID']; ?>"><?php echo $building['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="enclosure">Enclosure:</label>
        <select name="enclosure" required>
            <?php
            // Reset the pointer to the beginning of the enclosure result set
            $enclosureResult->data_seek(0);
            while ($enclosure = $enclosureResult->fetch_assoc()) :
            ?>
                <option value="<?php echo $enclosure['ID']; ?>"><?php echo $enclosure['SqFt']; ?> SqFt</option>
            <?php endwhile; ?>
        </select><br>

        <button type="submit" name="createAnimal">Create Animal</button>
    </form>

    <a href="view_animals.php">Back to Animals</a>
</body>
</html>
