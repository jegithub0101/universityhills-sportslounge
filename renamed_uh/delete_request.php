<?php
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

// Get the request_id from the AJAX request
$request_id = $_POST["request_id"];

// SQL query to delete the song request
$sql = "DELETE FROM song_requests WHERE ID = $request_id";

if ($conn->query($sql) === TRUE) {
    // Deletion successful
    echo "Song request deleted successfully";
} else {
    // Error occurred
    echo "Error deleting song request: " . $conn->error;
}

// Close the connection
$conn->close();
?>