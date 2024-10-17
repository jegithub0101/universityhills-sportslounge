<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get user input
$tableNumber = $_SESSION['table_number'];
$songRequest = $_POST["songrequest"];

// Prepare and execute the SQL query to check for cooldown and insert the song request
$sql_song = "INSERT INTO song_requests (table_number, time, song_request, status) 
             SELECT ?, NOW(), ?, 'Pending' 
             FROM dual 
             WHERE NOT EXISTS (
                 SELECT 1 
                 FROM song_requests 
                 WHERE table_number = ? 
                 AND time >= NOW() - INTERVAL 4 MINUTE
             )";
$stmt = $connection->prepare($sql_song);

// Bind parameters
$stmt->bind_param("isi", $tableNumber, $songRequest, $tableNumber);

// Execute the statement
if ($stmt->execute()) {
    // Song request inserted successfully
    $success_message = "Song request submitted successfully";
} else {
    // Error inserting song request
    $error_message = "Error submitting song request: " . $stmt->error;
}

// Close statement
$stmt->close();

// Close connection
$connection->close();

// Redirect back to the previous page
header("Location: " . $_SERVER["HTTP_REFERER"]);
exit();
?>
