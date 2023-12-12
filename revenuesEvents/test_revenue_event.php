<?php
include '../includes/db_connection.php';

// Assuming $selectedRevenueTypeId contains the ID of the selected RevenueType
$selectedRevenueTypeId = 1; // Replace with your actual value

// Fetch revenue events based on the selected RevenueTypeID
$sql = "SELECT zooadmissiontickets.Attendance, zooadmissiontickets.Revenue
        FROM zooadmissiontickets
        INNER JOIN RevenueType ON zooadmissiontickets.RevenueTypeID = RevenueType.ID
        WHERE zooadmissiontickets.RevenueTypeID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $selectedRevenueTypeId);
$stmt->execute();
$result = $stmt->get_result();

// Process the result set
while ($row = $result->fetch_assoc()) {
    // Process each row, for example:
    $attendance = $row['Attendance'];
    $revenue = $row['Revenue'];

    // Output or use the data as needed
    echo "Attendance: $attendance, Revenue: $revenue<br>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Report</title>
</head>
<body>
    <h2>Generate Revenue Report</h2>

    <form method="post" action="">
        <label for="revenueType">Select Revenue Type:</label>
        <select name="revenueType">
            <?php while ($revenueType = $revenueTypeResult->fetch_assoc()) : ?>
                <option value="<?php echo $revenueType['ID']; ?>"><?php echo $revenueType['Name']; ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit" name="generateReport">Generate Report</button>
    </form>

    <?php if (isset($totalRevenueZoo) && isset($totalTicketsSoldZoo)) : ?>
        <h3>Zoo Admission Revenue Report for Selected Revenue Type</h3>
        <p>Total Revenue: $<?php echo $totalRevenueZoo; ?></p>
        <p>Total Tickets Sold: <?php echo $totalTicketsSoldZoo; ?></p>
    <?php endif; ?>

    <?php if (isset($totalRevenueAnimalShow) && isset($totalTicketsSoldAnimalShow)) : ?>
        <h3>Animal Show Revenue Report for Selected Revenue Type</h3>
        <p>Total Revenue: $<?php echo $totalRevenueAnimalShow; ?></p>
        <p>Total Tickets Sold: <?php echo $totalTicketsSoldAnimalShow; ?></p>
    <?php endif; ?>
</body>
</html>
