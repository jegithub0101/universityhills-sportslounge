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

// Check if the request is made through POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'clear_all' parameter is set
    if (isset($_POST["clear_all"]) && $_POST["clear_all"] == true) {
        // SQL to delete all song requests
        $sql = "DELETE FROM song_requests";

        if ($conn->query($sql) === TRUE) {
            echo "All song requests have been deleted successfully.";
        } else {
            echo "Error deleting song requests: " . $conn->error;
        }
    }
}

// Close the connection
$conn->close();
?>
