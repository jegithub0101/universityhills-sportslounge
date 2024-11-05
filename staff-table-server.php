<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Function to generate a new verification code
function generateVerificationCode() {
    return strtoupper(substr(bin2hex(random_bytes(4)), 0, 8)); // Generate a random code
}

// Handling the AJAX request for changing the verification code
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tid'])) {
    $tid = intval($_POST['tid']);
    $newCode = generateVerificationCode();

    // Update the verification code in the database
    $updateSql = "UPDATE tables SET verification_code = ? WHERE tid = ?";
    $stmt = $connection->prepare($updateSql);
    $stmt->bind_param("si", $newCode, $tid);

    if ($stmt->execute()) {
        echo $newCode; // Return the new verification code
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    exit; // Terminate the script after handling the request
}

// Query the data from the tables
$sql = "SELECT tid, table_number, verification_code FROM tables";
$result = $connection->query($sql);

// Prepare data for output
$tableData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tableData[] = $row;
    }
}

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode($tableData);

// Close the connection
$connection->close();
?>


