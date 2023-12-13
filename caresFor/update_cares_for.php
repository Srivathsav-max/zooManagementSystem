<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Retrieve the Employee ID and Species ID from the URL parameters
$employeeID = $_GET['id'];
$speciesID = $_GET['speciesId'];

// Fetch the current Cares For relationship details
$sql = "SELECT * FROM CaresFor WHERE EmployeeID = ? AND SpeciesID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $employeeID, $speciesID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

// Handle form submission for updating the Cares For relationship
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateCaresFor"])) {
    $newEmployeeID = $_POST["newEmployeeID"];
    $newSpeciesID = $_POST["newSpeciesID"];

    // Update the Cares For relationship details in the database
    $updateSql = "UPDATE CaresFor SET EmployeeID = ?, SpeciesID = ? WHERE EmployeeID = ? AND SpeciesID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("iiii", $newEmployeeID, $newSpeciesID, $employeeID, $speciesID);
    $stmt->execute();
    $stmt->close();

    echo "Cares For relationship updated successfully.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Cares For Relationship</title>
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
    <h2>Update Cares For Relationship</h2>

    <!-- Cares For relationship update form -->
    <form method="post" action="">
        <label for="newEmployeeID">New Employee:</label>
        <select name="newEmployeeID" required>
            <?php
            // Fetch and display available employees in dropdown with specific job types
            $employeeQuery = "SELECT EmployeeID, CONCAT(FirstName, ' ', LastName) AS FullName FROM Employee 
                              WHERE JobType = 'Veterinarian' OR JobType = 'Animal Care Specialist'";
            $employeeResult = $conn->query($employeeQuery);
            
            while ($employee = $employeeResult->fetch_assoc()) {
                echo "<option value='{$employee['EmployeeID']}'";
                if ($employee['EmployeeID'] == $row['EmployeeID']) {
                    echo " selected";
                }
                echo ">{$employee['FullName']}</option>";
            }
            ?>
        </select><br>

        <label for="newSpeciesID">New Species:</label>
        <select name="newSpeciesID" required>
            <?php
            // Fetch and display available species in dropdown
            $speciesQuery = "SELECT ID, Name FROM Species";
            $speciesResult = $conn->query($speciesQuery);

            while ($species = $speciesResult->fetch_assoc()) {
                echo "<option value='{$species['ID']}'";
                if ($species['ID'] == $row['SpeciesID']) {
                    echo " selected";
                }
                echo ">{$species['Name']}</option>";
            }
            ?>
        </select><br>

        <button type="submit" name="updateCaresFor">Update Relationship</button>
    </form>

    <a href="view_cares_for.php">Back to Cares For Relationships</a>
</body>
</html>
