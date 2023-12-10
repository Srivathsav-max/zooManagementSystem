<?php
// Include the common database connection file
include '../includes/db_connection.php';

// Handle ticket checkout form submission
// Handle ticket checkout form submission
// Handle ticket checkout form submission
// Handle ticket checkout form submission
// Handle ticket checkout form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["checkoutTicket"])) {
    $animalShowID = $_POST["animalShowID"];
    $adultTickets = $_POST["adultTickets"];
    $childTickets = $_POST["childTickets"];
    $seniorTickets = $_POST["seniorTickets"];

    // Fetch the animal show details to get the prices
    $animalShowDetailsSql = "SELECT SeniorPrice, AdultPrice, ChildPrice FROM AnimalShow WHERE ID = ?";
    $animalShowDetailsStmt = $conn->prepare($animalShowDetailsSql);
    $animalShowDetailsStmt->bind_param("i", $animalShowID);
    $animalShowDetailsStmt->execute();
    $animalShowDetailsResult = $animalShowDetailsStmt->get_result();
    $animalShowDetails = $animalShowDetailsResult->fetch_assoc();
    $animalShowDetailsStmt->close();

    $seniorPrice = $animalShowDetails['SeniorPrice'];
    $adultPrice = $animalShowDetails['AdultPrice'];
    $childPrice = $animalShowDetails['ChildPrice'];

    // Calculate total attendance and revenue for the current transaction
    $attendance = $adultTickets + $childTickets + $seniorTickets;
    $revenue = ($seniorTickets * $seniorPrice) + ($adultTickets * $adultPrice) + ($childTickets * $childPrice);

    // Insert ticket records with checkout time
    $insertTicketSql = "INSERT INTO AnimalShowTickets (AnimalShowID, AdultTickets, ChildTickets, SeniorTickets, Price, Attendance, Revenue, CheckoutTime) VALUES (?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
    $insertTicketStmt = $conn->prepare($insertTicketSql);
    $insertTicketStmt->bind_param("iiididd", $animalShowID, $adultTickets, $childTickets, $seniorTickets, $revenue, $attendance, $revenue);
    $insertTicketStmt->execute();
    $insertTicketStmt->close();
}

// Fetch and display animal shows
$animalShowsSql = "SELECT ID, ShowsPerDay, SeniorPrice, AdultPrice, ChildPrice FROM AnimalShow";
$animalShowsResult = $conn->query($animalShowsSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Show Ticket Checkout</title>
</head>
<body>
    <h2>Animal Show Ticket Checkout</h2>

    <!-- Ticket checkout form -->
    <form method="post" action="">
        <label for="animalShowID">Select Animal Show:</label>
        <select name="animalShowID" required>
            <?php while ($animalShow = $animalShowsResult->fetch_assoc()) : ?>
                <option value="<?php echo $animalShow['ID']; ?>">
                    <?php echo "Show ID: " . $animalShow['ID']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <label for="adultTickets">Adult Tickets:</label>
        <input type="button" value="-" onclick="decrement('adultTickets')"> 
        <input type="text" name="adultTickets" id="adultTickets" value="0" readonly>
        <input type="button" value="+" onclick="increment('adultTickets')"><br>

        <label for="childTickets">Child Tickets:</label>
        <input type="button" value="-" onclick="decrement('childTickets')"> 
        <input type="text" name="childTickets" id="childTickets" value="0" readonly>
        <input type="button" value="+" onclick="increment('childTickets')"><br>

        <label for="seniorTickets">Senior Tickets:</label>
        <input type="button" value="-" onclick="decrement('seniorTickets')"> 
        <input type="text" name="seniorTickets" id="seniorTickets" value="0" readonly>
        <input type="button" value="+" onclick="increment('seniorTickets')"><br>

        <button type="submit" name="checkoutTicket">Checkout Ticket</button>
    </form>

    <script>
        function increment(elementId) {
            var inputElement = document.getElementById(elementId);
            inputElement.value = parseInt(inputElement.value) + 1;
        }

        function decrement(elementId) {
            var inputElement = document.getElementById(elementId);
            var value = parseInt(inputElement.value);
            if (value > 0) {
                inputElement.value = value - 1;
            }
        }
    </script>

    <!-- Display animal shows with attendance and revenue -->
    <h3>Animal Shows Information</h3>
    <table border="1">
        <tr>
            <th>Show ID</th>
            <th>Shows Per Day</th>
            <th>Senior Price</th>
            <th>Adult Price</th>
            <th>Child Price</th>
            <th>Attendance</th>
            <th>Revenue</th>
        </tr>
        <?php
        $animalShowsResult = $conn->query($animalShowsSql);
        while ($animalShow = $animalShowsResult->fetch_assoc()) :
            $animalShowID = $animalShow['ID'];
            
            // Fetch Attendance and Revenue from AnimalShowTickets
            $animalShowTicketsSql = "SELECT SUM(Attendance) AS TotalAttendance, SUM(Revenue) AS TotalRevenue FROM AnimalShowTickets WHERE AnimalShowID = ?";
            $animalShowTicketsStmt = $conn->prepare($animalShowTicketsSql);
            $animalShowTicketsStmt->bind_param("i", $animalShowID);
            $animalShowTicketsStmt->execute();
            $animalShowTicketsResult = $animalShowTicketsStmt->get_result();
            $animalShowTickets = $animalShowTicketsResult->fetch_assoc();
            $animalShowTicketsStmt->close();
        ?>
            <tr>
                <td><?php echo $animalShow['ID']; ?></td>
                <td><?php echo $animalShow['ShowsPerDay']; ?></td>
                <td><?php echo $animalShow['SeniorPrice']; ?></td>
                <td><?php echo $animalShow['AdultPrice']; ?></td>
                <td><?php echo $animalShow['ChildPrice']; ?></td>
                <td><?php echo $animalShowTickets['TotalAttendance']; ?></td>
                <td><?php echo $animalShowTickets['TotalRevenue']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

