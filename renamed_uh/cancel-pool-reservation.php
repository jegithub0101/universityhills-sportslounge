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

// Delete the pending pool reservation for the given table_number
$sql_delete_reservation = "DELETE FROM pool_reserve WHERE table_number = $table_number AND status = 'waiting'";
$result_delete_reservation = mysqli_query($connection, $sql_delete_reservation);

$response = array();

if ($result_delete_reservation) {
    // Reservation deleted successfully
    $response['success'] = true;
} else {
    // Failed to delete reservation
    $response['success'] = false;
    $response['error'] = "Error deleting reservation: " . mysqli_error($connection);
}

// Return JSON response
echo json_encode($response);

// Close database connection
mysqli_close($connection);
?>
