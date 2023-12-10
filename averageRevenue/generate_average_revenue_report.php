<?php
// Include the common database connection file
include '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generateAverageRevenueReport"])) {
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];

    // Assuming tables AnimalShowTickets, ZooAdmissionTickets, and DailyConcessionRevenue
    $query = "SELECT
                'Animal Show' AS Category,
                AVG(Revenue) AS AverageRevenue
              FROM AnimalShowTickets
              WHERE CheckoutTime BETWEEN ? AND ?
              UNION
              SELECT
                'Zoo Admission' AS Category,
                AVG(Revenue) AS AverageRevenue
              FROM ZooAdmissionTickets
              WHERE CheckoutTime BETWEEN ? AND ?
              UNION
              SELECT
                'Concession' AS Category,
                AVG(Revenue) AS AverageRevenue
              FROM DailyConcessionRevenue
              WHERE SaleDate BETWEEN ? AND ?
              UNION
              SELECT
                'Total Attendance' AS Category,
                AVG(Attendance) AS AverageRevenue
              FROM (
                SELECT Attendance
                FROM AnimalShowTickets
                WHERE CheckoutTime BETWEEN ? AND ?
                UNION
                SELECT Attendance
                FROM ZooAdmissionTickets
                WHERE CheckoutTime BETWEEN ? AND ?
              ) AS CombinedAttendance";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssss", $startDate, $endDate, $startDate, $endDate, $startDate, $endDate, $startDate, $endDate, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the report
    echo "<h2>Average Revenue Report for $startDate to $endDate</h2>";

    // Check if there are rows in the result set
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Category</th><th>Average Revenue</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['Category']}</td>";
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
