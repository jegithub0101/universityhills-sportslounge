<?php
// Database connection code here

// Include the generateVerificationCode function
function generateVerificationCode($table_number, $connection) {
    // Generate a random 5-digit verification code
    $verification_code = mt_rand(10000, 99999);

    // Update the verification code in the "tables" table
    $update_query = "UPDATE tables SET verification_code = '$verification_code' WHERE table_number = $table_number";
    if ($connection->query($update_query) === TRUE) {
        return $verification_code;
    } else {
        return false;
    }
}

// Get the table_number from the AJAX request
$table_number = $_POST['table_number'];

// Generate and update the verification code
$verification_code = generateVerificationCode($table_number, $connection);

// Return the verification code as the response
echo $verification_code;
?>