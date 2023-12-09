<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Revenue Report</title>
</head>
<body>
    <h2>Generate Revenue Report</h2>

    <form method="post" action="generate_report.php">
        <label for="selectedDate">Select Date:</label>
        <input type="date" name="selectedDate" required>
        <button type="submit" name="generateReport">Generate Report</button>
    </form>
</body>
</html>
