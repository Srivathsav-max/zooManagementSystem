<?php
include '../includes/db_connection.php';

// Fetch available employees for dropdown
$employeeSql = "SELECT EmployeeID, CONCAT(FirstName, ' ', LastName) AS FullName FROM Employee";
$employeeResult = $conn->query($employeeSql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateEmployee"])) {
    // Perform additional validation and handle the update of an existing employee
    // Ensure that the user has admin privileges before updating an employee

    $employeeID = $_POST["employeeID"];
    $newStartDate = $_POST["newStartDate"];
    $newJobType = $_POST["newJobType"];
    $newFirstName = $_POST["newFirstName"];
    $newMiddleName = $_POST["newMiddleName"];
    $newLastName = $_POST["newLastName"];
    $newStreet = $_POST["newStreet"];
    $newCity = $_POST["newCity"];
    $newState = $_POST["newState"];
    $newZip = $_POST["newZip"];
    $newSuperID = $_POST["newSuperID"];
    $newHourlyRateID = $_POST["newHourlyRateID"];
    $newConcessionID = $_POST["newConcessionID"];
    $newZooAdmissionID = $_POST["newZooAdmissionID"];

    // Check if the user is an admin before updating an employee
    if ($_SESSION['role'] === 'Admin') {
        // Perform the necessary database operations to update the employee
        $updateSql = "UPDATE Employee SET StartDate = ?, JobType = ?, FirstName = ?, MiddleName = ?, 
                      LastName = ?, Street = ?, City = ?, State = ?, Zip = ?, SuperID = ?, 
                      HourlyRateID = ?, ConcessionID = ?, ZooAdmissionID = ? WHERE EmployeeID = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ssssssssiiiiii", $newStartDate, $newJobType, $newFirstName, $newMiddleName, $newLastName, $newStreet, $newCity, $newState, $newZip, $newSuperID, $newHourlyRateID, $newConcessionID, $newZooAdmissionID, $employeeID);
        $stmt->execute();
        $stmt->close();
        echo "Employee updated successfully.";
    } else {
        echo "Access denied. Only admins can update employees.";
    }
}
?>
<!-- HTML form for updating an employee
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee</title>
</head>
<body>
    <h2>Update Employee</h2>

    <!-- Employee update form -->
    <form method="post" action="">
        <!-- Fetch available employees for dropdown -->
        <label for="employeeID">Select Employee:</label>
        <select name="employeeID" required>
            <?php while ($employee = $employeeResult->fetch_assoc()) : ?>
                <option value="<?php echo $employee['EmployeeID']; ?>"><?php echo $employee['FullName']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <!-- Add input fields for updated employee details -->
        <label for="newStartDate">New Start Date:</label>
        <input type="text" name="newStartDate" required><br>

        <label for="newJobType">New Job Type:</label>
        <input type="text" name="newJobType" required><br>

        <label for="newFirstName">New First Name:</label>
        <input type="text" name="newFirstName" required><br>

        <label for="newMiddleName">New Middle Name:</label>
        <input type="text" name="newMiddleName"><br>

        <label for="newLastName">New Last Name:</label>
        <input type="text" name="newLastName" required><br>

        <!-- Add more input fields for updated address, superID, hourlyRateID, concessionID, zooAdmissionID -->

        <button type="submit" name="updateEmployee">Update Employee</button>
    </form>

    <a href="view_employees.php">Back to Employees</a>
</body>
</html>
