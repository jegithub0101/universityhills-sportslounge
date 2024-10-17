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
$paymentTrackingNo = "Uh_PAYMENT" . rand(0, 10000) . substr(rand(0, 10000), 2);

// Get the current date
$currentDate = date('Y-m-d');

$tracking = $paymentTrackingNo;

$sql_count = "SELECT COUNT(DISTINCT cid) AS distinct_cid_count from admin_order where table_number = '$tableNumber' and status = 'Request'";
$result_count = $connection->query($sql_count);
$row_count = $result_count->fetch_assoc();
$count = $row_count['distinct_cid_count'];

// Insert the data into the overall_payment table
$sqlOverall = "INSERT INTO overall_payment (payment_trackingno, totalprice, total_user, total_valid, date) VALUES ('$tracking', $overallTotal,$count,$pix, '$currentDate')";


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
            $sql_prodpayment = "INSERT INTO product_payment (payment_trackingno, pid, product_name, quantity, date) VALUES ('$tracking', $row_item_payment[PID], '$row_item_payment[product_name]', $row_item_payment[total_quantity],'$currentDate' )";

            $connection->query($sql_prodpayment);

        }
    }

    $sql_order_delete = "DELETE FROM admin_order where table_number = '$tableNumber' and status = 'Request' ";
    $result_delete = $connection->query($sql_order_delete);
    

    $sql_billiard_delete = "DELETE FROM pool_accepted where table_number = $tableNumber";
    $result_billiard_delete = $connection->query($sql_billiard_delete);
?>
