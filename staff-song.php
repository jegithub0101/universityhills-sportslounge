<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

$connection = mysqli_connect($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

function isLoggedIn() {
    return isset($_SESSION['staff_user_id']);
}

if (!isLoggedIn()) {
    header("Location: staff-login.php");
    exit;
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="Pic/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/sidebar.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .main-content {
            height: 100vh;
            overflow-x: hidden;
            padding-left: 5%;
        }
        h1 {
            padding-top: 10px;
            font-size: 2rem;
        }
        .container {
            max-width: 100%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .navbar {
            display: none;
        }

	/* Extra small devices (phones, less than 576px) */
@media (max-width: 575.98px) {
    .main-content {
        padding-left: 2%; 
    }
    h1 {
        font-size: 1.5rem; 
    }
    .btn {
        width: 100%; 
    }
}

/* Small devices (tablets, 576px and up) */
@media (min-width: 576px) and (max-width: 767.98px) {
    .main-content {
        padding-left: 2%; 
    }
    h1 {
        font-size: 1.75rem; 
    }
}

/* Medium devices (desktops, 768px and up) */
@media (min-width: 768px) {
    .main-content {
        padding-left: 2%; 
    }
    h1 {
        font-size: 2rem;
    }
}

        @media only screen and (max-width: 992px) {
            .sidebar {
                display: none;
            }
            .main-content {
                top: 50px;
                left: 0;
                width: 100%;
            }
            .navbar {
                display: block;
                background-color: #12171e;
            }
            .navbar-toggler {
                height: 30px;
                padding-top: 0;
            }
            .navbar-toggler-icon {
                font-size: 8pt;
                margin-top: 0;
            }
        }
        .card-header {
            background-color: #343a40;
            color: #fff;
        }
        
        .container-fluid {
            padding: 15px; 
        }

        @media (max-width: 576px) {
            .container-fluid {
                padding: 10px; 
            }
        }

      
        .btn {
            font-size: 1em; 
        }

        @media (max-width: 768px) {
            .btn {
                font-size: 0.9em; 
            }
        }
    </style>
</head>
<body>
    <?php require 'staff-sidebar.php'; ?>
    <div class="main-content">
        <div class="container-fluid">
            <h1 class="text-center">Song Requests</h1>
            <div class="container mt-4">
                <div id="link_wrapper" class="song_container"></div>
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

    function acceptRequest(requestID) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById("request_" + requestID).remove();
                } else {
                    console.error("Failed to update song request status.");
                }
            }
        };
        xhr.open("POST", "update_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("request_id=" + requestID + "&status=In Queue");
    }

    function rejectRequest(requestID) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById("request_" + requestID).remove();
                } else {
                    console.error("Failed to update song request status.");
                }
            }
        };
        xhr.open("POST", "update_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("request_id=" + requestID + "&status=Rejected");
    }

    function loadXMLDoc() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("link_wrapper").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "uh_server/admin-song-server.php", true);
        xhttp.send();
    }

    setInterval(function(){
        loadXMLDoc();
    }, 1000);

    window.onload = loadXMLDoc;

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
</script>
</html>