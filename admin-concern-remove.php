<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Remove the concern
if (isset($_POST['cid'])) {
    $cid = $_POST['cid'];
    $sql = "DELETE FROM concerns WHERE CID = $cid";

    if ($conn->query($sql) === TRUE) {
        echo "Concern removed successfully.";
    } else {
        echo "Error removing concern: " . $conn->error;
    }
}

$conn->close();
?>