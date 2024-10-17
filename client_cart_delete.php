<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get the cart_id from the POST data
$cartID = $_POST['cart_id'];

// Prepare and execute the delete statement
$stmt = $connection->prepare("DELETE FROM customer_cart WHERE cart_id = ?");
$stmt->bind_param("i", $cartID);
if ($stmt->execute()) {
    // Item deleted successfully
    echo "Item deleted successfully";
} else {
    // Error deleting item
    echo "Error deleting item: " . $connection->error;
}

// Close the statement and connection
$stmt->close();
$connection->close();
?>
