<?php
// Include the common database connection file
include '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generateTopAttractionsReport"])) {
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];

    // Assuming tables RevenueEvents and Building
    $query = "SELECT 
                BuildingID, 
                SUM(Revenue) AS TotalRevenue
              FROM RevenueEvents
              WHERE DateTime BETWEEN ? AND ?
              GROUP BY BuildingID
              ORDER BY TotalRevenue DESC
              LIMIT 3";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the report
    echo "<h2>Top 3 Attractions for the period $startDate to $endDate</h2>";

    // Check if there are rows in the result set
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Attraction ID</th><th>Total Revenue</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['BuildingID']}</td>";
            echo "<td>{$row['TotalRevenue']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No data available for the selected time period.</p>";
    }

    echo "<a href='top_attractions_report_form.php'>Back to Report Form</a>";

    $stmt->close();
    $conn->close();
}
?>
