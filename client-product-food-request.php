<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

$connection = mysqli_connect($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$pid = $_POST['pid'];
$pname = $_POST['pname'];
$pprice = $_POST['pprice'];
$pprice = $_POST['pstock'];
$table_number = $_SESSION['table_number'];

$sql = "INSERT INTO customer_cart (cid, pid, table_number, product_name, price, quantity) VALUES (?, ?, ?, ?, ?, 1)";
$stmt = $connection->prepare($sql);

// Assuming 1 for cid, you might need to change this according to your actual logic
$cid = 23;

$stmt->bind_param("iiisd", $cid, $pid, $table_number, $pname, $pprice);

if ($stmt->execute()) {
    echo "Data inserted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();

$connection->close();

// Redirect back to the previous page
header("Location: " . $_SERVER["HTTP_REFERER"]);
exit();
?>
