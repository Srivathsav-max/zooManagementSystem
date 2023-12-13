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

// Automatically update revenue events only if there are changes
$dateTime = getCurrentDate();
$updateRequired = false;

foreach ($animalShowData as $revenueTypeId => $animalShow) {
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
    if ($animalShow['TotalRevenue'] != $existingRevenue || $animalShow['TotalAttendance'] != $existingTicketsSold) {
        $updateRequired = true;
        break;
    }
}

// Update revenue events only if changes are detected
if ($updateRequired) {
    foreach ($animalShowData as $revenueTypeId => $animalShow) {
        // Add your update logic here if needed

        // Update existing entry for the current date and RevenueTypeID
        $updateSql = "INSERT INTO RevenueEvents (DateTime, Revenue, TicketsSold, ID)
                      VALUES (?, ?, ?, ?)
                      ON DUPLICATE KEY UPDATE Revenue = VALUES(Revenue),
                                              TicketsSold = VALUES(TicketsSold)";

        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sdii", $dateTime, $animalShow['TotalRevenue'], $animalShow['TotalAttendance'], $revenueTypeId);
        $updateStmt->execute();
        $updateStmt->close();
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        a {
            display: block;
            width: 200px;
            margin: 10px auto; /* Reduced margin */
            padding: 10px 20px;
            background-color: rgba(144, 238, 144, 0.3); /* Light transparent green */
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: rgba(144, 238, 144, 0.3); /* Light transparent green */
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }


    </style>
</head>

<body>
    <h2>Total Attendance and Revenue</h2>

    <?php foreach ($animalShowData as $revenueTypeId => $animalShow) : ?>
        <h3>Revenue Type ID: <?php echo $revenueTypeId; ?></h3>
        <p>Animal Shows - Total Attendance: <?php echo $animalShow['TotalAttendance']; ?></p>
        <p>Animal Shows - Total Revenue: <?php echo $animalShow['TotalRevenue']; ?></p>
    <?php endforeach; ?>

    <?php if ($updateRequired) : ?>
        <form method="post" action="">
            <button type="submit" name="updateRevenueEvents">Update Revenue Events</button>
        </form>
    <?php endif; ?>

    <!-- Display a paginated list of revenue events with links to view, update, and delete -->
    <a href = "test_revenue_event.php">Update Zoo Admission</a>
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
                    <!-- <a href="view_revenue_event.php?id=<?php echo isset($row['ID']) ? $row['ID'] : ''; ?>">View</a>  -->
                    <a href="update_revenue_event.php?id=<?php echo isset($row['ID']) ? $row['ID'] : ''; ?>">Update</a> 
                    <a href="delete_revenue_event.php?id=<?php echo isset($row['ID']) ? $row['ID'] : ''; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
        <a href = "../dashboard.php" >Back to Dashboard</a>
</body>

</html>
