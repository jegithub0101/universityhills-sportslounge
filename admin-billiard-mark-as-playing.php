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

// Check if there are any available pool tables
$sqlCheckAvailable = "SELECT MIN(pool_table_number) AS lowest_available_table FROM pool_table_number WHERE occupied = 'empty'";
$resultCheckAvailable = $conn->query($sqlCheckAvailable);
$rowCheckAvailable = $resultCheckAvailable->fetch_assoc();

if (!$rowCheckAvailable['lowest_available_table']) {
    echo "There are no available pool tables yet.";
    $conn->close();
    exit; // Exit the script if there are no available tables
}

// Get the lowest available pool table number
$lowestAvailableTable = $rowCheckAvailable['lowest_available_table'];

// Get the queue ID from the AJAX request
$id = mysqli_real_escape_string($conn, $_POST['id']);

// Mark queue as playing
$time_playing = date('Y-m-d H:i:s');
$time_end = date('Y-m-d H:i:s', strtotime($time_playing . ' +1 hour'));

// Fetch time from pool_reserve table
$sqlFetchTime = "SELECT time FROM pool_reserve WHERE id=$id";
$resultFetchTime = $conn->query($sqlFetchTime);
$rowFetchTime = $resultFetchTime->fetch_assoc();
$time_reserved = $rowFetchTime['time'];

// Update pool_reserve table
$sqlUpdatePoolReserve = "UPDATE pool_reserve SET status='Playing', time_playing='$time_playing' WHERE id=$id";
if ($conn->query($sqlUpdatePoolReserve) === TRUE) {
    // Update pool_table_number table with the lowest available table number
    $sqlUpdateTable = "UPDATE pool_table_number SET table_number=$lowestAvailableTable, time_reserved='$time_reserved', time_playing='$time_playing', time_end='$time_end', status='Playing', occupied='occupied' WHERE pool_table_number = $lowestAvailableTable";
    if ($conn->query($sqlUpdateTable) === TRUE) {
        // Insert into pool_accepted table
        $sqlInsert = "INSERT INTO pool_accepted (cid, table_number, price) VALUES (NULL, $lowestAvailableTable, 150)";
        if ($conn->query($sqlInsert) === TRUE) {
            // Delete the entry from pool_reserve table
            $sqlDelete = "DELETE FROM pool_reserve WHERE id=$id";
            if ($conn->query($sqlDelete) === TRUE) {
                echo "Marked as playing successfully, entry added to pool_accepted table, and entry removed from the queue";
            } else {
                echo "Error deleting entry from queue: " . $conn->error;
            }
        } else {
            echo "Error inserting into pool_accepted table: " . $conn->error;
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Error updating record: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
