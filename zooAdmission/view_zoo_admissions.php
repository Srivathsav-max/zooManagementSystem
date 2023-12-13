<?php
// Include the common database connection file
include '../includes/db_connection.php';
session_start();
// Fetch zoo admissions from the database
$sql = "SELECT ZooAdmission.ID, RevenueType.Name AS RevenueTypeName, SeniorPrice, AdultPrice, ChildPrice 
        FROM ZooAdmission
        JOIN RevenueType ON ZooAdmission.ID = RevenueType.ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoo Admissions Management</title>
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
    <h2>Zoo Admissions Management</h2>

    <a href="create_zoo_admission.php">Create New Zoo Admission</a>

    <!-- Display a paginated list of zoo admissions with links to view, update, and delete -->
    <table border="1">
        <tr>
            <th>Zoo Admission ID</th>
            <th>Revenue Type</th>
            <th>Senior Price</th>
            <th>Adult Price</th>
            <th>Child Price</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['RevenueTypeName']; ?></td>
                <td><?php echo $row['SeniorPrice']; ?></td>
                <td><?php echo $row['AdultPrice']; ?></td>
                <td><?php echo $row['ChildPrice']; ?></td>
                <td>
                    <!-- <a href="view_zoo_admission.php?id=<?php echo $row['ID']; ?>">View</a>  -->
                    <a href="update_zoo_admission.php?id=<?php echo $row['ID']; ?>">Update</a> 
                    <?php if ($_SESSION['role'] === 'Admin') : ?>
                        <a href="delete_zoo_admission.php?id=<?php echo $row['ID']; ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href = "../dashboard.php">Back to Dashboard</a>
</body>
</html>
