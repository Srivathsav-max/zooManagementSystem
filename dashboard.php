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
    <h1>Admin Dashboard</h1>

    <!-- Logout form -->
    <form method="post" action="">
        <button type="submit" name="logout">Logout</button>
    </form>

    <!-- View Users link -->
    <p><a href="view_users.php">View All Users</a></p>

    <!-- Assets Management -->
    <div class="section">
        <div class="section-title">Assets Management</div>
        <ul>
            <li><a href="animal/view_animals.php">Animal Management</a></li>
            <li><a href="buildings/view_buildings.php">Building Management</a></li>
            <li><a href="animalShows/view_animal_shows.php">Animal Shows or Attractions</a></li>
            <li><a href="employees/view_employees.php">Employee Management</a></li>
            <li><a href="hourlyRate/view_hourly_rates.php">Hourly Wages</a></li>
            <li><a href="enclosures/view_enclosures.php">Enclosure</a></li>
            <li><a href="species/view_species.php">Species</a></li>
            <li><a href="revenuesTypes/revenue_types.php">RevenueTypes</a></li>
            <li><a href="revenuesEvents/view_revenue_events.php">RevenueEvents</a></li>
            <li><a href="concession/view_concessions.php">concession</a></li>
            <li><a href="zooAdmission/view_zoo_admissions.php">zooAdmission</a></li>
            <li><a href="caresFor/view_cares_for.php">caresFor</a></li>
            <li><a href="participatesIN/view_participates_in.php">participatesIN</a></li>
        </ul>
    </div>

    <!-- Zoo Activity -->
    <div class="section">
        <div class="section-title">Zoo Activity</div>
        <ul>
            <li><a href="attendance/test_attendance.php">Zoo Admission Attendance</a></li>
            <li><a href="attractions/test_attraction.php">Animal Shows or Attractions Attendance</a></li>
            <li><a href="concession/sales_concession.php">Concession Sales</a></li>
        </ul>
    </div>

    <!-- Report Management -->
    <div class="section">
        <div class="section-title">Report Management</div>
        <ul>
            <li><a href="reportForm/report_form.php">Revenue Report</a></li>
            <li><a href="animalPopulationReport/animal_population_report_form.php">Animal Population Report</a></li>
            <li><a href="topAttractions/top_attractions_report_form.php">Top Attractions Report</a></li>
            <li><a href="bestDays/best_days_report_form.php">Top 5 Days Revenue Report</a></li>
            <li><a href="averageRevenue/average_revenue_report_form.php">Average Revenue Report</a></li>
        </ul>
    </div>
</body>
</html>
