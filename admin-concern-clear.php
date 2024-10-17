<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Clear all concerns
$sql = "TRUNCATE TABLE concerns";

if ($conn->query($sql) === TRUE) {
    echo "All concerns cleared successfully.";
} else {
    echo "Error clearing concerns: " . $conn->error;
}

$conn->close();
?>