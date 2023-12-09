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
$zooAdmissionsSql = "SELECT ID FROM ZooAdmission";
$zooAdmissionsResult = $conn->query($zooAdmissionsSql);

// Handle form submission for creating a new employee
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createEmployee"])) {
    $startDate = $_POST["startDate"];
    $jobType = $_POST["jobType"];
    $firstName = $_POST["firstName"];
    $middleName = $_POST["middleName"];
    $lastName = $_POST["lastName"];
    $street = $_POST["street"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $superID = $_POST["superID"];
    $hourlyRateID = $_POST["hourlyRateID"];
    $concessionID = $_POST["concessionID"];
    $zooAdmissionID = $_POST["zooAdmissionID"];

    // Insert the new employee details into the database
    $sql = "INSERT INTO Employee (StartDate, JobType, FirstName, MiddleName, LastName, Street, City, State, Zip, SuperID, HourlyRateID, ConcessionID, ZooAdmissionID)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssiiiii",
        $startDate,
        $jobType,
        $firstName,
        $middleName,
        $lastName,
        $street,
        $city,
        $state,
        $zip,
        $superID,
        $hourlyRateID,
        $concessionID,
        $zooAdmissionID
    );
    $stmt->execute();
    $stmt->close();

    echo "Employee created successfully.";
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

        <label for="startDate">Start Date:</label>
        <input type="text" name="startDate" required><br>

        <label for="jobType">Job Type:</label>
        <input type="text" name="jobType" required><br>

        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" required><br>

        <label for="middleName">Middle Name:</label>
        <input type="text" name="middleName"><br>

        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" required><br>

        <label for="street">Street:</label>
        <input type="text" name="street" required><br>

        <label for="city">City:</label>
        <input type="text" name="city" required><br>

        <label for="state">State:</label>
        <input type="text" name="state" required><br>

        <label for="zip">Zip:</label>
        <input type="text" name="zip" required><br>

        <label for="superID">Supervisor:</label>
        <select name="superID">
            <option value="">None</option>
            <?php while ($employee = $employeesResult->fetch_assoc()) : ?>
                <option value="<?php echo $employee['EmployeeID']; ?>"><?php echo $employee['FullName']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="hourlyRateID">Hourly Rate:</label>
        <select name="hourlyRateID" required>
            <?php while ($hourlyRate = $hourlyRatesResult->fetch_assoc()) : ?>
                <option value="<?php echo $hourlyRate['ID']; ?>"><?php echo $hourlyRate['HourlyRate']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="concessionID">Concession:</label>
        <select name="concessionID">
            <option value="">None</option>
            <?php while ($concession = $concessionsResult->fetch_assoc()) : ?>
                <option value="<?php echo $concession['ID']; ?>"><?php echo $concession['Product']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="zooAdmissionID">Zoo Admission:</label>
        <select name="zooAdmissionID">
            <option value="">None</option>
            <?php while ($zooAdmission = $zooAdmissionsResult->fetch_assoc()) : ?>
                <option value="<?php echo $zooAdmission['ID']; ?>"></option>
            <?php endwhile; ?>
        </select><br>

        <button type="submit" name="createEmployee">Create Employee</button>
    </form>

    <a href="view_employees.php">Back to Employees</a>
</body>
</html>
