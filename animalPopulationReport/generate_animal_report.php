<?php
// Include the common database connection file
include '../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generateAnimalReport"])) {
    $selectedMonth = $_POST["selectedMonth"];

    // Assuming tables Animal, Species, Employee, and CaresFor

    $query = "SELECT 
                Animal.SpeciesID, 
                Species.Name AS SpeciesName, 
                Animal.Status,
                SUM(Species.FoodCost) AS TotalFoodCost,
                SUM(HourlyRate.HourlyRate * 40) AS TotalLaborCost
              FROM Animal
              INNER JOIN Species ON Animal.SpeciesID = Species.ID
              LEFT JOIN CaresFor ON Animal.SpeciesID = CaresFor.SpeciesID
              LEFT JOIN Employee ON CaresFor.EmployeeID = Employee.EmployeeID
              LEFT JOIN HourlyRate ON Employee.HourlyRateID = HourlyRate.ID
              GROUP BY Animal.SpeciesID, Animal.Status";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the report
    echo "<h2>Animal Population Report</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Species</th><th>Status</th><th>Total Food Cost</th><th>Total Labor Cost</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['SpeciesName']}</td>";
        echo "<td>{$row['Status']}</td>";
        echo "<td>{$row['TotalFoodCost']}</td>";
        echo "<td>{$row['TotalLaborCost']}</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<a href='animal_population_report_form.php'>Back to Report Form</a>";

    $stmt->close();
    $conn->close();
}
?>
