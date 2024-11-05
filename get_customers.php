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

if (isset($_GET['table_number'])) {
    $table_number = $_GET['table_number'];

    // Prepared statement to retrieve customers based on table number
    $sql = "SELECT nickname FROM customer WHERE table_number = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $table_number);
    $stmt->execute();
    $result = $stmt->get_result();

    $customers = [];
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }

    // Return JSON response
    echo json_encode($customers);
}
