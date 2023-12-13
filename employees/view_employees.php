<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch employees from the database
$sql = "SELECT * FROM Employee";
$result = $conn->query($sql);

// Display a list of employees with links to view, update, and delete
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
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
    <h2>Employee Management</h2>

    <a href="create_employee.php">Create New Employee</a>

    <!-- Display a paginated list of employees with links to view, update, and delete -->
    <table>
        <tr>
            <!-- Add more columns as needed -->
            <th>Employee ID</th>
            <th>Start Date</th>
            <th>Job Type</th>
            <th>Full Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Street</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Supervisor ID</th>
            <th>Hourly Rate ID</th>
            <th>Concession ID</th>
            <th>Zoo Admission ID</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['EmployeeID']; ?></td>
                <td><?php echo $row['StartDate']; ?></td>
                <td><?php echo $row['JobType']; ?></td>
                <td><?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></td>
                <td><?php echo $row['MiddleName']; ?></td>
                <td><?php echo $row['LastName']; ?></td>
                <td><?php echo $row['Street']; ?></td>
                <td><?php echo $row['City']; ?></td>
                <td><?php echo $row['State']; ?></td>
                <td><?php echo $row['Zip']; ?></td>
                <td><?php echo $row['SuperID']; ?></td>
                <td><?php echo $row['HourlyRateID']; ?></td>
                <td><?php echo $row['ConcessionID']; ?></td>
                <td><?php echo $row['ZooAdmissionID']; ?></td>
                <!-- Display more columns as needed -->
                <td>
                    <a href="view_employee.php?id=<?php echo $row['EmployeeID']; ?>">View</a>
                    <a href="update_employee.php?id=<?php echo $row['EmployeeID']; ?>">Update</a>
                    <a href="delete_employee.php?id=<?php echo $row['EmployeeID']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="../dashboard.php">Back to Dashboard</a>
</body>
</html>


