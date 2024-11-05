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

function isLoggedIn() {
    return isset($_SESSION['table_number']);
}

// Return JSON response if not logged in
if (!isLoggedIn()) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit;
}

$table_number = $_SESSION['table_number'];
$table_name = $_SESSION['table_name'];

// Check if the request is via AJAX and POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pid = $_POST['pid'];
    $product_name = $_POST['pname'];
    $price = $_POST['pprice'];
    $pstock = $_POST['pstock'];

    // Get the customer ID (cid) based on table number and nickname
    $sql_tid = "SELECT cid FROM customer WHERE table_number = ? AND nickname = ?";
    $stmt_tid = $connection->prepare($sql_tid);
    $stmt_tid->bind_param("is", $table_number, $table_name);
    $stmt_tid->execute();
    $result_tid = $stmt_tid->get_result();

    if ($result_tid->num_rows > 0) {
        $row_tid = $result_tid->fetch_assoc();
        $cid = $row_tid['cid'];

        // Insert the product into the customer_cart table
        $sql_insert_cart = "INSERT INTO customer_cart (cid, pid, table_number, product_name, price, quantity, stock) 
                            VALUES (?, ?, ?, ?, ?, 1, ?)";
        $stmt_insert = $connection->prepare($sql_insert_cart);
        $stmt_insert->bind_param("iiisii", $cid, $pid, $table_number, $product_name, $price, $pstock);

        // Execute the insertion
        if ($stmt_insert->execute()) {
            echo json_encode(["status" => "success", "message" => "Product added to cart successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error adding product to cart: " . $stmt_insert->error]);
        }
        $stmt_insert->close();
    } else {
        echo json_encode(["status" => "error", "message" => "No matching record found in the customer table."]);
    }
    $stmt_tid->close();
}

// Close the connection
$connection->close();
?>
