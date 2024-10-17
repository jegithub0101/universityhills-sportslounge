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




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History | University Hills</title>
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
        

<style>
    /* Add custom styles here */
    body {
      background-color: #f8f9fa; /* Set background color */
    }
    .container {
      max-width: 800px; /* Set maximum width for content */
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
            <a class="nav-link" href="admin-dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin-product.php">Products</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin-billiard.php">Billiads</a>
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
            <a class="nav-link active"  aria-current="page"  href="admin-history.php">History</a>
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
<div class="container mt-5">
    <h2>Admin History</h2>
    <div class="mb-3">
        <!-- Add a select field for sorting by date -->
        <label for="sortDate">Sort by Date:</label>
        <input type="date" id="sortDate" name="sortDate">
        <button class="btn btn-primary" id="sortBtn">Sort</button>
        <button class="btn btn-success" id="showAllBtn">Show All</button>
        
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Payment Tracking No</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody id="tableBody">
            <!-- Records will be displayed here -->
            </tbody>
        </table>
    </div>
    <button class="btn btn-danger" id="clearTableBtn">Clear All</button>
</div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Fetch records using AJAX
    $(document).ready(function(){
        fetchRecords(); // Initial fetch

        // Clear table button click event
        $('#clearTableBtn').click(function(){
            if(confirm('Are you sure you want to clear the table?')){
                // Call clear_records.php to delete records
                $.ajax({
                    url: 'clear_records.php',
                    type: 'POST',
                    success: function(response){
                        // Clear table after successful deletion
                        $('#tableBody').empty();
                        alert(response); // Show success message
                    },
                    error: function(xhr, status, error){
                        console.error(xhr.responseText);
                        alert('Error deleting records'); // Show error message
                    }
                });
            }
        });

        // Function to fetch records
        function fetchRecords() {
            $.ajax({
                url: 'fetch_records.php', // PHP script to fetch records from database
                type: 'GET',
                dataType: 'json',
                success: function(response){
                    if(response && response.length > 0) {
                        // Populate table with fetched records
                        $.each(response, function(index, record) {
                            $('#tableBody').append(
                                '<tr>' +
                                '<td>' + record.payment_trackingno + '</td>' +
                                '<td>' + record.pid + '</td>' +
                                '<td>' + record.product_name + '</td>' +
                                '<td>' + record.quantity + '</td>' +
                                '<td>' + record.date + '</td>' +
                                '</tr>'
                            );
                        });
                    } else {
                        $('#tableBody').html('<tr><td colspan="5">No records found</td></tr>');
                    }
                },
                error: function(xhr, status, error){
                    console.error(xhr.responseText);
                    $('#tableBody').html('<tr><td colspan="5">Error fetching records</td></tr>');
                }
            });
        }
    });
</script>

<script>
    // Add event listener to the sort button
$('#sortBtn').click(function(){
    // Retrieve the selected date
    var sortDate = $('#sortDate').val();

    // Send AJAX request to fetch sorted records
    $.ajax({
        url: 'fetch_records.php', // Modify URL as needed
        type: 'GET',
        data: { sortDate: sortDate }, // Pass selected date as parameter
        dataType: 'json',
        success: function(response){
            // Clear existing table rows
            $('#tableBody').empty();

            // Populate table with sorted records
            $.each(response, function(index, record) {
                $('#tableBody').append(
                    '<tr>' +
                    '<td>' + record.payment_trackingno + '</td>' +
                    '<td>' + record.pid + '</td>' +
                    '<td>' + record.product_name + '</td>' +
                    '<td>' + record.quantity + '</td>' +
                    '<td>' + record.date + '</td>' +
                    '</tr>'
                );
            });
        },
        error: function(xhr, status, error){
            console.error(xhr.responseText);
            $('#tableBody').html('<tr><td colspan="5">Error fetching sorted records</td></tr>');
        }
    });
});

</script>

<script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function () {
        sidebar.classList.toggle('active');
    };
</script>

<script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function () {
        sidebar.classList.toggle('active');
    };
</script>

<script>
    // Add event listener to the show all button
$('#showAllBtn').click(function(){
    // Send AJAX request to fetch all records
    $.ajax({
        url: 'fetch_records.php',
        type: 'GET',
        dataType: 'json',
        success: function(response){
            // Clear existing table rows
            $('#tableBody').empty();

            // Populate table with all records
            $.each(response, function(index, record) {
                $('#tableBody').append(
                    '<tr>' +
                    '<td>' + record.payment_trackingno + '</td>' +
                    '<td>' + record.pid + '</td>' +
                    '<td>' + record.product_name + '</td>' +
                    '<td>' + record.quantity + '</td>' +
                    '<td>' + record.date + '</td>' +
                    '</tr>'
                );
            });
        },
        error: function(xhr, status, error){
            console.error(xhr.responseText);
            $('#tableBody').html('<tr><td colspan="5">Error fetching records</td></tr>');
        }
    });
});

</script>
</html>