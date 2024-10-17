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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId'])) {
    $productId = $_POST['productId'];
    $customerId = $_SESSION['cid'];

    // Check if the product is already added to the cart
    $sql_check_cart = "SELECT * FROM customer_cart WHERE cid = ? AND pid = ?";
    $stmt_check_cart = $connection->prepare($sql_check_cart);
    $stmt_check_cart->bind_param("ii", $customerId, $productId);
    $stmt_check_cart->execute();
    $result_check_cart = $stmt_check_cart->get_result();
    if ($result_check_cart->num_rows > 0) {
        echo 'added';
    } else {
        echo 'not_added';
    }
}
?>
