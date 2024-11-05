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
                <td>";

        // Check the status
        if ($row["status"] == "In Queue") {
            echo $row["status"];
        } elseif ($row["status"] == "Rejected") {
            echo $row["status"];
        } else {
            echo "<button class='btn btn-success' onclick='acceptRequest(" . $row["ID"] . ")'>Accept</button>";
            echo "<button class='btn btn-danger' onclick='rejectRequest(" . $row["ID"] . ")'>Reject</button>";
        }

        echo "</td>
                <td>";

        // Add the "Done" button for "In Queue" status
        if ($row["status"] == "In Queue") {
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

<!-- Button to clear all song requests -->
<button class="btn btn-danger" onclick="clearAllRequests()">Clear All</button>

<script>
function clearAllRequests() {
    if (confirm("Are you sure you want to delete all song requests?")) {
        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Define the function to handle the response
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Reload the page after successful deletion
                    location.reload();
                } else {
                    // Handle errors here
                    console.error("Error deleting song requests: " + xhr.responseText);
                }
            }
        };

        // Open the connection
        xhr.open("POST", "clear_requests.php", true);

        // Set the content type header
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Send the request with the parameter indicating to clear all song requests
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
    // Send an AJAX request to delete the song request
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Update the UI if the request was successful
                document.getElementById("request_" + requestID).remove(); // Remove the completed request from the admin view
            } else {
                // Handle errors if any
                console.error("Failed to delete song request.");
            }
        }
    };
    xhr.open("POST", "delete_request.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("request_id=" + requestID);
}
</script>