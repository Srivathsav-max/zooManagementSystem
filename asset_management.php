<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include the common database connection file
include 'db_connection.php';

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Check user role
$userRole = $_SESSION['role']; // Assuming 'role' is a session variable that stores the user's role

// Define roles that have access to the asset management page
$allowedRoles = ['Manager', 'Admin'];

// Check if the user has the required role
if (!in_array($userRole, $allowedRoles)) {
    echo "Access denied. You do not have the required role.";
    exit();
}

// Get the logged-in username
$loggedInUsername = $_SESSION['username'];

// Get the server's system time
$currentTime = date("Y-m-d H:i:s");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Management System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #333;
            color: #fff;
            padding: 15px;
            margin: 0;
            text-align: center;
        }

        form {
            text-align: center;
            margin: 15px 0;
        }

        button {
            background-color: #333;
            color: #fff;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #555;
        }

        p {
            text-align: center;
            margin: 15px 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .section {
            margin-top: 20px;
            text-align: center;
        }

        .section-title {
            font-size: 18px;
            margin-bottom: 10px;
        }

        li {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 10px auto;
            max-width: 300px;
        }

        li:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Asset Management System</h1>

    <!-- Display logged-in username and current time -->
    <p>Welcome, <?php echo $loggedInUsername; ?>! Current Time (Server): <?php echo $currentTime; ?>! Role: <?php echo $userRole; ?></p>

    <!-- Logout form -->
    <form method="post" action="">
        <button type="submit" name="logout">Logout</button>
    </form>

    <ul>
            <li><a href="animal/view_animals.php">Animal Management</a></li>
            <li><a href="buildings/view_buildings.php">Building Management</a></li>
            <li><a href="enclosures/view_enclosures.php">Enclosure</a></li>
            <li><a href="species/view_species.php">Species</a></li>
            <li><a href="revenuesTypes/revenue_types.php">RevenueTypes</a></li>
            <li><a href="revenuesEvents/view_revenue_events.php">RevenueEvents</a></li>
            <li><a href="animalShows/view_animal_shows.php">Animal Shows</a></li>
            <li><a href="concession/view_concessions.php">concession</a></li>
            <li><a href="zooAdmission/view_zoo_admissions.php">zooAdmission</a></li>
            <li><a href="caresFor/view_cares_for.php">caresFor</a></li>
            <li><a href="participatesIN/view_participates_in.php">participatesIN</a></li>
    </ul>
</body>
</html>
