<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Fetch available employees for the supervisor dropdown
$employeesSql = "SELECT EmployeeID, CONCAT(FirstName, ' ', LastName) AS FullName FROM Employee";
$employeesResult = $conn->query($employeesSql);

// Fetch available hourly rates for dropdown
$hourlyRatesSql = "SELECT ID, HourlyRate FROM HourlyRate";
$hourlyRatesResult = $conn->query($hourlyRatesSql);

// Fetch available concessions for dropdown
$concessionsSql = "SELECT ID, Product FROM Concession";
$concessionsResult = $conn->query($concessionsSql);

// Fetch available zoo admissions for dropdown
$zooAdmissionsSql = "SELECT ID, Type FROM ZooAdmission";
$zooAdmissionsResult = $conn->query($zooAdmissionsSql);

// Handle form submission for creating a new employee
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createEmployee"])) {
    // ... (similar to the previous code) ...
}

// Handle form submission for deleting an employee
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteEmployee"])) {
    $employeeIDToDelete = $_POST["employeeIDToDelete"];

    // Delete the employee from the database
    $deleteSql = "DELETE FROM Employee WHERE EmployeeID = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $employeeIDToDelete);
    $stmt->execute();
    $stmt->close();

    echo "Employee deleted successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Employee</title>
</head>
<body>
    <h2>Create Employee</h2>

    <!-- Employee creation form -->
    <form method="post" action="">
        <!-- Add form fields for employee details -->
        <!-- ... (similar to the previous code) ... -->

        <button type="submit" name="createEmployee">Create Employee</button>
    </form>

    <!-- Employee deletion form -->
    <h2>Delete Employee</h2>
    <form method="post" action="">
        <label for="employeeIDToDelete">Select Employee to Delete:</label>
        <select name="employeeIDToDelete" required>
            <?php while ($employee = $employeesResult->fetch_assoc()) : ?>
                <option value="<?php echo $employee['EmployeeID']; ?>"><?php echo $employee['FullName']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <button type="submit" name="deleteEmployee">Delete Employee</button>
    </form>

    <a href="view_employees.php">Back to Employees</a>
</body>
</html>
