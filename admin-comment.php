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


// Retrieve feedback data
$query = "SELECT * FROM feedback";
$result = mysqli_query($connection, $query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks | University Hills</title>
    <link rel="icon" href="Pic/uhicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">


    <link rel="stylesheet" href="css/sidebar.css">


        <style>
            .main-content{
                height: 100vh;
                overflow-x: hidden;
                padding-left: 5%;
            }

    .mesa{
     
    width: 100%;
    margin-bottom: 1rem;
    background-color: white;
    border-collapse: collapse;
    }

            /* For table-bordered */
.table-bordered {
    border: 2px solid #343a40; /* Dark border for the table */
    border-radius: 5px; /* Rounded corners */
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #dee2e6; /* Standard border between cells */
    padding: 12px; /* More padding for better readability */
}

/* For table-striped */
.table-wipe tbody tr:nth-of-type(odd) {
    background-color: #f2f2f2; /* Light gray background for odd rows */
}

/* Custom hover effect for table rows */
.table-wipe tbody tr:hover {
    background-color: #e9ecef; /* Light gray hover effect */
    cursor: pointer;
}

/* Header styling */
.table-bordered thead th {
     /* Dark background for headers */
     /* White text in headers */
    text-align: center; /* Centered header text */
    font-weight: bold;
}

/* Optional: Change the font style */
.table-bordered {
    font-size: 14px; /* Font size */
}

            .main-content{
                position: relative;
                background-color: #eee;
            
                top:0;
                left:80px;
                transition: all 0.5s ease;
                width: calc(100% - 80px);
                padding: 1rem;
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

                .main-content{
                    position: relative;
                    background-color: #eee;
                    min-height: 100vh;
                    top:0;
                    left:80px;
                    transition: all 0.5s ease;
                    width: calc(100% - 80px);
                    padding: 1rem;
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

                    }

                        .table thead th,
                        .table tbody td {
                    background-color: beige;
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
            <a class="nav-link "  href="admin-dashboard.php">Dashboard</a>
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
            <a class="nav-link" href="admin-history.php">History</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-sales.php">Sales</a>
            </li>

            <li class="nav-item">
            <a class="nav-link "  href="admin-staff.php">Staff</a>
            </li>

            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="admin-comment.php">Comment</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-signup.php">Create Account</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="admin-concern.php">Customer's Concerns</a>
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

            <script>
                function confirmLogout() {
                return confirm("Are you sure you want to log out?");
                }
            </script>

    </div>

 
            <div class="main-content">
            <div class="container-fluid">
                <h1>Feedbacks</h1>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                        <input type="text" id="searchInput" class="form-control dark" placeholder="Search..." onkeypress="handleKeyPress(event)">
                            <button class="btn btn-outline-dark" type="button" onclick="searchFeedback()"><i class="fas fa-search"></i> Search</button>
                            
                        </div>
                    </div>

                <div class="col-md-6 text-end">
                <button class="btn btn-outline-dark" type="button" onclick="refreshList()"><i class="fas fa-sync-alt"></i> </button>
                <button class="btn btn-outline-dark dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">Filter Feedback</button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
        <li><a class="dropdown-item" href="#" onclick="showAll()">Show All</a></li>
        <li><a class="dropdown-item" href="#" onclick="filterFeedback(5)">⭐⭐⭐⭐⭐</a></li>
        <li><a class="dropdown-item" href="#" onclick="filterFeedback(4)">⭐⭐⭐⭐</a></li>
        <li><a class="dropdown-item" href="#" onclick="filterFeedback(3)">⭐⭐⭐</a></li>
        <li><a class="dropdown-item" href="#" onclick="filterFeedback(2)">⭐⭐</a></li>
        <li><a class="dropdown-item" href="#" onclick="filterFeedback(1)">⭐</a></li>
    </ul>   
            </div>
                </div>

                <table id="feedbackTable" class="mesa table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            $sql = "SELECT * FROM feedback";
                            $result = mysqli_query($connection, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>{$row['name']}</td>";
                                    $rate = $row['rate'];
                                    $ratingRange = '';
                                    if ($rate >= 0.1 && $rate <= 1.4) {
                                        $ratingRange = 'Poor';
                                    } else if ($rate >= 1.5 && $rate <= 2.4) {
                                        $ratingRange = 'Unsatisfactory';
                                    } else if ($rate >= 2.5 && $rate <= 3.4) {
                                        $ratingRange = 'Satisfactory';
                                    } else if ($rate >= 3.5 && $rate <= 4.4) {
                                        $ratingRange = 'Very Satisfactory';
                                    } else if ($rate >= 4.5 && $rate <= 5.0) {
                                        $ratingRange = 'Outstanding';
                                    }
                                    echo "<td>{$ratingRange}</td>"; // Display the rating range instead of the raw rating value
                                    echo "<td>{$row['comment']}</td>";
                                    echo "<td>{$row['date']}</td>";
                                    echo "<td>{$row['time']}</td>";
                                    echo "</tr>";

                                }
                            } else {
                                echo "<tr><td colspan='5'>No feedback found</td></tr>";
                            }
                            ?>
                    </tbody>
                </table>

                <div id="noResults" style="display: none; text-align: center;">
                    <img src="Pic/empty.svg" alt="Not Found" style="max-width: 100%;">
                    <p>No results found</p>
                </div>
            </div>
        </div>

                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['rate']; ?></td>
                        <td><?php echo $row['comment']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['time']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
<script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function () {
        sidebar.classList.toggle('active');
    };

    function showAll() {
    document.getElementById('searchInput').value = '';
    window.location.reload();
}

    function searchFeedback() {
        let searchQuery = document.getElementById('searchInput').value.toLowerCase();
        let table = document.getElementById('feedbackTable');
        let noResultsDiv = document.getElementById('noResults');

        let rows = table.getElementsByTagName('tr');
        let found = false;

        for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
            let cols = rows[i].getElementsByTagName('td');
            let match = false;

            for (let j = 0; j < cols.length; j++) {
                let text = cols[j].innerText.toLowerCase();
                if (text.includes(searchQuery)) {
                    match = true;
                    break;
                }
            }

            if (match) {
                rows[i].style.display = '';
                found = true;
            } else {
                rows[i].style.display = 'none';
            }
        }

        if (found) {
            table.style.display = '';
            noResultsDiv.style.display = 'none';
        } else {
            table.style.display = 'none';
            noResultsDiv.style.display = '';
        }
    }

    function clearSearch() {
        document.getElementById('searchInput').value = '';
        document.getElementById('feedbackTable').style.display = '';
        document.getElementById('noResults').style.display = 'none';
        
    }
    function handleKeyPress(event) {
        if (event.keyCode === 13) { // Check if Enter key was pressed
            searchFeedback(); // Call search function
        }
    }
    
    function filterFeedback(rating) {
        let table = document.getElementById('feedbackTable');
        let rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
            let cols = rows[i].getElementsByTagName('td');
            let rowRating = parseFloat(cols[1].innerText); // Assuming the rate is in the second column (index 1)

            // Determine the rating range based on the selected rating
            let ratingRange = '';
            if (rating >= 0.1 && rating <= 1.4) {
                ratingRange = 'Poor';
            } else if (rating >= 1.5 && rating <= 2.4) {
                ratingRange = 'Unsatisfactory';
            } else if (rating >= 2.5 && rating <= 3.4) {
                ratingRange = 'Satisfactory';
            } else if (rating >= 3.5 && rating <= 4.4) {
                ratingRange = 'Very Satisfactory';
            } else if (rating >= 4.5 && rating <= 5.0) {
                ratingRange = 'Outstanding';
            }

            // Show/hide rows based on the selected rating range
            if (ratingRange === cols[1].innerText) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }

</script>

</html>