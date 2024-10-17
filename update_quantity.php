<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cartID = $_POST['cart_id'];
    $newQuantity = $_POST['quantity'];

    // Get the table_number and table_name from the session
    $table_number = $_SESSION['table_number'];
    $table_name = $_SESSION['table_name'];

    // Get the cid from the customer table
    $sql_cid = "SELECT cid FROM customer WHERE table_number = $table_number AND nickname = '$table_name'";
    $result_cid = $connection->query($sql_cid);
    $row_cid = $result_cid->fetch_assoc();
    $cid = $row_cid['cid'];

    // Update quantity in the customer_cart table
    $sql_update_quantity = "UPDATE customer_cart SET quantity = $newQuantity WHERE cart_id = $cartID AND cid = $cid";
    if ($connection->query($sql_update_quantity) !== TRUE) {
        echo "Error updating quantity: " . $connection->error;
    }
}
?>