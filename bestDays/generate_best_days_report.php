<?php
// Include the common database connection file
include '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generateBestDaysReport"])) {
    $selectedMonth = $_POST["selectedMonth"];

    // Assuming tables RevenueEvents
    $query = "SELECT 
                DATE(DateTime) AS Day,
                SUM(Revenue) AS TotalRevenue
              FROM RevenueEvents
              WHERE MONTH(DateTime) = ?
              GROUP BY Day
              ORDER BY TotalRevenue DESC
              LIMIT 5";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $selectedMonth);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the report
    echo "<h2>Best 5 Days Report for $selectedMonth</h2>";

    // Check if there are rows in the result set
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Day</th><th>Total Revenue</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['Day']}</td>";
            echo "<td>{$row['TotalRevenue']}</td>";
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
