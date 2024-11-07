<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
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

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['tableNumber'])) {
        $tableNumber = $_POST['tableNumber'];

        // SQL query to delete the table
        $sql = "DELETE FROM tables WHERE table_number = '$tableNumber'";

        // Execute the query
        if ($connection->query($sql) === TRUE) {
            // If deletion is successful, return a success message
            echo "Table deleted successfully.";
        } else {
            // If an error occurred during deletion, return an error message
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    } else {
        // If the table number is not provided, return an error message
        echo "Table number not provided.";
    }
} else {
    // If the request method is not POST, return an error message
    echo "Invalid request method.";
}

// Close the database connection
mysqli_close($connection);
?>
