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
function isLoggedIn()
{
    return isset($_SESSION['table_number'] );
}

// Redirect to login page if not logged in
if (!isLoggedIn()) {
    header("Location: client-login.php");
    exit;
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
        .nickname{
            border-bottom: 2px solid white;
            margin-bottom: 3%;
            padding-left: 25%;
            padding-right: 5%;
            padding-bottom: 12%;
        }
        .sidebar.active .user .bold{
            border: none;
        }
    </style>

</head>
<body>
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
                <p class="bold">Welcome, Table <?php echo $_SESSION['table_number']; ?></p>
                <p class="nickname"> <?php echo $_SESSION['table_name']; ?></p>
            </div>
        </div>
                
            <div class="lii">
                <a href="client-product.php">
                        <i class="bx bxs-shopping-bag"></i>
                        <span class="nav-item">Products</span>
                </a>
                <span class="tooltip">Products</span>
            </div>

            <div class="lii">
                <a href="client-billiard.php">
                <i class="fa-solid fa-bowling-ball"></i>
                    <span class="nav-item">Billiard</span>
                </a>
                <span class="tooltip">Billiard</span>
            </div>

            <div class="lii">
                <a href="client-song.php">
                <i class="fa-solid fa-music"></i>
                    <span class="nav-item">Song</span>
                </a>
                <span class="tooltip">Song Request</span>
            </div>


            <div class="lii">
                <a href="client-cart.php">
                <i class="bi bi-cart"></i>
                    <span class="nav-item">Cart</span>
                </a>
                <span class="tooltip">Your Cart</span>
            </div>


            <div class="lii">
                <a href="client-commment.php">
                    <i class="fa-solid fa-comments"></i>
                    <span class="nav-item">Comment</span>
                </a>
                <span class="tooltip">Comment</span>
            </div>


    </div>
  
    <div class="main-content">
        <div class="container-fluid">
            <h1>University Hills Sport Lounge</h1>
        </div>

        <form id="songform" method="POST" action="">
            <div class="form-group divsong">
                <input type="text" class="form-control inputsong" id="songrequest" placeholder="Request Song" name="songrequest" maxlength="100" required>
                <button type="submit" class="btn btn-primary" id="savesongBtn">Request</button>
            </div>
        </form>

        <div id="link_wrapper">
        <h2 class="text-center">Song Requests</h2>




        
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
        // Your existing script for sidebar toggle

        // Function to load content using AJAX
        function loadContent(url) {
            let xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.querySelector('.main-content').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
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
        xhttp.open("GET", "uh_server/client-song-server.php", true);
        xhttp.send();
        }

        setInterval(function(){
            loadXMLDoc();
        },1000);

        window.onload = loadXMLDoc;
    </script>



<script>

    // Function to handle song request submission
    document.getElementById("songform").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent form submission

        // Get song request data
        var songRequest = document.getElementById("songrequest").value;

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Define the request parameters
        xhr.open("POST", "insert_song_request.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Define callback function for when the request is complete
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Song request submitted successfully
                    console.log("Song request submitted successfully");
                    // You can add any additional actions here
                } else {
                    // Error submitting song request
                    console.error("Error submitting song request: " + xhr.responseText);
                }
            }
        };

        // Send the request with the song request data
        xhr.send("songrequest=" + encodeURIComponent(songRequest));
        document.getElementById("songrequest").value = ""; 
    });
</script>
</html>
