<?php
// Include the common database connection file
include '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generateAverageRevenueReport"])) {
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];

    // Assuming tables RevenueEvents
    $query = "SELECT 
                Type,
                AVG(Revenue) AS AverageRevenue
              FROM RevenueEvents
              WHERE DateTime BETWEEN ? AND ?
              GROUP BY Type";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the report
    echo "<h2>Average Revenue Report for $startDate to $endDate</h2>";

    // Check if there are rows in the result set
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Type</th><th>Average Revenue</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['Type']}</td>";
            echo "<td>{$row['AverageRevenue']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No data available for the selected time period.</p>";
    }

    echo "<a href='average_revenue_report_form.php'>Back to Report Form</a>";

    $stmt->close();
    $conn->close();
}
?>
