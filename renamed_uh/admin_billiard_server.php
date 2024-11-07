<?php
session_start();
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch reservation data from pool_table_number table
$reservationSql = "SELECT * FROM pool_table_number";
$reservationResult = $conn->query($reservationSql);

// Fetch queue list
$queueSql = "SELECT * FROM pool_reserve";
$queueResult = $conn->query($queueSql);
?>

      
      <!-- Reservation Table -->
        <div class="card">
            <div class="card-header">
                <h3>Reservation Table</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Billiard Table Number</th>
                                <th>Table Number</th>
                                <th>Time Reserved</th>
                                <th>Time Started</th>
                                <th>Time End</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="reservation-table">
                            <?php
                            if ($reservationResult->num_rows > 0) {
                                while ($row = $reservationResult->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["pool_table_number"] . "</td>";
                                    echo "<td>" . $row["table_number"] . "</td>";
                                    echo "<td>" . $row["time_reserved"] . "</td>";
                                    echo "<td>" . $row["time_playing"] . "</td>";
                                    echo "<td>" . $row["time_end"] . "</td>";
                                    echo "<td>" . $row["status"] . "</td>";
                                    // Check if the status is 'empty', if so, hide the button
                                    if ($row["status"] !== 'empty') {
                                        echo "<td><button class='btn btn-danger empty-btn' data-id='" . $row["pool_table_number"] . "' onclick='emptyPoolTable($row[pool_table_number])'>End Session</button></td>";
                                    } else {
                                        echo "<td></td>"; // If status is 'empty', don't show the button
                                    }
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No available pool tables.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Add Another Pool Table Button -->
        <div class="mt-3">
            <button class="btn btn-primary" onclick="addPoolTable()">Add Another Pool Table</button>
            <button class="btn btn-danger" onclick="removePoolTable()">Remove Pool Table</button>

        </div>
        <!-- Queue List -->
        <div class="card mt-3">
            <div class="card-header">
                <h3>Queue List</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Queue Number</th>
                                <th>Table Number</th>
                                <th>Time Reserved</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                    if ($queueResult->num_rows > 0) {
                        $countPlaying = 0;
                        while ($row = $queueResult->fetch_assoc()) {
                            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["table_number"] . "</td><td>" . $row["time"] . "</td><td>" . $row["status"] . "</td>";
                            // Display "Mark as Playing" button if the status is not 'Playing'
                            if ($row["status"] !== 'Playing' && $countPlaying < 3) {
                                echo "<td><button class='btn btn-success mark-playing-btn' onclick='markQueueAsPlaying($row[id])' data-id='" . $row["id"] . "'>Mark as Playing</button> ";
                                echo "<button class='btn btn-danger cancel-btn' data-id='" . $row["id"] . "' onclick='cancelReservation(this)'>Cancel</button></td>";
                            } else {
                                echo "<td></td>"; // If status is 'Playing' or maximum reached, don't show the buttons
                            }
                            echo "</tr>";
                            if ($row["status"] === 'Playing') {
                                $countPlaying++;
                            }
                        }
                    } else {
                        echo "<tr><td colspan='4'>No queues</td></tr>";
                    }
                    ?>
                </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php
if ($queueResult->num_rows > 0) {
    $countPlaying = 0;
    $firstRow = true; // Flag to identify the first row
    while ($row = $queueResult->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["table_number"] . "</td><td>" . $row["status"] . "</td>";
        
        // Display "Mark as Playing" button only for the first row and when status is not 'Playing'
        if ($row["status"] !== 'Playing' && $firstRow) {
            echo "<td><button class='btn btn-success mark-playing-btn' onclick='markQueueAsPlaying($row[id])' data-id='" . $row["id"] . "'>Mark as Playing</button> ";
            echo "<button class='btn btn-danger cancel-btn' data-id='" . $row["id"] . "' onclick='cancelReservation(this)'>Cancel</button></td>";
            $firstRow = false; // Set the flag to false after displaying the button for the first row
        } else {
            echo "<td></td>"; // If status is 'Playing' or not the first row, don't show the buttons
        }
        
        echo "</tr>";
        if ($row["status"] === 'Playing') {
            $countPlaying++;
        }
    }
} else {
    echo "<tr><td colspan='4'>No queues</td></tr>";
}
?>
