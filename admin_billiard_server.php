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
<style>
/* Base styling for table */
.table-responsive {
    overflow-x: auto;
}

.table-bordered {
    width: 100%;
    border-collapse: collapse;
}

.table-bordered th,
.table-bordered td {
    padding: 8px;
    border: 1px solid #ddd;
}

/* Mobile responsive styles */
@media (max-width: 768px) {
    .table-bordered th, .table-bordered td {
        display: block;
        width: 100%;
        box-sizing: border-box;
    }
    
    .table-bordered thead {
        display: none;
    }
    
    .table-bordered tr {
        display: flex;
        flex-direction: column;
        border: 1px solid #ddd;
        margin-bottom: 10px;
    }
    
    .table-bordered td {
        position: relative;
        padding-left: 50%;
        text-align: right;
    }
    
    .table-bordered td::before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 50%;
        padding-left: 15px;
        font-weight: bold;
        text-align: left;
    }

    .table-bordered td::before {
        content: attr(data-label); /* Uses the content from data-label attribute */
        position: absolute;
        left: 0;
        width: 50%;
        padding-left: 15px;
        font-weight: bold;
        text-align: left;
    }
    body{
        font-size: small
    }
    .btn{
        font-size: small
    }
    /** make it row */
    .flexible-row-buttons{
        display: flex;  
        flex-direction: row;
        justify-content: space-between;
        font-size: 2px;
    }
    .add-gap{
        /** add space when mobile  */
        /** add gap between two buttons column */
        gap: 0.5rem;
        flex-direction: column;
    }
}
</style>

      
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
                                    echo "<td data-label='Billiard table'>" . $row["pool_table_number"] . "</td>";
                                    echo "<td data-label='Table number'>" . $row["table_number"] . "</td>";
                                    echo "<td data-label='Time reserved'>" . $row["time_reserved"] . "</td>";
                                    echo "<td data-label='Time started'>" . $row["time_playing"] . "</td>";
                                    echo "<td data-label='Time end'>" . $row["time_end"] . "</td>";
                                    echo "<td data-label='Status'>" . $row["status"] . "</td>";
                                    // Check if the status is 'empty', if so, hide the button
                                    if ($row["status"] !== 'empty') {
                                        echo "<td><button class='btn btn-danger  empty-btn' data-id='" . $row["pool_table_number"] . "' onclick='emptyPoolTable($row[pool_table_number])'>End Session</button></td>";
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
        <div class="mt-3 flexible-row-buttons add-gap">
            <button class="btn btn-primary" onclick="addPoolTable()">Add Another Pool Table</button>
            <button class="btn btn-danger" onclick="removePoolTable()">Remove Pool Table</button>

        </div>
        <!-- Queue List -->
        <div class="card mt-3">
            <div class="card-header">
                <h3>Queue List XX</h3>
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
                            echo "<tr><td data-label='Queue number'>" . $row["id"] . "</td><td data-label='Table number'>" . $row["table_number"] . "</td><td data-label='Time reserved'>" . $row["time"] . "</td><td data-label='Status'>" . $row["status"] . "</td>";
                            // Display "Mark as Playing" button if the status is not 'Playing'
                            if ($row["status"] !== 'Playing' && $countPlaying < 3) {
                                echo "<td ><div class='flexible-row-buttons add-gap' ><button class='btn btn-success mark-playing-btn' onclick='markQueueAsPlaying($row[id])' data-id='" . $row["id"] . "'>Playing X</button> ";
                                echo "<button class='btn btn-danger cancel-btn' data-id='" . $row["id"] . "' onclick='cancelReservation(this)'>Cancel</button></td>";
                            } else {
                                echo "</div><td></td>"; // If status is 'Playing' or maximum reached, don't show the buttons
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
        echo "<tr><td data-label='Queue number'>" . $row["id"] . "</td><td data-label='Table number'>" . $row["table_number"] . "</td><td data-label='Time reserved'>" . $row["time"] . "</td><td data-label='Status'>" . $row["status"] . "</td>";
        
        // Display "Mark as Playing" button only for the first row and when status is not 'Playing'
        if ($row["status"] !== 'Playing' && $firstRow) {
            echo "<td class='add-gap'><button class='btn btn-success mark-playing-btn' onclick='markQueueAsPlaying($row[id])' data-id='" . $row["id"] . "'>Playing </button> ";
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
