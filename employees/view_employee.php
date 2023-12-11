<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Check if the employee ID is provided in the URL
if (isset($_GET['id'])) {
    $employeeId = $_GET['id'];

    // Fetch employee details
    $fetchSql = "SELECT * FROM Employee WHERE EmployeeID = ?";
    $fetchStmt = $conn->prepare($fetchSql);
    $fetchStmt->bind_param("i", $employeeId);
    $fetchStmt->execute();
    $employeeResult = $fetchStmt->get_result();

    if ($employeeResult->num_rows == 1) {
        $employee = $employeeResult->fetch_assoc();
    } else {
        echo "Employee not found.";
        exit();
    }
} else {
    echo "Employee ID not provided.";
    exit();
}

// Close the prepared statement
$fetchStmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(144, 238, 144, 0.3); /* Light green with reduced opacity */
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

    </style>
    <!-- Add your styles if needed -->
</head>
<body>
    <h2>Employee Details</h2>

    <p><strong>Employee ID:</strong> <?php echo $employee['EmployeeID']; ?></p>
    <p><strong>Start Date:</strong> <?php echo $employee['StartDate']; ?></p>
    <p><strong>Job Type:</strong> <?php echo $employee['JobType']; ?></p>
    <p><strong>Full Name:</strong> <?php echo $employee['FirstName'] . ' ' . $employee['LastName']; ?></p>
    <p><strong>Middle Name:</strong> <?php echo $employee['MiddleName']; ?></p>
    <p><strong>Last Name:</strong> <?php echo $employee['LastName']; ?></p>
    <p><strong>Street:</strong> <?php echo $employee['Street']; ?></p>
    <p><strong>City:</strong> <?php echo $employee['City']; ?></p>
    <p><strong>State:</strong> <?php echo $employee['State']; ?></p>
    <p><strong>Zip:</strong> <?php echo $employee['Zip']; ?></p>
    <p><strong>Supervisor ID:</strong> <?php echo $employee['SuperID']; ?></p>
    <p><strong>Hourly Rate ID:</strong> <?php echo $employee['HourlyRateID']; ?></p>
    <p><strong>Concession ID:</strong> <?php echo $employee['ConcessionID']; ?></p>
    <p><strong>Zoo Admission ID:</strong> <?php echo $employee['ZooAdmissionID']; ?></p>
    <!-- Add more details as needed -->
</body>
</html>
