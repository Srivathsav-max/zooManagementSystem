<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available revenue types for dropdown
$revenueTypeSql = "SELECT ID, Name FROM RevenueType";
$revenueTypeResult = $conn->query($revenueTypeSql);

// Fetch the details of the selected animal show
$showId = $_GET['id'];
$showSql = "SELECT * FROM AnimalShow WHERE ID = ?";
$showStmt = $conn->prepare($showSql);
$showStmt->bind_param("i", $showId);
$showStmt->execute();
$showResult = $showStmt->get_result();
$show = $showResult->fetch_assoc();
$showStmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Animal Show</title>
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
    <h2>Update Animal Show</h2>

    <!-- Animal show update form -->
    <form method="post" action="">
        <label for="revenueTypeId">Revenue Type:</label>
        <select name="revenueTypeId" required>
            <?php while ($revenueType = $revenueTypeResult->fetch_assoc()) : ?>
                <option value="<?php echo $revenueType['ID']; ?>" <?php echo ($revenueType['ID'] == $show['ID']) ? 'selected' : ''; ?>>
                    <?php echo $revenueType['Name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <label for="showsPerDay">Shows Per Day:</label>
        <input type="number" name="showsPerDay" value="<?php echo $show['ShowsPerDay']; ?>" required><br>

        <label for="seniorPrice">Senior Price:</label>
        <input type="number" name="seniorPrice" value="<?php echo $show['SeniorPrice']; ?>" required><br>

        <label for="adultPrice">Adult Price:</label>
        <input type="number" name="adultPrice" value="<?php echo $show['AdultPrice']; ?>" required><br>

        <label for="childPrice">Child Price:</label>
        <input type="number" name="childPrice" value="<?php echo $show['ChildPrice']; ?>" required><br>

        <button type="submit" name="updateAnimalShow">Update Animal Show</button>
    </form>

    <a href="view_animal_shows.php">Back to Animal Shows</a>
</body>
</html>

<?php
// Handle animal show update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateAnimalShow"])) {
    $revenueTypeId = $_POST["revenueTypeId"];
    $showsPerDay = $_POST["showsPerDay"];
    $seniorPrice = $_POST["seniorPrice"];
    $adultPrice = $_POST["adultPrice"];
    $childPrice = $_POST["childPrice"];

    // Prepare and execute the SQL statement to update the animal show
    $updateSql = "UPDATE AnimalShow SET ID = ?, ShowsPerDay = ?, SeniorPrice = ?, AdultPrice = ?, ChildPrice = ? WHERE ID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("iiiidi", $revenueTypeId, $showsPerDay, $seniorPrice, $adultPrice, $childPrice, $showId);
    $updateStmt->execute();
    $updateStmt->close();

    // Redirect back to the animal shows list page
    header("Location: view_animal_shows.php");
    exit();
}
?>
