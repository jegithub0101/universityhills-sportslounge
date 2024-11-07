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

// Get the last pool table number
$sql = "SELECT MAX(pool_table_number) AS last_pool_table FROM pool_table_number";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastPoolTableNumber = $row["last_pool_table"];
} else {
    $lastPoolTableNumber = 0; // If no pool table number exists yet
}

// Increment the last pool table number
$newPoolTableNumber = $lastPoolTableNumber + 1;

// Set other attributes
$tableNumber = NULL; // You can set this value based on your requirements
$timePlaying = NULL; // Initial time playing
$timeEnd = NULL; // Initial time end
$status = 'empty'; // Initial status
$occupied = 'empty'; // Initial occupied status

// Prepare and execute SQL statement to insert data
$stmt = $conn->prepare("INSERT INTO pool_table_number (pool_table_number, table_number, time_playing, time_end, status, occupied) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iiisss", $newPoolTableNumber, $tableNumber, $timePlaying, $timeEnd, $status, $occupied);

if ($stmt->execute()) {
    echo "New pool table added successfully";
} else {
    echo "Error adding pool table: " . $conn->error;
}

// Close connection
$conn->close();
?>
