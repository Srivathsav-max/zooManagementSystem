<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Handle concession sale form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["recordSale"])) {
    $concessionID = $_POST["concessionID"];
    $revenue = $_POST["revenue"];

    // Insert daily revenue record with sale date
    $insertRevenueSql = "INSERT INTO DailyConcessionRevenue (ConcessionID, Revenue) VALUES (?, ?)";
    $insertRevenueStmt = $conn->prepare($insertRevenueSql);
    $insertRevenueStmt->bind_param("id", $concessionID, $revenue);
    $insertRevenueStmt->execute();
    $insertRevenueStmt->close();
}

// Fetch and display concessions
$concessionsSql = "SELECT ID, Product FROM Concession";
$concessionsResult = $conn->query($concessionsSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Concession Revenue</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #008000;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin: 10px 0;
            color: #008000;
        }

        select, input {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }

        button {
            background-color: #008000;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #008000;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #008000;
            color: white;
        }

        h3 {
            color: #008000;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daily Concession Revenue</h2>

        <!-- Concession revenue form -->
        <form method="post" action="">
            <label for="concessionID">Select Concession:</label>
            <select name="concessionID" required>
                <?php while ($concession = $concessionsResult->fetch_assoc()) : ?>
                    <option value="<?php echo $concession['ID']; ?>">
                        <?php echo $concession['Product']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br>

            <label for="revenue">Revenue:</label>
            <input type="number" name="revenue" min="0" step="0.01" required><br>

            <button type="submit" name="recordSale">Record Daily Revenue</button>
        </form>

        <!-- Display daily concession revenue -->
        <h3>Daily Concession Revenue Information</h3>
        <table border="1">
            <tr>
                <th>Record ID</th>
                <th>Concession Name</th>
                <th>Revenue</th>
                <th>Sale Date</th>
            </tr>
            <?php
            $dailyRevenueSql = "SELECT RecordID, Product, Revenue, SaleDate FROM DailyConcessionRevenue
                                JOIN Concession ON DailyConcessionRevenue.ConcessionID = Concession.ID";
            $dailyRevenueResult = $conn->query($dailyRevenueSql);
            while ($record = $dailyRevenueResult->fetch_assoc()) :
            ?>
                <tr>
                    <td><?php echo $record['RecordID']; ?></td>
                    <td><?php echo $record['Product']; ?></td>
                    <td><?php echo $record['Revenue']; ?></td>
                    <td><?php echo $record['SaleDate']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href = "../dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
