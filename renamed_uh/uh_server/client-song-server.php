<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

//Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}



?>
<style>
    @media only screen and (max-width: 400px){
        .table th{
            color: red;
            font-size: 10pt;
        }
        .table td{
            font-size: 9pt;
        }
    }
</style>


    <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Queue Number</th>
            <th>Table Number</th>
           
            <th>Song Request</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch song requests from the database
        $sql = "SELECT * FROM song_requests";
        $result = $connection->query($sql);

        // Check if there are any results
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["ID"] . "</td>
                        <td>" . $row["table_number"] . "</td>
                        <td>" . $row["song_request"] . "</td>
                        <td>" . $row["status"] . "</td>
                        </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>0 results</td></tr>";
        }

        // Close the connection
        $connection->close();
        ?>
    </tbody>
</table>