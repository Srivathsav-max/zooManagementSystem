<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the ID from the URL parameters
$id = $_GET['id'];

// Fetch the current Participates In relationship details
$sql = "SELECT * FROM ParticipatesIN WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

// Handle form submission for updating the Participates In relationship
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateParticipatesIn"])) {
    $newSpeciesID = $_POST["newSpeciesID"];
    $newAnimalShowID = $_POST["newAnimalShowID"];
    $newRequired = $_POST["newRequired"];

    // Update the Participates In relationship details in the database
    $updateSql = "UPDATE ParticipatesIN SET SpeciesID = ?, AnimalShowID = ?, Reqd = ? WHERE ID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("iiii", $newSpeciesID, $newAnimalShowID, $newRequired, $id);
    $stmt->execute();
    $stmt->close();

    echo "Participates In relationship updated successfully.";
}

// Fetch available species for dropdown
$speciesSql = "SELECT ID, Name FROM Species";
$speciesResult = $conn->query($speciesSql);

// Fetch available animal shows for dropdown
$animalShowSql = "SELECT ID, AnimalShowID FROM AnimalShow";
$animalShowResult = $conn->query($animalShowSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Participates In Relationship</title>
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
    <h2>Update Participates In Relationship</h2>

    <!-- Participates In relationship update form -->
    <form method="post" action="">
        <label for="newSpeciesID">New Species:</label>
        <select name="newSpeciesID" required>
            <?php while ($species = $speciesResult->fetch_assoc()) : ?>
                <option value="<?php echo $species['ID']; ?>" <?php echo ($species['ID'] == $row['SpeciesID']) ? 'selected' : ''; ?>>
                    <?php echo $species['Name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <label for="newAnimalShowID">New Animal Show:</label>
        <select name="newAnimalShowID" required>
            <?php while ($animalShow = $animalShowResult->fetch_assoc()) : ?>
                <option value="<?php echo $animalShow['ID']; ?>" <?php echo ($animalShow['ID'] == $row['AnimalShowID']) ? 'selected' : ''; ?>>
                    <?php echo $animalShow['AnimalShowID']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <label for="newRequired">New Required:</label>
        <input type="number" name="newRequired" value="<?php echo $row['Reqd']; ?>" required><br>

        <button type="submit" name="updateParticipatesIn">
            Update Relationship
        </button>
    </form>

    <a href="view_participates_in.php">Back to Participates In Relationships</a>
</body>
</html>
