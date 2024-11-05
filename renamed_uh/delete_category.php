<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

//Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);


// Function to check if a user is logged in
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Redirect to login page if not logged in
if (!isLoggedIn()) {
    header("Location: admin-login.php");
    exit;
}


//check connection
if($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the category name is provided
    if (isset($_POST["categoryName"])) {
        // Sanitize input to prevent SQL injection
        $categoryName = mysqli_real_escape_string($connection, $_POST["categoryName"]);

        // SQL query to delete the category
        $sql = "DELETE FROM product_category WHERE category_name = '$categoryName'";

        // Execute the query
        if (mysqli_query($connection, $sql)) {
            // If deletion is successful, return a success message
            echo "Category deleted successfully.";
        } else {
            // If an error occurred during deletion, return an error message
            echo "Error: " . mysqli_error($connection);
        }
    } else {
        // If the category name is not provided, return an error message
        echo "Category name not provided.";
    }
} else {
    // If the request method is not POST, return an error message
    echo "Invalid request method.";
}

// Close the database connection
mysqli_close($connection);
?>