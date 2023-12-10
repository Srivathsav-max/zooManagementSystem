<?php
// Check if the form is submitted
if (isset($_POST['generateTopDaysReport'])) {
    // Get the selected month from the form
    $selectedMonth = $_POST['selectedMonth'];

    // Replace with your database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "zoo";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Execute the query to set the target month
    $sql1 = "SET @target_month = '$selectedMonth';";
    $conn->query($sql1);

    // Execute the query to find the 5 best days in terms of total revenue
    $sql2 = "
        SELECT
            DATE(TransactionDate) AS TransactionDate,
            SUM(Revenue) AS TotalRevenue
        FROM (
            SELECT
                DATE(CheckoutTime) AS TransactionDate,
                Revenue
            FROM ZooAdmissionTickets
            WHERE DATE_FORMAT(CheckoutTime, '%Y-%m') = @target_month
            UNION ALL
            SELECT
                DATE(CheckoutTime) AS TransactionDate,
                Revenue
            FROM AnimalShowTickets
            WHERE DATE_FORMAT(CheckoutTime, '%Y-%m') = @target_month
            UNION ALL
            SELECT
                SaleDate AS TransactionDate,
                Revenue
            FROM DailyConcessionRevenue
            WHERE DATE_FORMAT(SaleDate, '%Y-%m') = @target_month
        ) AS CombinedRevenue
        GROUP BY TransactionDate
        ORDER BY TotalRevenue DESC
        LIMIT 5;
    ";

    $result = $conn->query($sql2);

    if ($result->num_rows > 0) {
        echo "<h2>Top Days Revenue Report for $selectedMonth</h2>";
        echo "<table border='1'><tr><th>Date</th><th>Total Revenue</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["TransactionDate"] . "</td><td>" . $row["TotalRevenue"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No results found.";
    }

    $conn->close();
}
?>
