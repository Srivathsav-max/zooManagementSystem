<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available species and animal shows for dropdowns
$speciesSql = "SELECT ID, Name FROM Species";
$speciesResult = $conn->query($speciesSql);

$animalShowSql = "SELECT AnimalShowID FROM AnimalShow"; // Assuming AnimalShowID is the column for AnimalShow
$animalShowResult = $conn->query($animalShowSql);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createParticipatesIn"])) {
    $speciesID = $_POST["speciesID"];
    $animalShowID = $_POST["animalShowID"];
    $reqd = $_POST["reqd"];

    // Check if a relationship with the selected AnimalShowID already exists
    $checkSql = "SELECT COUNT(*) as count FROM ParticipatesIN WHERE AnimalShowID = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $animalShowID);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $count = $checkResult->fetch_assoc()['count'];

    if ($count > 0) {
        // If a relationship already exists, update the existing record
        $updateSql = "UPDATE ParticipatesIN SET SpeciesID = ?, Reqd = ? WHERE AnimalShowID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("iii", $speciesID, $reqd, $animalShowID);
        $updateStmt->execute();
        $updateStmt->close();
        echo "Relationship updated successfully.";
    } else {
        // If no relationship exists, insert a new record
        $insertSql = "INSERT INTO ParticipatesIN (SpeciesID, AnimalShowID, Reqd) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("iii", $speciesID, $animalShowID, $reqd);
        $insertStmt->execute();
        $insertStmt->close();
        echo "Relationship created successfully.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Participates In Relationship</title>
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
    <h2>Create Participates In Relationship</h2>

    <!-- Participates In relationship creation form -->
    <form method="post" action="">
        <label for="speciesID">Species:</label>
        <select name="speciesID" required>
            <?php while ($species = $speciesResult->fetch_assoc()) : ?>
                <option value="<?php echo $species['ID']; ?>"><?php echo $species['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="animalShowID">Animal Show ID:</label>
        <select name="animalShowID" required>
            <?php while ($animalShow = $animalShowResult->fetch_assoc()) : ?>
                <option value="<?php echo $animalShow['AnimalShowID']; ?>"><?php echo $animalShow['AnimalShowID']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="reqd">Required:</label>
        <input type="number" name="reqd" required><br>

        <button type="submit" name="createParticipatesIn">Create/Update Relationship</button>
    </form>

    <a href="view_participates_in.php">Back to Participates In Relationships</a>
</body>
</html>
