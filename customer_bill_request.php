<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Get the table_number and cid from the AJAX request
$table_number = $_SESSION['table_number'];
$table_name = $_SESSION['table_name'];

$sql_cid = "SELECT cid FROM customer WHERE table_number = $table_number and nickname = '$table_name'";
$result_cid = $connection->query($sql_cid);
$row_cid = $result_cid->fetch_assoc();
$cid = $row_cid['cid'];

$sql_max = "SELECT MAX(billout_by) as billout_by FROM admin_order";
$result_max = $connection->query($sql_max);
$row_max = $result_max->fetch_assoc();
$max = $row_max['billout_by'];

echo $max;

if($max === 0){
    $max = 1;
}
else if($max>0){
    $max = $max + 1;
}




// Update the status to "paying" in the database
$sql = "UPDATE admin_order SET status = 'Request', billout_by = $max WHERE table_number = $table_number  AND status!='pending' AND status!='Cancelled'";

if ($connection->query($sql) === TRUE) {
    echo "Status updated to 'paying' successfully";
    
} else {
    echo "Error updating status: " . $connection->error;
}




$connection->close();
?>