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

// Check if sortDate parameter is set
if(isset($_GET['sortDate'])) {
    // Retrieve the sortDate parameter
    $sortDate = $_GET['sortDate'];
    
    // Perform a database query to fetch records sorted by date
    $query = "SELECT * FROM product_payment WHERE date = '$sortDate'";
    $result = mysqli_query($connection, $query);
    
    // Check if records were found
    if(mysqli_num_rows($result) > 0) {
        // Fetch and output records as JSON
        $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($records);
    } else {
        // No records found
        echo json_encode([]);
    }
} else {
    // If sortDate parameter is not set, fetch all records
    $query = "SELECT * FROM product_payment";
    $result = mysqli_query($connection, $query);
    
    // Check if records were found
    if(mysqli_num_rows($result) > 0) {
        // Fetch and output records as JSON
        $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($records);
    } else {
        // No records found
        echo json_encode([]);
    }
}
?>
