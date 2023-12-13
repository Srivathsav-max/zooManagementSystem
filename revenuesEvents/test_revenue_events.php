<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Function to get the current date in the required format
function getCurrentDate()
{
    return date('Y-m-d');
}

// Fetch revenue events for Animal Shows
$animalShowSql = "SELECT rt.ID, SUM(ast.Attendance) AS TotalAttendance, SUM(ast.Revenue) AS TotalRevenue
                  FROM AnimalShowTickets ast
                  JOIN RevenueType rt ON ast.AnimalShowID = rt.ID
                  GROUP BY rt.ID";

$animalShowResult = $conn->query($animalShowSql);
$animalShowData = [];
while ($row = $animalShowResult->fetch_assoc()) {
    $animalShowData[$row['ID']] = [
        'TotalAttendance' => $row['TotalAttendance'],
        'TotalRevenue' => $row['TotalRevenue']
    ];
}

// Fetch revenue events for Zoo Admission Tickets
$zooAdmissionSql = "SELECT rt.ID, SUM(zat.AdultTickets + zat.ChildTickets + zat.SeniorTickets) AS TotalAttendance, SUM(zat.Revenue) AS TotalRevenue
                    FROM zooadmissiontickets zat
                    JOIN RevenueType rt ON zat.ZooAdmissionID = rt.ID
                    GROUP BY rt.ID";

$zooAdmissionResult = $conn->query($zooAdmissionSql);
$zooAdmissionData = [];
while ($row = $zooAdmissionResult->fetch_assoc()) {
    $zooAdmissionData[$row['ID']] = [
        'TotalAttendance' => $row['TotalAttendance'],
        'TotalRevenue' => $row['TotalRevenue']
    ];
}

// Combine data from both sources
$combinedData = array_merge($animalShowData, $zooAdmissionData);

// Automatically update revenue events only if there are changes
$dateTime = getCurrentDate();
$updateRequired = false;

foreach ($combinedData as $revenueTypeId => $data) {
    // You can add your update logic here if needed

    // Fetch existing values for the current date and RevenueTypeID
    $fetchExistingSql = "SELECT Revenue, TicketsSold FROM RevenueEvents WHERE DateTime = ? AND ID = ?";
    $fetchExistingStmt = $conn->prepare($fetchExistingSql);
    $fetchExistingStmt->bind_param("si", $dateTime, $revenueTypeId);
    $fetchExistingStmt->execute();
    $fetchExistingStmt->bind_result($existingRevenue, $existingTicketsSold);
    $fetchExistingStmt->fetch();
    $fetchExistingStmt->close();

    // Check if the values are different from the existing ones
    if ($data['TotalRevenue'] != $existingRevenue || $data['TotalAttendance'] != $existingTicketsSold) {
        $updateRequired = true;
        break;
    }
}

// Update revenue events only if changes are detected
if ($updateRequired) {
    foreach ($combinedData as $revenueTypeId => $data) {
        // Add your update logic here if needed

        // Check if the referenced data exists for AnimalShowTickets
        $checkAnimalShowDataSql = "SELECT COUNT(*) FROM AnimalShowTickets WHERE AnimalShowID = ?";
        $checkAnimalShowDataStmt = $conn->prepare($checkAnimalShowDataSql);
        $checkAnimalShowDataStmt->bind_param("i", $revenueTypeId);
        $checkAnimalShowDataStmt->execute();
        $checkAnimalShowDataStmt->bind_result($rowCountAnimalShow);
        $checkAnimalShowDataStmt->fetch();
        $checkAnimalShowDataStmt->close();

        // Check if the referenced data exists for ZooAdmissionTickets
        $checkZooAdmissionDataSql = "SELECT COUNT(*) FROM ZooAdmissionTickets WHERE ZooAdmissionID = ?";
        $checkZooAdmissionDataStmt = $conn->prepare($checkZooAdmissionDataSql);
        $checkZooAdmissionDataStmt->bind_param("i", $revenueTypeId);
        $checkZooAdmissionDataStmt->execute();
        $checkZooAdmissionDataStmt->bind_result($rowCountZooAdmission);
        $checkZooAdmissionDataStmt->fetch();
        $checkZooAdmissionDataStmt->close();

        // Check if referenced data exists in either table
        if ($rowCountAnimalShow > 0 || $rowCountZooAdmission > 0) {
            // Update existing entry for the current date and RevenueTypeID
            $updateSql = "INSERT INTO RevenueEvents (DateTime, Revenue, TicketsSold, ID)
                          VALUES (?, ?, ?, ?)
                          ON DUPLICATE KEY UPDATE Revenue = VALUES(Revenue),
                                                  TicketsSold = VALUES(TicketsSold)";

            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("sdii", $dateTime, $data['TotalRevenue'], $data['TotalAttendance'], $revenueTypeId);
            $updateStmt->execute();
            $updateStmt->close();
        } else {
            // Log an error or handle the case where referenced data doesn't exist
            echo "Referenced data not found for RevenueTypeID: " . $revenueTypeId;
        }
    }
}

// Fetch and display revenue events
$revenueEventsSql = "SELECT rt.ID, DateTime, Revenue, TicketsSold
                    FROM RevenueEvents re
                    JOIN RevenueType rt ON re.ID = rt.ID";
$revenueEventsResult = $conn->query($revenueEventsSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Attendance and Revenue</title>
</head>

<body>
    <h2>Total Attendance and Revenue</h2>

    <?php foreach ($combinedData as $revenueTypeId => $data) : ?>
        <h3>Revenue Type ID: <?php echo $revenueTypeId; ?></h3>
        <p>Total Attendance: <?php echo $data['TotalAttendance']; ?></p>
        <p>Total Revenue: <?php echo $data['TotalRevenue']; ?></p>
    <?php endforeach; ?>

    <?php if ($updateRequired) : ?>
        <form method="post" action="">
            <button type="submit" name="updateRevenueEvents">Update Revenue Events</button>
        </form>
    <?php endif; ?>

    <!-- Display a paginated list of revenue events with links to view, update, and delete -->
    <table border="1">
        <tr>
            <th>Revenue Type ID</th>
            <th>Date and Time</th>
            <th>Revenue</th>
            <th>Tickets Sold</th>
            <!-- Add more columns as needed -->
            <th>Actions</th>
        </tr>

        <?php
        while ($row = $revenueEventsResult->fetch_assoc()) :
        ?>
            <tr>
                <td><?php echo isset($row['ID']) ? $row['ID'] : ''; ?></td>
                <td><?php echo isset($row['DateTime']) ? $row['DateTime'] : ''; ?></td>
                <td><?php echo isset($row['Revenue']) ? $row['Revenue'] : ''; ?></td>
                <td><?php echo isset($row['TicketsSold']) ? $row['TicketsSold'] : ''; ?></td>
                <!-- Display more columns as needed -->
                <td>
                    <a href="view_revenue_event.php?id=<?php echo isset($row['ID']) ? $row['ID'] : ''; ?>">View</a> |
                    <a href="update_revenue_event.php?id=<?php echo isset($row['ID']) ? $row['ID'] : ''; ?>">Update</a> |
                    <a href="delete_revenue_event.php?id=<?php echo isset($row['ID']) ? $row['ID'] : ''; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>

</html>
