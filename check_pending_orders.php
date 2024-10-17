<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Get the table_number from the session
$table_number = $_SESSION['table_number'];

// Check if there are orders with "Pending" or "Preparing" status
$sql_pending_orders = "SELECT COUNT(*) AS pending_count FROM admin_order WHERE table_number = '$table_number' AND status IN ('Pending', 'Preparing')";
$result_pending_orders = $connection->query($sql_pending_orders);
$row_pending_orders = $result_pending_orders->fetch_assoc();
$pending_count = $row_pending_orders['pending_count'];

// Return the pending count as JSON
echo json_encode(array('pending_count' => $pending_count));
?>