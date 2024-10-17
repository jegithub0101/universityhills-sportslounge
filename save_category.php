<?php
// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve category name from POST data
$categoryName = $_POST["categoryName"];

// Insert category into database
$sql = "INSERT INTO product_category (category_name) VALUES ('$categoryName')";

if ($conn->query($sql) === TRUE) {
    echo "Category saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
