<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get table_number from the POST request
$table_number = $_POST['table_number'];

// Check for pending pool reservations for the given table_number
$sql_check_reservation = "SELECT * FROM pool_reserve WHERE table_number = $table_number AND status = 'waiting'";
$result_check_reservation = mysqli_query($connection, $sql_check_reservation);

$response = array();

if (mysqli_num_rows($result_check_reservation) > 0) {
    // There is a pending reservation
    $response['hasReservation'] = true;
} else {
    // No pending reservation
    $response['hasReservation'] = false;
}

// Return JSON response
echo json_encode($response);

// Close database connection
mysqli_close($connection);
?>
