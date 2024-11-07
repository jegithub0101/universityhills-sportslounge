<?php
session_start();
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the pool_table_number from the AJAX request
$poolTableNumber = $_POST['pool_table_number'];

// Update the pool_table_number table
$sql = "UPDATE pool_table_number SET table_number=NULL, time_reserved=NULL, time_playing=NULL, time_end=NULL, status='empty', occupied='empty' WHERE pool_table_number=$poolTableNumber";

if ($conn->query($sql) === TRUE) {
    echo "Table emptied successfully.";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>