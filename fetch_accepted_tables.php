<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT table_number, price FROM pool_accepted";
$result = $conn->query($sql);

$accepted_tables = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $accepted_tables[] = $row;
    }
}

$conn->close();
echo json_encode($accepted_tables);
?>