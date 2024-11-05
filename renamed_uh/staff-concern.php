<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

//Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);


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
    <title>Concerns | University Hills</title>
    <link rel="icon" href="Pic/uhicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="css/sidebar.css">


    <style>


        .clearbtn {
            float: right;
            margin-bottom: 1%;
        }

    </style>

    <style>

.uhlogo img {
            width: 20%;
        }

        .container {
            padding: 0% 0% 0% 10%;
        }
        
        .card {
            margin: 0% 5% 0% 5%;
        }

        .navbar{
            display:none
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

            .table-margin {
            padding-top: 5%;
            margin:2%;
        }
        }
        .prodimg{
            max-width: 120px;
        }
        .main-content{
            height: 100vh;
            overflow-x: hidden;
            padding-left: 1%;
            padding-right: 1%;
        }
        .whitcontainer{
                
                margin-left: 0%;
                margin-right: 0%;
                padding: 0%;
            
                background-color: white;
                width: 100%;
                height: 850px;
                overflow-x:hidden;
                border-radius:15px ;
                position: relative;
            }
            .placeorder{
                position: absolute;
                bottom: 0px;
                height: 12%;
                width: 98%;
                background-color: #12171e;
            }
            .btnorder{
                position: absolute;
                right: 50px;
                bottom: 30px;

            }
            .total{
                color: white;
                text-align: center;
                margin-top: 1%;
                font-size: 30pt;
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

            .container {
            padding: 5% 0% 0% 0%;
            }

        }

        @media only screen and (min-width: 1200px) {
            .container {
            padding: 5% 0% 0% 10%;
            }

            
        } 

    </style>
</head>
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
                    <a class="nav-link " href="staff-orders.php">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="staff-bills.php">Bills</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="staff-billiard.php">Billiards</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="staff-song.php">Song</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link " href="staff-assist.php">Assist</a>
                </li>

                <li class="nav-item">
                <a class="nav-link active"  aria-current="page" href="staff-concern.php">Customer's Concerns</a>
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

    <div class="container">
        <div class="table-margin">
        <h1 class="mt-4">Concerns</h1>

        <div class="clearbtn">
        <button class="btn btn-danger" id="clear-all-btn">Clear All</button>
        </div>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Date and Time</th>
                    <th>Table Number</th>
                    <th>Concern</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                    // Connect to the database
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "university_hills";


                    $conn = new mysqli($servername, $username, $password, $database);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch data from the database
                    $sql = "SELECT * FROM concerns";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            // Format the date and time
                            $formatted_date_time = date("M j, Y g:ia", strtotime($row["date_time"]));
                            
                            echo "<tr>";
                            echo "<td>" . $formatted_date_time . "</td>";
                            echo "<td>" . $row["table_number"] . "</td>";
                            echo "<td>" . $row["concern"] . "</td>";
                            echo "<td><button class='btn btn-primary done-btn' data-cid='" . $row["CID"] . "'>Done</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No concerns found.</td></tr>";
                    }

                    $conn->close();
                    ?>
            </tbody>
        </table>
        </div>
        

    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        $(document).ready(function() {
            // Remove button click event
            $(document).on('click', '.done-btn', function() {
                var cid = $(this).data('cid');
                var confirmRemove = confirm("Are you sure you want to remove this concern?");
                if (confirmRemove) {
                    removeConcern(cid);
                }
            });

            // Clear All button click event
            $('#clear-all-btn').click(function() {
                var confirmClearAll = confirm("Are you sure you want to clear all concerns?");
                if (confirmClearAll) {
                    clearAllConcerns();
                }
            });

            function removeConcern(cid) {
                $.ajax({
                    url: 'admin-concern-remove.php',
                    type: 'POST',
                    data: {cid: cid},
                    success: function(response) {
                        // alert(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function clearAllConcerns() {
                $.ajax({
                    url: 'admin-concern-clear.php',
                    type: 'POST',
                    success: function(response) {
                        // alert(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
    </script>

<script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function () {
        sidebar.classList.toggle('active');
    };
</script>



</body>
</html>