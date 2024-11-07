<!-- Updated Table with Bootstrap Enhancements and Spacious Layout -->
<style>
    /* Custom CSS for the table */
    @media only screen and (max-width: 400px) {
        .table th {
            color: red;
            font-size: 10pt;
        }
        .table td {
            font-size: 9pt;
        }
    }

    .black{
        background-color: #F0F0F0;
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
        border-collapse: separate; /* Added for spacing */
        border-spacing: 0; /* Added for spacing */
    }

    /* Change background for table headers */
    thead {
        background-color: #007bff; /* Bootstrap primary color */
        color: white;
    }

    /* Hover effect for table rows */
    tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
        transition: background-color 0.3s ease-in-out;
    }

    /* Padding and spacing for table cells */
    tbody td {
        vertical-align: middle;
        padding: 1.5rem; /* Increased padding for spacious layout */
    }

    /* More padding for table headers */
    thead th {
        padding: 1.25rem; /* Increased padding for headers */
    }

    /* Make buttons smaller with extra margin */
    .btn-sm {
        padding: 0.5rem 1rem; /* Increase padding for buttons */
    }

    /* Space between buttons */
    .btn {
        margin-right: 0.5rem; /* Added margin between buttons */
        margin-top: 0.5rem;
    }

    /* Responsive font size for smaller screens */
    @media (max-width: 768px) {
        .table td, .table th {
            font-size: 12px;
        }
        /* Adjust button sizes */
        .btn-sm {
            padding: 0.4rem 0.8rem;
        }
    }
    th{
        color: #12171e;
    }
    
</style>

<div class=" mt-4">
    <table class="table table-bordered table-striped table-hover rounded-3 shadow-sm">
        <thead>
            <tr class="black text-white">
                <th>Queue Number</th>
                <th>Table Number</th>
                <th>Date and Time</th>
                <th>Song Request</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database connection details
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

            // Fetch song requests from the database
            $sql = "SELECT * FROM song_requests";
            $result = $conn->query($sql);

            // Check if there are any results
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr id='request_" . $row["ID"] . "'>
                            <td>" . $row["ID"] . "</td>
                            <td>" . $row["table_number"] . "</td>
                            <td>" . $row["time"] . "</td>
                            <td>" . $row["song_request"] . "</td>
                            <td>" . $row["status"] . "</td>
                            <td>";

                    // Check if the request is still pending to display Accept/Reject buttons
                    if ($row["status"] !== "In Queue" && $row["status"] !== "Rejected") {
                        echo "<button class='btn btn-success btn-sm mx-2' onclick='acceptRequest(" . $row["ID"] . ")'>Accept</button>";
                        echo "<button class='btn btn-danger btn-sm mx-2' onclick='rejectRequest(" . $row["ID"] . ")'>Reject</button>";
                    } elseif ($row["status"] == "In Queue") {
                        echo "<button class='btn btn-primary btn-sm mx-2' data-song-request='" . htmlspecialchars($row["song_request"], ENT_QUOTES) . "' onclick='confirmMarkAsDone(" . $row["ID"] . ", this)'>Done</button>";
                    }

                    echo "</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No song requests available</td></tr>";
            }

            // Close the connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<script>
    function clearAllRequests() {
        if (confirm("Are you sure you want to delete all song requests?")) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        location.reload();
                    } else {
                        console.error("Error deleting song requests: " + xhr.responseText);
                    }
                }
            };
            xhr.open("POST", "clear_requests.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("clear_all=true");
        }
    }

    function confirmMarkAsDone(requestID, button) {
        var songRequest = button.getAttribute("data-song-request");
        if (confirm("Are you sure you want to mark the song request '" + songRequest + "' as done?")) {
            markAsDone(requestID);
        }
    }

    function markAsDone(requestID) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById("request_" + requestID).remove();
                } else {
                    console.error("Failed to delete song request.");
                }
            }
        };
        xhr.open("POST", "delete_request.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("request_id=" + requestID);
    }

    function acceptRequest(requestID) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    location.reload();
                } else {
                    console.error("Failed to accept song request.");
                }
            }
        };
        xhr.open("POST", "accept_request.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("request_id=" + requestID);
    }

    function rejectRequest(requestID) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    location.reload();
                } else {
                    console.error("Failed to reject song request.");
                }
            }
        };
        xhr.open("POST", "reject_request.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("request_id=" + requestID);
    }
</script>
