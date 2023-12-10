<?php
// Include the common database connection file
include '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generateBestDaysReport"])) {
    $selectedMonth = $_POST["selectedMonth"];

    // Assuming tables AnimalShowTickets, ZooAdmissionTickets, and DailyConcessionRevenue
    $query = "SELECT DATE(CheckoutTime) AS SaleDate, SUM(Revenue) AS CombinedRevenue
              FROM (
                SELECT CheckoutTime, Revenue
                FROM AnimalShowTickets
                WHERE YEAR(CheckoutTime) = YEAR(?) AND MONTH(CheckoutTime) = MONTH(?)
                UNION ALL
                SELECT CheckoutTime, Revenue
                FROM ZooAdmissionTickets
                WHERE YEAR(CheckoutTime) = YEAR(?) AND MONTH(CheckoutTime) = MONTH(?)
                UNION ALL
                SELECT SaleDate, Revenue
                FROM DailyConcessionRevenue
                WHERE YEAR(SaleDate) = YEAR(?) AND MONTH(SaleDate) = MONTH(?)
              ) AS CombinedSales
              GROUP BY SaleDate
              ORDER BY CombinedRevenue DESC
              LIMIT 5";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $selectedMonth, $selectedMonth, $selectedMonth, $selectedMonth, $selectedMonth, $selectedMonth);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the report
    echo "<h2>Top 5 Revenue Days for $selectedMonth</h2>";

    // Check if there are rows in the result set
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Sale Date</th><th>Total Revenue</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['SaleDate']}</td>";
            echo "<td>{$row['CombinedRevenue']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No data available for the selected month.</p>";
    }

    echo "<a href='best_days_report_form.php'>Back to Report Form</a>";

    $stmt->close();
    $conn->close();
}
?>
