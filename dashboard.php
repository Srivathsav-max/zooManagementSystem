<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is an admin, otherwise deny access
if ($_SESSION['role'] !== 'Admin') {
    echo "Access denied. Only admins can access this page.";
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        li {
            flex: 1 1 300px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
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

        .section-title {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Logout form -->
    <form method="post" action="">
        <button type="submit" name="logout">Logout</button>
    </form>

    <!-- View Users link -->
    <p><a href="view_users.php">View All Users</a></p>

    <!-- Assets Management -->
    <div class="section-title">Assets Management</div>
    <ul>
    <li><a href="animal/animal.php">Animal Management</a></li>
        <li><a href="buildings/building.php">Building Management</a></li>
        <li><a href="enclosures/enclosure.php">Enclosure</a></li>
        <li><a href="species/species.php">Species</a></li>
        <li><a href="revenuesTypes/revenue_types.php">RevenueTypes</a></li>
        <li><a href="revenuesEvents/view_revenue_events.php">RevenueEvents</a></li>
        <li><a href="animalShows/view_animal_shows.php">Animal Shows</a></li>
        <li><a href="concession/view_concessions.php">concession</a></li>
        <li><a href="zooAdmission/view_zoo_admissions.php">zooAdmission</a></li>
        <li><a href="caresFor/view_cares_for.php">caresFor</a></li>
        <li><a href="participatesIN/view_participates_in.php">participatesIN</a></li>
        <li><a href="employees/view_employees.php">view_employees</a></li>
        <li><a href="hourlyRate/view_hourly_rates.php">view_hourly_rates</a></li>
    </ul>

    <!-- Zoo Activity -->
    <div class="section-title">Zoo Activity</div>
    <ul>
    <li><a href="attendance/test_attendance.php">view_Zoo_attendance</a></li>
        <li><a href="attractions/test_attraction.php">view_attractions</a></li>
        <li><a href="concession/sales_concession.php">view_concession_sales</a></li>
    </ul>

    <!-- Report Management -->
    <div class="section-title">Report Management</div>
    <ul>
    <li><a href="reportForm/report_form.php">report_form</a></li>
        <li><a href="animalPopulationReport/animal_population_report_form.php">animal_report_form</a></li>
        <li><a href="topAttractions/top_attractions_report_form.php">top_attractions_report_form</a></li>
        <li><a href="averageRevenue/average_revenue_report_form.php">average_revenue_report_form</a></li>
        <li><a href="bestDays/best_days_report_form.php">best_days_report_form</a></li>
    </ul>
</body>
</html>
