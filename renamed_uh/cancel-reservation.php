<?php
session_start();

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

// Check if the request method is POST and the queue_id is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["queue_id"])) {
    $queueId = $_POST["queue_id"];

    // Delete the reservation from pool_reserve where id matches the queue_id
    $deleteSql = "DELETE FROM pool_reserve WHERE id = $queueId";
    if ($conn->query($deleteSql) === TRUE) {
        echo "Reservation cancelled successfully";
    } else {
        echo "Error cancelling reservation: " . $conn->error;
    }
}

$conn->close();
?>
