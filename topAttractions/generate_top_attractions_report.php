<?php
// Include the common database connection file
include '../includes/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Attractions Report</title>
    <style>
         body {
                        background-color: rgba(0, 128, 0, 0.2); /* Transparent green background */
                        padding: 20px;
                    }
                    h2 {
                        color: #008000; /* Green text */
                    }
                    table {
                        border: 1px solid #008000; /* Green border */
                        background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
                        width: 100%;
                        margin-top: 20px;
                        margin-bottom: 20px;
                    }
                    table th, table td {
                        padding: 10px;
                        text-align: left;
                        border: 1px solid #008000; /* Green border */
                    }
                    p {
                        color: #008000; /* Green text */
                    }
                    a {
                        color: #008000; /* Green text */
                        text-decoration: none;
                        font-weight: bold;
                        margin-right: 20px;
                    }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generateTopAttractionsReport"])) {
            $startDate = $_POST["startDate"];
            $endDate = $_POST["endDate"];

            // Assuming the table is AnimalShowTickets
            $query = "SELECT 
                        AnimalShowID, 
                        SUM(Revenue) AS TotalRevenue
                      FROM AnimalShowTickets
                      WHERE CheckoutTime BETWEEN ? AND ?
                      GROUP BY AnimalShowID
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
                echo "<table>";
                echo "<tr><th>Attraction ID</th><th>Total Revenue</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['AnimalShowID']}</td>";
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
        } else {
            echo "<p>No report generated. Please go back to the <a href='top_attractions_report_form.php'>Report Form</a>.</p>";
        }
        ?>
    </div>
</body>
</html>
