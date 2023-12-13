<?php
// Include the common database connection file
include '../includes/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combined Revenue and Tickets Report</title>
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
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generateReport"])) {
            $selectedDate = $_POST["selectedDate"];

            // Combined Zoo Admission, Animal Show, and Daily Concession
            $queryCombined = "
            SELECT 
                SUM(TotalAttendance) AS OverallAttendance,
                SUM(TotalRevenue) AS OverallRevenue
            FROM (
                SELECT 
                    SUM(Attendance) AS TotalAttendance,
                    SUM(Revenue) AS TotalRevenue
                FROM 
                    zooadmissiontickets
                WHERE 
                    DATE(CheckoutTime) = ?
                UNION
                SELECT 
                    SUM(Attendance) AS TotalAttendance,
                    SUM(Revenue) AS TotalRevenue
                FROM 
                    animalshowtickets
                WHERE 
                    DATE(CheckoutTime) = ?
                UNION
                SELECT 
                    0 AS TotalAttendance, -- Daily Concession doesn't have attendance
                    SUM(Revenue) AS TotalRevenue
                FROM 
                    dailyconcessionrevenue
                WHERE 
                    DATE(SaleDate) = ?
            ) AS CombinedResults";
            $stmtCombined = $conn->prepare($queryCombined);
            $stmtCombined->bind_param("sss", $selectedDate, $selectedDate, $selectedDate);
            $stmtCombined->execute();
            $resultCombined = $stmtCombined->get_result();
            $rowCombined = $resultCombined->fetch_assoc();

            // Display the report
            echo "<h2>Combined Revenue and Tickets Report for $selectedDate</h2>";
            echo "<table>";
            echo "<tr><th>Category</th><th>Total Attendance</th><th>Total Revenue</th></tr>";
            echo "<tr><td>Combined Revenue and Tickets</td><td>{$rowCombined['OverallAttendance']}</td><td>{$rowCombined['OverallRevenue']}</td></tr>";
            echo "</table>";
            echo "<a href='report_form.php'>Back to Report Form</a>";

            $stmtCombined->close();
        } else {
            echo "<p>No report generated. Please go back to the <a href='report_form.php'>Report Form</a>.</p>";
        }

        $conn->close();
        ?>
    </div>
    
</body>
</html>
