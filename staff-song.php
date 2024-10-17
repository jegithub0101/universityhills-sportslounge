<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}


// Function to check if a user is logged in
function isLoggedIn()
{
    return isset($_SESSION['staff_user_id']);
}

// Redirect to login page if not logged in
if (!isLoggedIn()) {
    header("Location: staff-login.php");
    exit;
}

// Check if the logout button was clicked
if (isset($_POST['logout'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to login page or wherever you want
    header("Location: staff-login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Song Requests | University Hills</title>
    <link rel="icon" href="Pic/uhicon.png" type="image/x-icon" />

    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="css/sidebar.css">

    <style>
        .main-content{
            height: 100vh;
            overflow-x: hidden;
            padding-left: 5%;
        }
        .x{
            padding-top: 0;
        }
        h1{
            padding-top: 10px;
        }
        
    </style>

    <style>

        .navbar{
            display:none
        }
        @media only screen and (max-width: 992px) {
            .sidebar{
                display: none;
            }

            .main-content{
            top:50px;
            left:0px;
            width: 100%;
            }

            .navbar{
                display: block;
                background-color: #12171e;
            }

        }

        .card-header {
            background-color: #343a40; /* Dark color */
            color: #fff; /* Text color */
        }
        .navbar{
                display:none
            }
        @media only screen and (max-width: 992px) {
            .sidebar{
                display: none;
            }

            .main-content{
            top:50px;
            left:0px;
            width: 100%;
            }

            .navbar{
                display: block;
                background-color: #12171e;
            }
            .navbar-toggler{
                height: 30px;
                padding-top: 0px;
            }
            .navbar-toggler-icon{
                font-size: 8pt;
                margin-top: 0px;
            }
        }

    </style>
    
<body>


<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">UH STAFF</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                    <a class="nav-link "  href="staff-orders.php">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="staff-bills.php">Bills</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="staff-billiard.php">Billiards</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="staff-song.php">Song</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="staff-assist.php">Assist</a>
                </li>

                <li class="nav-item">
                <a class="nav-link" href="staff-concern.php">Customer's Concerns</a>
                </li>


                <style>
                .navlogout{
                    
                    width:20%;
                    background-color: white;
                    color: black;
                    border-radius: 10px;
                }
            </style>

            <div class="lii">
                <form action="" method="post" onsubmit="return confirmLogout()">
                    <button type="submit" name="logout" class="logout-button navlogout">
                        <i class='bx bx-log-out'></i>
                    </button>
                </form>
            </div>

            </ul>
        </div>
    </div>
    </nav>
 
<div class="sidebar">
        <div class="top">
            <i class="bx bx-menu" id="btn"></i>
        </div>
        
        <div class="user">
            <img src="Pic/logo.png" alt="me" class="user-img">
            <div class="logo">
                <span>University Hills</span>
            </div>
            <div>
                <p class="bold">Welcome, Staff!</p>
            </div>
        </div>
                
            <div class="lii">
                <a href="staff-orders.php">
                <i class="fa-solid fa-bag-shopping"></i>
                    <span class="nav-item">Orders</span>
                </a>
                <span class="tooltip">Orders</span>
            </div>

            <div class="lii">
                <a href="staff-bills.php">
                <i class="fa-solid fa-money-check-dollar"></i>
                    <span class="nav-item">Bills</span>
                </a>
                <span class="tooltip">Bills</span>
            </div>

            <div class="lii">
                <a href="staff-billiard.php">
                <i class="fa-solid fa-bowling-ball"></i>
                    <span class="nav-item">Billiard</span>
                </a>
                <span class="tooltip">Billiard</span>
            </div>

            <div class="lii">
                <a href="staff-song.php">
                <i class="fa-solid fa-music"></i>
                    <span class="nav-item">Song</span>
                </a>
                <span class="tooltip">Song Request</span>
            </div>

            <div class="lii">
                <a href="staff-assist.php">
                <i class="fa-solid fa-hands-helping"></i>
                    <span class="nav-item">Assist</span>
                </a>
                <span class="tooltip">Staff-Assist </span>
            </div>

            <div class="lii">
                <a href="staff-concern.php">
                <i class="fa-solid fa-exclamation-triangle"></i>
                    <span class="nav-item">Concerns</span>
                </a>
                <span class="tooltip">Customer's Concerns</span>
            </div>

            
            <div class="lii">
            <form action="" method="post" onsubmit="return confirmLogout()">
                <button type="submit" name="logout" class="logout-button">
                <i class='bx bx-log-out'></i>
                </button>
            </form>
            <span class="tooltip">Logout</span>
            </div>

    </div>
    
            <script>
        function confirmLogout() {
        return confirm("Are you sure you want to log out?");
        }
        </script>
  
    <div class="main-content">
        <div class="container-fluid">
            <!-- <h1>University Hills Sport Louge</h1> -->
            <h1 class="text-center">Song Requests</h1>
            <div class="container">
                <div id="link_wrapper" class="song_container">



                </div>
                <!-- Button to clear all song requests -->
                <button class="btn btn-danger" onclick="clearAllRequests()">Clear All</button>
            </div>
        </div>  
    </div>
</body>

<script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function () {
        sidebar.classList.toggle('active');
    };
</script>

<script>
    function acceptRequest(requestID) {
        // Send an AJAX request to update the status of the song request
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Update the UI if the request was successful
                    document.getElementById("request_" + requestID).remove(); // Remove the accepted request from the admin view
                } else {
                    // Handle errors if any
                    console.error("Failed to update song request status.");
                }
            }
        };
        xhr.open("POST", "update_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("request_id=" + requestID + "&status=In Queue");
    }
</script>

<script>
    function rejectRequest(requestID) {
        // Send an AJAX request to update the status of the song request to "Rejected"
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Update the UI if the request was successful
                    document.getElementById("request_" + requestID).remove(); // Remove the rejected request from the admin view
                } else {
                    // Handle errors if any
                    console.error("Failed to update song request status.");
                }
            }
        };
        xhr.open("POST", "update_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("request_id=" + requestID + "&status=Rejected");
    }
</script>



<script>
function loadXMLDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("link_wrapper").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "uh_server/admin-song-server.php", true);
  xhttp.send();
}

setInterval(function(){
    loadXMLDoc();
},1000);

window.onload = loadXMLDoc;
</script>

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
</script>

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

</html>