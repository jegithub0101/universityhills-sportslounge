<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>

<!-- Custom CSS for the table -->
<style>
    @media only screen and (max-width: 400px) {
        .table th {
            color: red;
            font-size: 10pt;
        }
        .table td {
            font-size: 9pt;
        }
    }

    /* Add some padding for a clean look */
    .table td, .table th {
        padding: 1rem;
        vertical-align: middle;
    }

    /* Add rounded corners and a subtle shadow */
    .table {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    /* Change background for table headers */
    thead {
        background-color: #007bff;
        color: white;
    }

    /* Hover effect for table rows */
    tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }

    /* Responsive font size for smaller screens */
    @media (max-width: 768px) {
        .table td, .table th {
            font-size: 12px;
        }
    }
</style>

<!-- Bootstrap Enhanced Table -->
<div class="container mt-4">
    <table class="table table-bordered table-striped table-hover">
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
                echo "<tr><td colspan='4' class='text-center'>No song requests available</td></tr>";
            }

            // Close the connection
            $connection->close();
            ?>
        </tbody>
    </table>
</div>
