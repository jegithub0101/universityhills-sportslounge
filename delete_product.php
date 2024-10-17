<?php
// Include your database connection file here
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check Connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}


// Check if product ID is set and not empty
if(isset($_POST['deleteProductId']) && !empty($_POST['deleteProductId'])) {
    // Sanitize the input
    $deleteProductId = $_POST['deleteProductId'];

    // Prepare a delete statement
    $sql = "DELETE FROM products WHERE PID = ?";

    if($stmt = $connection->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_deleteProductId);

        // Set parameters
        $param_deleteProductId = $deleteProductId;

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Product deleted successfully
            echo "Product deleted successfully.";
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();
    
    // Close connection
    $connection->close();
} else {
    // Product ID is not set or empty
    echo "Invalid product ID.";
}
?>
