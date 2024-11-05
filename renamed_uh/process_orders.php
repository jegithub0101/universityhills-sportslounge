<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

//Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$description = "";
if (isset($_GET['description'])) {
    $description = $_GET['description'];
}
else{
    $description = "";
}

$table_number =  $_SESSION['table_number'];
$table_name = $_SESSION['table_name'];

$sql_cid = "SELECT cid FROM customer WHERE table_number = $table_number and nickname = '$table_name'";
$result_cid = $connection->query($sql_cid);
$row_cid = $result_cid->fetch_assoc();
$cid = $row_cid['cid'];


// Fetch products from the database
$sql = "SELECT * FROM customer_cart where cid = $cid";
$result = $connection->query($sql);

// $total_price = 0;
// foreach($result as $tprice){
//     $total_price += $tprice['price'] * $tprice['quantity'];
// }
$tracking_no = "Uh". rand(0,10000).substr($cid,2);


$sql_descript = "INSERT INTO product_instruction (tracking_no, instruction) VALUES (?, ?)";
$stmt = $connection->prepare($sql_descript);

if ($stmt) {
    // Bind the tracking number and description to the prepared statement
    $stmt->bind_param("ss", $tracking_no, $description);
    // Execute the statement
    $stmt->execute();
    // Close the statement
    $stmt->close();
} else {
    echo "Failed to prepare statement";
}

foreach($result as $item){
    $subtotal = $item['price'] * $item['quantity'];
    $pid = $item['PID'];
    $product_name = $item['product_name'];
    $price = $item['price'];
    $quantity = $item['quantity'];

    

    $sql = "INSERT INTO admin_order (tracking_no, cid, PID, table_number, product_name, price, quantity, subtotal, status, notice) VALUES ('$tracking_no', $cid, $pid, $table_number, '$product_name', $price, $quantity, $subtotal,'pending','notify')";
     // Execute the SQL query
     if ($connection->query($sql) === TRUE) {
        echo"
        <script>alert('Data inserted successfully!')</script>;
        ";
        
    }
    $sql_stock = "SELECT stock FROM products WHERE PID = $pid";
    $result_stock = $connection->query($sql_stock);
    $row_stock = $result_stock->fetch_assoc();

    $newStock = $row_stock['stock'] -  $quantity;

    $sql_update_stock = "UPDATE products SET stock = $newStock WHERE PID = $pid";
    $connection->query($sql_update_stock);
    
}
$sql_delete = "DELETE FROM customer_cart WHERE cid = $cid";
if ($connection->query($sql_delete) === TRUE) {
    echo "<script>alert('Order placed successfully!')</script>";
} else {
    echo "<script>alert('Error deleting items from the cart.')</script>";
}

?>

