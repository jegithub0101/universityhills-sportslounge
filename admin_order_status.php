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
    
    // If action is delete, get the order details BEFORE updating the status
    if ($action == 'delete') {
        // Get the order details before updating status
        $order_query = $connection->prepare("SELECT pid, quantity FROM admin_order WHERE cid = ? AND tracking_no = ? AND status != 'Cancelled'");
        $order_query->bind_param("is", $cid, $tracking);
        $order_query->execute();
        $result = $order_query->get_result();
        
        // Return quantities back to products table
        while ($row = $result->fetch_assoc()) {
            $update_stock = $connection->prepare("UPDATE products SET stock = stock + ? WHERE PID = ?");
            $update_stock->bind_param("ii", $row['quantity'], $row['pid']);  // Changed 'id' to 'pid'
            $update_stock->execute();
            $update_stock->close();
        }
        
        $order_query->close();
        $status = "Cancelled";
    } elseif ($action == 'accept') {
        $status = "Preparing";
    } elseif ($action == 'done') {
        $status = "Done";
    }

    // Prepare the SQL statement for status update
    $stmt = $connection->prepare("UPDATE admin_order SET status = ?, notice = 'notified' WHERE cid = ? AND tracking_no = ? AND NOT status='Cancelled'");
    $stmt->bind_param("sis", $status, $cid, $tracking);

    if ($stmt->execute()) {
        // Update notice
        $stmtnotice = $connection->prepare("UPDATE admin_order SET notice = 'notified' WHERE cid = ? AND tracking_no = ?");
        $stmtnotice->bind_param("is", $cid, $tracking);
        $stmtnotice->execute();
        $stmtnotice->close();
        echo "Order Updated!";
    } else {
        echo "Error updating status: " . $stmt->error;
    }

    $stmt->close();
}

$connection->close();
?>