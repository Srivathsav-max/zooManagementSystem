<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch Cares For relationships from the database
$sql = "SELECT C.*, E.FirstName, E.LastName, S.Name 
        FROM CaresFor C
        JOIN Employee E ON C.EmployeeID = E.EmployeeID
        JOIN Species S ON C.SpeciesID = S.ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cares For Relationships</title>
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
    <h2>Cares For Relationships</h2>

    <a href="create_cares_for.php">Create New Relationship</a>

    <!-- Display a paginated list of Cares For relationships with links to update and delete -->
    <table border="1">
        <tr>
            <th>Employee</th>
            <th>Species</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></td>
                <td><?php echo $row['Name']; ?></td>
                <td>
                    <a href="update_cares_for.php?id=<?php echo $row['EmployeeID']; ?>&speciesId=<?php echo $row['SpeciesID']; ?>">Update</a> 
                    <a href="delete_cares_for.php?id=<?php echo $row['EmployeeID']; ?>&speciesId=<?php echo $row['SpeciesID']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href = "../dashboard.php">Back to Dashboard</a>
</body>
</html>
