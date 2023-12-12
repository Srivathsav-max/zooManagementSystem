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

// Retrieve animal details based on the ID from the query parameters
if (isset($_GET['id'])) {
    $animalId = $_GET['id'];
    $sql = "SELECT a.ID, a.Status, a.BirthYear, a.SpeciesID, a.BuildingID, a.EnclosureID,
            s.Name AS SpeciesName, b.Name AS BuildingName, e.SqFt
            FROM Animal a
            LEFT JOIN Species s ON a.SpeciesID = s.ID
            LEFT JOIN Building b ON a.BuildingID = b.ID
            LEFT JOIN Enclosure e ON a.EnclosureID = e.ID
            WHERE a.ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $animalId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $animal = $result->fetch_assoc();

        // Display the current animal details (for debugging)
        // print_r($animal);

        // Handle animal update form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateAnimal"])) {
            $newStatus = $_POST["status"];
            $newBirthYear = $_POST["birthYear"];
            $newSpeciesId = ($_POST["species"] !== "") ? $_POST["species"] : null;
            $newBuildingId = ($_POST["building"] !== "") ? $_POST["building"] : null;
            $newEnclosureId = ($_POST["enclosure"] !== "") ? $_POST["enclosure"] : null;

            // Perform the necessary database operations to update the animal
            $updateSql = "UPDATE Animal
                          SET Status = ?, BirthYear = ?, SpeciesID = NULLIF(?, ''),
                          BuildingID = NULLIF(?, ''), EnclosureID = NULLIF(?, '')
                          WHERE ID = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ssiiii", $newStatus, $newBirthYear, $newSpeciesId, $newBuildingId, $newEnclosureId, $animalId);
            $updateStmt->execute();
            $updateStmt->close();

            // For debugging, add the following line to display the posted data
            // print_r($_POST);

            echo "Animal updated successfully.";
        }
    } else {
        echo "Animal not found.";
        echo "Error: " . $conn->error;  // Add this line for additional error information
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
    <title>Update Animal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            width: 50%;
            margin: 20px auto;
            background-color: rgba(144, 238, 144, 0.3);
            padding: 20px;
            border-radius: 8px;
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
        }

        button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a {
            display: block;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <h2>Update Animal</h2>

    <!-- Animal update form -->
    <form method="post" action="">
        <label for="status">Status:</label>
        <input type="text" name="status" value="<?php echo $animal['Status']; ?>" required><br>

        <label for="birthYear">Birth Year:</label>
        <input type="number" name="birthYear" value="<?php echo $animal['BirthYear']; ?>" required><br>

        <label for="species">Species:</label>
        <select name="species">
            <option value="" <?php echo ($animal['SpeciesID'] === null) ? 'selected' : ''; ?>>None</option>
            <?php
            // Reset the pointer to the beginning of the species result set
            $speciesResult->data_seek(0);
            while ($species = $speciesResult->fetch_assoc()) :
                $selected = ($species['ID'] == $animal['SpeciesID']) ? 'selected' : '';
            ?>
                <option value="<?php echo $species['ID']; ?>" <?php echo $selected; ?>><?php echo $species['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="building">Building:</label>
        <select name="building">
            <option value="" <?php echo ($animal['BuildingID'] === null) ? 'selected' : ''; ?>>None</option>
            <?php
            // Reset the pointer to the beginning of the building result set
            $buildingResult->data_seek(0);
            while ($building = $buildingResult->fetch_assoc()) :
                $selected = ($building['ID'] == $animal['BuildingID']) ? 'selected' : '';
            ?>
                <option value="<?php echo $building['ID']; ?>" <?php echo $selected; ?>><?php echo $building['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="enclosure">Enclosure:</label>
        <select name="enclosure">
            <option value="" <?php echo ($animal['EnclosureID'] === null) ? 'selected' : ''; ?>>None</option>
            <?php
            // Reset the pointer to the beginning of the enclosure result set
            $enclosureResult->data_seek(0);
            while ($enclosure = $enclosureResult->fetch_assoc()) :
                $selected = ($enclosure['ID'] == $animal['EnclosureID']) ? 'selected' : '';
            ?>
                <option value="<?php echo $enclosure['ID']; ?>" <?php echo $selected; ?>><?php echo $enclosure['SqFt']; ?> SqFt</option>
            <?php endwhile; ?>
        </select><br>

        <button type="submit" name="updateAnimal">Update Animal</button>
    </form>

    <a href="view_animals.php">Back to Animals</a>
</body>
</html>
