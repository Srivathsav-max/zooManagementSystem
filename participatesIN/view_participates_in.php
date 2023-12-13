<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch Participates In relationships from the database
$sql = "SELECT DISTINCT P.ID, P.Reqd, S.ID AS SpeciesID, P.AnimalShowID 
        FROM ParticipatesIN P
        JOIN Species S ON P.SpeciesID = S.ID
        JOIN AnimalShow A ON P.AnimalShowID = A.ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participates In Relationships</title>
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
    <h2>Participates In Relationships</h2>

    <a href="create_participates_in.php">Create New Relationship</a>

    <!-- Display a paginated list of Participates In relationships with links to update and delete -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Species ID</th>
            <th>Animal Show ID</th>
            <th>Required</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['SpeciesID']; ?></td>
                <td><?php echo $row['AnimalShowID']; ?></td>
                <td><?php echo $row['Reqd']; ?></td>
                <td>
                    <a href="update_participates_in.php?id=<?php echo $row['ID']; ?>">Update</a> 
                    <a href="delete_participates_in.php?id=<?php echo $row['ID']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href = "../dashboard.php">Back to Dashboard</a>
</body>
</html>
