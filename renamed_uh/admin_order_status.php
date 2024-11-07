<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the action parameter is set
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $cid = $_POST['cid'];
    $tracking = $_POST['tracking'];
    
    // Update the status based on the action
    if ($action == 'accept') {
        $status = "Preparing";
    } elseif ($action == 'delete') {
        $status = "Cancelled";
    } elseif ($action == 'done'){
        $status = "Done";
    }
    

    // Prepare the SQL statement
    $stmt = $connection->prepare("UPDATE admin_order SET status = ?, notice = 'notified' WHERE cid = ? AND tracking_no = ? and not status='Cancelled'");
    $stmt->bind_param("sis", $status, $cid, $tracking);

    if ($stmt->execute()) {
        // Prepare the SQL statement
        $stmtnotice = $connection->prepare("UPDATE admin_order SET notice = 'notified' WHERE cid = ? AND tracking_no = ?");
        $stmtnotice->bind_param("is", $cid, $tracking);
        $stmtnotice->execute();
        echo "Order Updated!";
    } else {
        echo "Error updating status: " . $stmt->error;
    }

    $stmt->close();
}

$connection->close();
?>