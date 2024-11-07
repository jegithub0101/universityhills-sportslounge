<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}

// Generate a unique verification code
function generateVerificationCode() {
    return "UH-" . rand(0, 10000) . substr(rand(0, 10000), 2);
}

// Get the table ID from the POST request
$tid = $_POST['tid'];

// Generate a new code
$newCode = generateVerificationCode();

// Update the verification code in the database
$sql = "UPDATE tables SET verification_code = '$newCode' WHERE tid = $tid";

if ($connection->query($sql) === TRUE) {
    echo $newCode; // Send back the new code
} else {
    echo "Error: " . $sql . "<br>" . $connection->error;
}

// Close the connection
$connection->close();
?>
