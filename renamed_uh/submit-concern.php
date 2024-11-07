<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "university_hills";

//Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);


    // Check if the session variable is set
    if (!isset($_SESSION['table_number'])) {
        // Redirect to an error page or handle the lack of session variable
        exit("Error: Table number not set.");
    }

    // Get table number from session
    $table_number = $_SESSION['table_number'];

    // Get concern from form submission
    $concern = $_POST['concern'];

    // Prepare and execute SQL statement
    $sql = "INSERT INTO concerns (date_time, table_number, concern) VALUES (CURRENT_TIMESTAMP, ?, ?)";
    $stmt = $connection->prepare($sql);

    // Check if the statement is prepared successfully
    if ($stmt === false) {
        // Handle statement preparation error
        exit("Error: Unable to prepare SQL statement.");
    }

    // Bind parameters
    $stmt->bind_param("is", $table_number, $concern);

    // Execute statement
    if ($stmt->execute()) {
        // Set success message in session
        $_SESSION['success_message'] = "Concern submitted successfully.";
        header("Location: client-concern.php"); // Redirect back to the concern submission page
        exit;
    } else {
        // Handle execution error
        $_SESSION['error_message'] = "Error: " . $connection->error;
        header("Location: client-concern.php"); // Redirect back to the concern submission page
        exit;
    }

    // Close statement
    $stmt->close();
} else {
    // If the form is not submitted, redirect to the concern submission page
    header("Location: client-concern.php");
    exit;
}
?>
