<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";
//Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Retrieve product ID and quantity from GET parameters
$pid = $_GET['pid'];
$requestedQuantity = $_GET['quantity'];

// Query the database to get the stock of the product
$sql = "SELECT stock FROM products WHERE pid = $pid";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stock = $row['stock'];

    // Check if the available stock is sufficient for the requested quantity
    if ($stock >= $requestedQuantity) {
        // If there's enough stock, return JSON response indicating availability
        echo json_encode(array('available' => true));
    } else {
        // If there's insufficient stock, return JSON response indicating unavailability
        echo json_encode(array('available' => false));
    }
} else {
    // If the product is not found in the database, return JSON response indicating unavailability
    echo json_encode(array('available' => false));
}

// Close the database connection if needed
$connection->close();
?>
