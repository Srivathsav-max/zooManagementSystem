<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Days Revenue Report</title>
</head>
<body>
    <h2>Select Month for Top Days Revenue Report</h2>

    <!-- Form to select the month -->
    <form method="post" action="generate_best_days_report.php">
        <label for="selectedMonth">Select Month:</label>
        <input type="month" name="selectedMonth" required>
        <button type="submit" name="generateTopDaysReport">Generate Report</button>
    </form>

    <p><a href="index.php">Back to Home</a></p>
</body>
</html>
