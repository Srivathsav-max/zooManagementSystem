<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the Zoo Admission ID from the URL parameter
$zooAdmissionId = $_GET['id'];

// Fetch the zoo admission details from the database
$sql = "SELECT ZooAdmission.ID, RevenueType.Name AS RevenueTypeName, SeniorPrice, AdultPrice, ChildPrice 
        FROM ZooAdmission
        JOIN RevenueType ON ZooAdmission.ID = RevenueType.ID
        WHERE ZooAdmission.ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $zooAdmissionId);
$stmt->execute();
$result = $stmt->get_result();
$zooAdmission = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Zoo Admission</title>
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
    <h2>Update Zoo Admission</h2>

    <!-- Zoo Admission update form -->
    <form method="post" action="">
        <label for="revenueTypeName">Revenue Type:</label>
        <input type="text" name="revenueTypeName" value="<?php echo $zooAdmission['RevenueTypeName']; ?>" readonly><br>

        <label for="seniorPrice">Senior Price:</label>
        <input type="number" name="seniorPrice" value="<?php echo $zooAdmission['SeniorPrice']; ?>" required><br>

        <label for="adultPrice">Adult Price:</label>
        <input type="number" name="adultPrice" value="<?php echo $zooAdmission['AdultPrice']; ?>" required><br>

        <label for="childPrice">Child Price:</label>
        <input type="number" name="childPrice" value="<?php echo $zooAdmission['ChildPrice']; ?>" required><br>

        <button type="submit" name="updateZooAdmission">Update Zoo Admission</button>
    </form>

    <a href="view_zoo_admissions.php">Back to Zoo Admissions</a>
</body>
</html>

<?php
// Handle update zoo admission form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateZooAdmission"])) {
    $seniorPrice = $_POST["seniorPrice"];
    $adultPrice = $_POST["adultPrice"];
    $childPrice = $_POST["childPrice"];

        // Update the Zoo Admission details in the database
        $updateSql = "UPDATE ZooAdmission SET SeniorPrice = ?, AdultPrice = ?, ChildPrice = ? WHERE ID = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("iii", $seniorPrice, $adultPrice, $childPrice, $zooAdmissionId);
        $stmt->execute();
        $stmt->close();
    
        echo "Zoo Admission updated successfully.";
    }
    ?>
    
