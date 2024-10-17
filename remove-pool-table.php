<?php
session_start();
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve pool table number to be removed
$poolTableNumberToRemove = $_POST['pool_table_number'];

// Prepare and execute SQL statement to remove pool table
$stmt = $conn->prepare("DELETE FROM pool_table_number WHERE pool_table_number = ?");
$stmt->bind_param("i", $poolTableNumberToRemove);

if ($stmt->execute()) {
    echo "Pool table removed successfully";
} else {
    echo "Error removing pool table: " . $conn->error;
}

// Close connection
$conn->close();
?>
