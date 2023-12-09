<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Handle form submission for creating a new attendance entry
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createAttendance"])) {
    $date = $_POST["date"];
    $attendance = $_POST["attendance"];
    $revenue = $_POST["revenue"];

    // Insert the new attendance details into the database
    $sql = "INSERT INTO AttendanceDaily (Date, Attendance, Revenue)
            VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $date, $attendance, $revenue);
    $stmt->execute();
    $stmt->close();

    echo "Attendance entry created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Attendance</title>
</head>
<body>
    <h2>Create Attendance</h2>

    <!-- Attendance creation form -->
    <form method="post" action="">
        <label for="date">Date:</label>
        <input type="date" name="date" required><br>

        <label for="attendance">Attendance:</label>
        <input type="number" name="attendance" required><br>

        <label for="revenue">Revenue:</label>
        <input type="number" name="revenue" required><br>

        <button type="submit" name="createAttendance">Create Attendance</button>
    </form>

    <a href="view_attendance.php">Back to Attendance</a>
</body>
</html>
