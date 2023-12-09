<?php
// Include the common database connection file
include '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generateReport"])) {
    $selectedDate = $_POST["selectedDate"];

    // Assuming a RevenueEvents table with columns ID, DateTime, Revenue, TicketsSold
    // You may need to join with other tables to get source details

    $query = "SELECT DateTime, Revenue, TicketsSold
              FROM RevenueEvents
              WHERE DateTime = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $selectedDate);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the report
    echo "<h2>Revenue Report for $selectedDate</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Date</th><th>Revenue</th><th>Tickets Sold</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['DateTime']}</td>";
        echo "<td>{$row['Revenue']}</td>";
        echo "<td>{$row['TicketsSold']}</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<a href='report_form.php'>Back to Report Form</a>";

    $stmt->close();
    $conn->close();
}
?>
