<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the data from the AJAX request
$tableNumber = $_POST['table_number'];
$overallTotal = $_POST['overall_total'];
$pix = $_POST['pix'];


// Debugging: Inspect received data
var_dump($_POST);

// Generate a unique payment tracking number
$paymentTrackingNo = "UHPAYMENT-" . rand(0, 10000) . substr(rand(0, 10000), 2);

// Get the current date
$currentDate = date('Y-m-d');


// Set timezone to Philippines
date_default_timezone_set('Asia/Manila');

// Get the current time in 12-hour format with AM/PM
$currentTime = date('H:i:s');

$tracking = $paymentTrackingNo;

$sql_count = "SELECT COUNT(DISTINCT cid) AS distinct_cid_count from admin_order where table_number = '$tableNumber' and status = 'Request'";
$result_count = $connection->query($sql_count);
$row_count = $result_count->fetch_assoc();
$count = $row_count['distinct_cid_count'];

// $row_count['distinct_cid_count']

// Insert the data into the overall_payment table
$sqlOverall = "INSERT INTO overall_payment (payment_trackingno, totalprice, total_user, total_valid, date, time) VALUES ('$tracking', $overallTotal,$count,$pix, '$currentDate', '$currentTime')";


if ($connection->query($sqlOverall) === TRUE) {

} else {
    // Error inserting data into overall_payment table
    echo "Error: " . $sqlOverall . "<br>" . $connection->error;
}

$sql_prod = "SELECT Distinct PID, product_name, Sum(quantity) as total_quantity from admin_order where table_number = '$tableNumber' and status = 'Request' GROUP BY PID";
$result_payment_item = $connection->query($sql_prod);
    if ($result_payment_item->num_rows > 0) {
        // Loop through each item
        while ($row_item_payment = $result_payment_item->fetch_assoc()) {
            $sql_prodpayment = "INSERT INTO product_payment (payment_trackingno, pid, product_name, quantity, date, time) VALUES ('$tracking', $row_item_payment[PID], '$row_item_payment[product_name]', $row_item_payment[total_quantity],'$currentDate','$currentTime')";

            $connection->query($sql_prodpayment);

        }
    }

    $V_code = "UH-" . rand(0, 10000) . substr(rand(0, 10000), 2);

    $sql_verification = "UPDATE TABLES SET verification_code = '$V_code' where table_number = '$tableNumber'";
    $result_vc = $connection->query($sql_verification);

    $sql_order_delete = "DELETE FROM admin_order where table_number = '$tableNumber' and status = 'Request' ";
    $result_delete = $connection->query($sql_order_delete);

    $sql_table_delete = "DELETE FROM customer where table_number = '$tableNumber'";
    $result_table_delete =  $connection->query($sql_table_delete);

    $sql_billiard_delete = "DELETE FROM pool_accepted where table_number = $tableNumber";
    $result_billiard_delete = $connection->query($sql_billiard_delete);
?>
