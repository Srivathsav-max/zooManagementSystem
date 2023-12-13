<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available revenue types for dropdown
$revenueTypeSql = "SELECT ID, Name FROM RevenueType";
$revenueTypeResult = $conn->query($revenueTypeSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Animal Show</title>
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
    <h2>Create Animal Show</h2>

    <!-- Animal show creation form -->
    <form method="post" action="">
        <label for="revenueTypeId">Revenue Type:</label>
        <select name="revenueTypeId" required>
            <?php while ($revenueType = $revenueTypeResult->fetch_assoc()) : ?>
                <option value="<?php echo $revenueType['ID']; ?>"><?php echo $revenueType['Name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="showsPerDay">Shows Per Day:</label>
        <input type="number" name="showsPerDay" required><br>

        <label for="seniorPrice">Senior Price:</label>
        <input type="number" name="seniorPrice" required><br>

        <label for="adultPrice">Adult Price:</label>
        <input type="number" name="adultPrice" required><br>

        <label for="childPrice">Child Price:</label>
        <input type="number" name="childPrice" required><br>

        <button type="submit" name="createAnimalShow">Create Animal Show</button>
    </form>

    <a href="view_animal_shows.php">Back to Animal Shows</a>
</body>
</html>

<?php
// Handle animal show creation form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createAnimalShow"])) {
    $revenueTypeId = $_POST["revenueTypeId"];
    $name = $_POST["name"];
    $showsPerDay = $_POST["showsPerDay"];
    $seniorPrice = $_POST["seniorPrice"];
    $adultPrice = $_POST["adultPrice"];
    $childPrice = $_POST["childPrice"];

    // Prepare and execute the SQL statement to create a new animal show
    $createSql = "INSERT INTO AnimalShow (id, Name, ShowsPerDay, SeniorPrice, AdultPrice, ChildPrice) VALUES (?, ?, ?, ?, ?, ?)";
    $createStmt = $conn->prepare($createSql);
    $createStmt->bind_param("issiii", $revenueTypeId, $name, $showsPerDay, $seniorPrice, $adultPrice, $childPrice);
    $createStmt->execute();
    $createStmt->close();

    // Redirect back to the animal shows list page
    header("Location: view_animal_shows.php");
    exit();
}
?>
