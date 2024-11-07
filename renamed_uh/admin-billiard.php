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


function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Redirect to login page if not logged in
if (!isLoggedIn()) {
    header("Location: admin-login.php");
    exit;
}


// Check if the logout button was clicked
if (isset($_POST['logout'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to login page or wherever you want
    header("Location: admin-login.php");
    exit();
}


// Fetch reservation data from pool_table_number table
$reservationSql = "SELECT * FROM pool_table_number";
$reservationResult = $conn->query($reservationSql);

// Fetch queue list
$queueSql = "SELECT * FROM pool_reserve";
$queueResult = $conn->query($queueSql);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billiard | University Hills</title>
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

        .card-header {
            background-color: #343a40; /* Dark color */
            color: #fff; /* Text color */
        }

    </style>

</head>
<body>


<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">UH ADMIN</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">MENU</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
            <a class="nav-link " href="admin-dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin-product.php">Products</a>
            </li>
            <li class="nav-item">
            <a class="nav-link active"  aria-current="page"  href="admin-billiard.php">Billiads</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin-song.php">Song</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-order.php">Orders</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-bill.php">Bills</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-history.php">History</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-sales.php">Sales</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-staff.php">Staff</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-comment.php">Comment</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-signup.php">Create Account</a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="admin-concern.php">Customer's Concerns</a>
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
      </div>
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
                <p class="bold">Welcome, Admin!</p>
            </div>
        </div>
            <div class="lii">
                <a href="admin-dashboard.php">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </div>
                
            <div class="lii">
                <a href="admin-product.php">
                        <i class="bx bxs-shopping-bag"></i>
                        <span class="nav-item">Products</span>
                </a>
                <span class="tooltip">Products</span>
            </div>

            <div class="lii">
                <a href="admin-billiard.php">
                <i class="fa-solid fa-bowling-ball"></i>
                    <span class="nav-item">Billiard</span>
                </a>
                <span class="tooltip">Billiard</span>
            </div>

            <div class="lii">
                <a href="admin-song.php">
                <i class="fa-solid fa-music"></i>
                    <span class="nav-item">Song</span>
                </a>
                <span class="tooltip">Song Request</span>
            </div>

            <div class="lii">
                <a href="admin-order.php">
                <i class="fa-solid fa-bag-shopping"></i>
                    <span class="nav-item">Order</span>
                </a>
                <span class="tooltip">Order</span>
            </div>

            <div class="lii">
                <a href="admin-bill.php">
                <i class="fa-solid fa-money-check-dollar"></i>
                    <span class="nav-item">Bills</span>
                </a>
                <span class="tooltip">Bills</span>
            </div>

            <div class="lii">
                <a href="admin-history.php">
                    <i class='bx bx-history'></i>
                    <span class="nav-item">History</span>
                </a>
                <span class="tooltip">History</span>
            </div>

            <div class="lii">
                <a href="admin-sales.php">
                    <i class="fa-solid fa-coins"></i>
                    <span class="nav-item">Sales</span>
                </a>
                <span class="tooltip">Sales</span>
            </div>
            
            <div class="lii">
                <a href="admin-staff.php">
                    <i class="fa-solid fa-user"></i>
                    <span class="nav-item">Staff</span>
                </a>
                <span class="tooltip">Staff</span>
            </div>

            <div class="lii">
                <a href="admin-comment.php">
                    <i class="fa-solid fa-comments"></i>
                    <span class="nav-item">Comment</span>
                </a>
                <span class="tooltip">Comment</span>
            </div>

            <div class="lii">
                <a href="admin-signup.php">
                    <i class="fa-solid fa-user-plus"></i>
                    <span class="nav-item">Account</span>
                </a>
                <span class="tooltip">Create Account</span>
            </div>

            <div class="lii">
                <a href="admin-concern.php">
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
            <h2 class="text-center">Billiard</h2>
                <div id="link_wrapper">



                
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
    function loadXMLDoc() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        document.getElementById("link_wrapper").innerHTML =
        this.responseText;
        }
    };
    xhttp.open("GET", "admin_billiard_server.php", true);
    xhttp.send();
    }

    setInterval(function(){
        loadXMLDoc();
    },1000);

    window.onload = loadXMLDoc;
</script>

</html>


    

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="script.js"></script>

    <script>
       // Function to add another pool table
        function addPoolTable() {
            var confirmAdd = confirm("Are you sure you want to add another pool table?");
            if (confirmAdd) {
                // Send AJAX request to add another pool table
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "add-pool-table.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Handle response
                        alert(xhr.responseText);
                        // Reload the page after adding the pool table
                        window.location.reload();
                    }
                };
                xhr.send();
            }
        }
    </script>

    <script>
    // Function to remove a pool table
    function removePoolTable() {
        var poolTableToRemove = prompt("Enter the pool table number to remove:");
        if (poolTableToRemove !== null && poolTableToRemove !== "") {
            var confirmRemove = confirm("Are you sure you want to remove pool table number " + poolTableToRemove + "?");
            if (confirmRemove) {
                // Send AJAX request to remove the pool table
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "remove-pool-table.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Handle response
                        alert(xhr.responseText);
                        // Reload the page after removing the pool table
                        window.location.reload();
                    }
                };
                xhr.send("pool_table_number=" + encodeURIComponent(poolTableToRemove));
            }
        }
    }

    </script>



    <script>
                // Function to mark a queue as playing
            function markQueueAsPlaying(queueId) {
                if (confirm("Are you sure you want to mark this queue as playing?")) {
                    // Send AJAX request to mark queue as playing and update time_playing
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "admin-billiard-mark-as-playing.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Handle response
                            alert(xhr.responseText);
                            // Reload the page after marking queue as playing
                            window.location.reload();
                        }
                    };
                    xhr.send("id=" + encodeURIComponent(queueId));
                }
            }

            // Admin side
            document.querySelectorAll(".mark-playing-btn").forEach(function(btn) {
                btn.addEventListener("click", function() {
                    var queueId = btn.getAttribute("data-id");
                    markQueueAsPlaying(queueId);
                });
            });


            // Function to empty a pool table
        function emptyPoolTable(poolTableNumber) {
            if (confirm("Are you sure you want to empty this table?")) {
                // Send AJAX request to empty the pool table
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "admin-billiard-empty-table.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Handle response
                        alert(xhr.responseText);
                        // Reload the page after emptying the table
                        window.location.reload();
                    }
                };
                xhr.send("pool_table_number=" + encodeURIComponent(poolTableNumber));
            }
        }

        // Function to create empty button HTML
        function createEmptyButton(poolTableNumber) {
            var button = document.createElement("button");
            button.textContent = "Empty";
            button.classList.add("empty-btn");
            button.setAttribute("data-id", poolTableNumber);
            
            // Add event listener to the button
            button.addEventListener("click", function() {
                emptyPoolTable(poolTableNumber);
            });

            return button;
        }

    </script>

<script>
   // Function to cancel a reservation
function cancelReservation(btn) {
    var queueId = btn.getAttribute("data-id");
    if (confirm("Are you sure you want to cancel this reservation?")) {
        // Send AJAX request to cancel reservation
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "cancel-reservation.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle response
                alert(xhr.responseText);
                // Reload the page after cancelling reservation
                window.location.reload();
            }
        };
        xhr.send("queue_id=" + encodeURIComponent(queueId));
    }
}

// Admin side - Add event listeners to cancel buttons
document.querySelectorAll(".cancel-btn").forEach(function(btn) {
    btn.addEventListener("click", function() {
        cancelReservation(btn);
    });
});

</script>

