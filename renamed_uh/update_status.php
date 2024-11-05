<?php
// update_status.php

// Database connection details
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

// Fetch the request ID and new status from the AJAX request
$requestID = $_POST['request_id'];
$status = $_POST['status'];

// Prepare and bind parameters
$stmt = $conn->prepare("UPDATE song_requests SET status=? WHERE ID=?");
$stmt->bind_param("si", $status, $requestID);

// Execute the statement
if ($stmt->execute()) {
    echo "Status updated successfully";
} else {
    echo "Error updating status: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
