<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Reset the auto-increment value of the id column if there are no records
$checkQuery = "SELECT COUNT(*) FROM pool_reserve";
$result = $conn->query($checkQuery);
$count = $result->fetch_row()[0];

if ($count == 0) {
    $resetQuery = "ALTER TABLE pool_reserve AUTO_INCREMENT = 1";
    if ($conn->query($resetQuery) === TRUE) {
        echo "";
    } else {
        echo "Error resetting auto-increment value: " . $conn->error;
    }
}

// Check if the user's table_number is already present in the pool_reserve table
$userTableNumber = "";
if (isset($_SESSION["table_number"])) {
    $userTableNumber = $_SESSION["table_number"];
}

// Check if the user's table number has an existing reservation or is currently playing
$sql = "SELECT * FROM pool_table_number WHERE table_number = ? AND (status = 'Playing' OR status = 'reserved')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userTableNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If the user already has a reserved or playing table, check if there are no other people in the queue
    $checkQueueSql = "SELECT COUNT(*) FROM pool_reserve WHERE status = 'Waiting' AND table_number = ?";
    $checkQueueStmt = $conn->prepare($checkQueueSql);
    $checkQueueStmt->bind_param("i", $userTableNumber);
    $checkQueueStmt->execute();
    $queueCount = $checkQueueStmt->get_result()->fetch_row()[0];

    if ($queueCount == 0) {
        // Allow the user to reserve again
        $sql = "INSERT INTO pool_reserve (pool_table, table_number, time, status) VALUES (1, ?, NOW(), 'Waiting')";
        $reserveStmt = $conn->prepare($sql);
        $reserveStmt->bind_param("i", $userTableNumber);
        if ($reserveStmt->execute()) {
            $_SESSION['last_reservation_timestamp'] = time();
            echo "Reservation successful";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "You already have a reserved or playing table, and you are in the queue.";
    }
} else {
    // Check if there are no other table numbers in queue and there are empty pool_table_number status
    $checkQueueSql = "SELECT COUNT(*) FROM pool_reserve WHERE status = 'Waiting' AND table_number = ?";
    $checkQueueStmt = $conn->prepare($checkQueueSql);
    $checkQueueStmt->bind_param("i", $userTableNumber);
    $checkQueueStmt->execute();
    $queueCount = $checkQueueStmt->get_result()->fetch_row()[0];

    $checkEmptyTableSql = "SELECT COUNT(*) FROM pool_table_number WHERE status = 'empty'";
    $checkEmptyTableResult = $conn->query($checkEmptyTableSql);
    $emptyTableCount = $checkEmptyTableResult->fetch_row()[0];

    if ($queueCount == 0 && $emptyTableCount > 0) {
        // Reserve pool
        $sql = "INSERT INTO pool_reserve (pool_table, table_number, time, status) VALUES (1, ?, NOW(), 'Waiting')";
        $reserveStmt = $conn->prepare($sql);
        $reserveStmt->bind_param("i", $userTableNumber);
        if ($reserveStmt->execute()) {
            $_SESSION['last_reservation_timestamp'] = time();
            echo "Reservation successful";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        // If there are no available tables and the user hasn't reserved before
        $checkReservedOnceSql = "SELECT COUNT(*) FROM pool_reserve WHERE table_number = ? AND status = 'Waiting'";
        $checkReservedOnceStmt = $conn->prepare($checkReservedOnceSql);
        $checkReservedOnceStmt->bind_param("i", $userTableNumber);
        $checkReservedOnceStmt->execute();
        $reservedOnceCount = $checkReservedOnceStmt->get_result()->fetch_row()[0];

        if ($queueCount == 0 && $emptyTableCount == 0 && $reservedOnceCount == 0) {
            $sql = "INSERT INTO pool_reserve (pool_table, table_number, time, status) VALUES (1, ?, NOW(), 'Waiting')";
            $reserveStmt = $conn->prepare($sql);
            $reserveStmt->bind_param("i", $userTableNumber);
            if ($reserveStmt->execute()) {
                $_SESSION['last_reservation_timestamp'] = time();
                echo "Reservation successful";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "You have already reserved a table once or you are already in the queue. Please wait for an available table.";
        }
    }
}

$conn->close();
?>
