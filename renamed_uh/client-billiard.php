<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function isLoggedIn()
{
    return isset($_SESSION['table_number'] );
}

// Redirect to login page if not logged in
if (!isLoggedIn()) {
    header("Location: client-login.php");
    exit;
}

// Retrieve table_number associated with the user's session
$userTableNumber = ""; // Default value
if(isset($_SESSION["table_number"])){
    $userTableNumber = $_SESSION["table_number"];
}

// Fetch reservation data from pool_table_number table
$sql = "SELECT * FROM pool_table_number";
$reservationResult = $conn->query($sql);

// Fetch queue list
$sql = "SELECT * FROM pool_reserve";
$queueResult = $conn->query($sql);


?>

<style>
    .card-header {
        background-color: #343a40; /* Dark color */
        color: #fff; /* Text color */
    }
    @media only screen and (max-width: 450px){
        .card-title{
            font-size: 12pt;
        }
        .card-text{
            font-size: 12pt;
            margin-top: 0px;
            margin-bottom: 0px;
        }
        .table th{
            color: red;
            font-size: 11pt;
        }
        .table td{
            font-size: 9pt;
        }
        .card{
            margin-right: 2%;
        }
        
    }
    @media only screen and (max-width: 320px){
       
    }
</style>



<h2 class="text-center mt-3 mb-4">Billiard Reservation</h2>
        
        <!-- Reservation Table -->
<div class="card mt-3">
    <div class="card-header">
        <h3>Reservation Table</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <?php
            if ($reservationResult->num_rows > 0) {
                while ($row = $reservationResult->fetch_assoc()) {
                    // Determine the status color and text based on the status
                    $statusColor = $row["status"] == "empty" ? "bg-success" : "bg-danger";
                    $statusText = $row["status"] == "empty" ? "Empty" : "Occupied";
            ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Billiard Table Number: <?php echo $row["pool_table_number"]; ?></h5>
                                <p class="card-text">Playing: Table Number <?php echo $row["table_number"]; ?></p>
                                <p class="card-text">Time Reserved <?php echo $row["time_reserved"]; ?></p>
                                <p class="card-text">Time Started: <?php echo $row["time_playing"]; ?></p>
                                <p class="card-text">Time End: <?php echo $row["time_end"]; ?></p>
                                <!-- Conditional styling based on status -->
                                <p class="card-text">Status: <span class="badge <?php echo $statusColor; ?>"><?php echo $statusText; ?></span></p>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No reservations</p>";
            }
            ?>
        </div>
    </div>
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
                        <th>Action</th> <!-- Add this column for Cancel button -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($queueResult->num_rows > 0) {
                        while ($row = $queueResult->fetch_assoc()) {
                            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["table_number"] . "</td><td>" . $row["time"] . "</td><td>" . $row["status"] . "</td>";
                            // Check if the current queue item's table number matches the user's table_number
                            if ($row["table_number"] == $userTableNumber) {
                                echo "<td><button class='btn btn-danger cancel-btn' onclick='cancelReservation($row[id])'>Cancel</button></td></tr>";
                            } else {
                                echo "<td></td></tr>";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='5'>No queues</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <button id="reserve-btn" class="btn btn-primary mt-3" onclick="reservePoolTable()">Reserve</button>
        </div>
    </div>
</div>

<?php
$conn->close();
?>


