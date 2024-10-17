<table class="table table-bordered table-striped">
<thead>
    <tr>
        <th>Queue Number</th>
        <th>Table Number</th>
        <th>Time</th>
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
            echo "<button class='btn btn-success' onclick='acceptRequest(" . $row["ID"] . ")'>Accept</button>";
            echo "<button class='btn btn-danger' onclick='rejectRequest(" . $row["ID"] . ")'>Reject</button>";
        } elseif ($row["status"] == "In Queue") {
            echo "<button class='btn btn-primary' data-song-request='" . htmlspecialchars($row["song_request"], ENT_QUOTES) . "' onclick='confirmMarkAsDone(" . $row["ID"] . ", this)'>Done</button>";
        }

        echo "</td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='6'>0 results</td></tr>";
}

// Close the connection
$conn->close();
?>
</tbody>
</table>

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
