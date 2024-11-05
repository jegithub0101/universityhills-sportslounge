<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Truncate the pool_accepted table
$truncateSql = "TRUNCATE TABLE pool_accepted";

if ($conn->query($truncateSql) === TRUE) {
    $response = array(
        'success' => true
    );
} else {
    $response = array(
        'success' => false,
        'error' => $conn->error
    );
}

// Close the database connection
$conn->close();

// Return the response as JSON
echo json_encode($response);
?>