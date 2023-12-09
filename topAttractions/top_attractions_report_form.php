<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Attractions Report</title>
</head>
<body>
    <h2>Select Time Period for Top Attractions Report</h2>

    <!-- Form to select the time period -->
    <form method="post" action="generate_top_attractions_report.php">
        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" required>
        <label for="endDate">End Date:</label>
        <input type="date" name="endDate" required>
        <button type="submit" name="generateTopAttractionsReport">Generate Report</button>
    </form>
</body>
</html>
