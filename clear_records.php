<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check Connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL to delete all records from product_payment table
$sql = "DELETE FROM product_payment";

if (mysqli_query($connection, $sql)) {
    echo "Records deleted successfully";
} else {
    echo "Error deleting records: " . mysqli_error($connection);
}

mysqli_close($connection);
?>
