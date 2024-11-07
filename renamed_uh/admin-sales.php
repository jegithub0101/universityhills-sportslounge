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
    <title>Sales | University Hills</title>
    <link rel="icon" href="Pic/uhicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="css/sidebar.css">

    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="chart.min.js"></script>
    <script src="jquery_graph.js"></script>

    <style>
        .main-content{
            height: 100vh;
            overflow-x: hidden;
            padding-left: 5%;
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

        .row_sales{
            background-color: #12171e;
            padding-top: 1%;
            padding-bottom: 1%;
            
        }
        .today{
            background-color: white;
            height: 150px;
            border-radius: 10px ;
        }
        .date{
            margin-top: 8%;
            text-align: center;
            font-weight: 700;
            
        }
        .title{
            text-align: center;
            margin-top: 1%;
            font-weight: 700;
        }
        .sales{
            font-size: 25pt;
            text-align: center;
        }
        .col_sales{
            background-color: #12171e;
        }
        .graphss{
            background-color: white;
            border: 1px solid #12171e;
            margin-top: 3%;
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
            <a class="nav-link active" aria-current="page" href="admin-sales.php">Sales</a>
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

    </div>

    <script>
        function confirmLogout() {
        return confirm("Are you sure you want to log out?");
        }
    </script>

    <div class="main-content">
        <div class="container-fluid">
            <div class="container">
            <h1>Sales</h1>
                <div class="row row_sales">
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 ">
                       
                        <div class="today">
                            <div class="title">Today Total Sales</div>
                        <?php 
                                $sql_today = "SELECT DATE_FORMAT(date, '%M %d, %Y') AS date, ROUND(SUM(totalprice),2) AS total_sales_today
                                FROM overall_payment
                                WHERE DATE(date) = CURDATE()
                                GROUP BY date;";
                                
                                            
                                $result_today = $connection->query($sql_today);
                                if($result_today->num_rows > 0){
                                    while ($row_today = $result_today->fetch_assoc()) {
                                        ?>
                                        <div class="date"><?php echo $row_today['date']; ?></div>
                                        <div class="sales">₱<?php echo $row_today['total_sales_today']; ?></div>
                                        <?php
                                    }
                                }
                                else{
                                    echo "No sales yet";
                                }
                            ?>
                        </div>

                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 ">
                        
                        <div class="today">
                        <div class="title">Weekly Total Sales</div>
                        <?php 
                                $sql_today = "SELECT DATE_FORMAT(date, '%M %d, %Y') AS date, ROUND(SUM(totalprice),2) AS total_sales_today
                                FROM overall_payment
                                WHERE YEARWEEK(date) = YEARWEEK(CURDATE())";
                                
                                
                                            
                                $result_today = $connection->query($sql_today);
                                if($result_today->num_rows > 0){
                                    while ($row_today = $result_today->fetch_assoc()) {
                                        ?>
                                        <div class="date"><?php echo $row_today['date']; ?></div>
                                        <div class="sales">₱<?php echo $row_today['total_sales_today']; ?></div>
                                        <?php
                                    }
                                }
                                else{
                                    echo "No sales yet";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 ">
                        
                        <div class="today">
                        <div class="title"> Monthly Total Sales</div>
                        <?php 
                                $sql_today = "SELECT MONTHNAME(date) AS date, ROUND(SUM(totalprice),2) AS total_sales_today
                                FROM overall_payment
                                WHERE YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())";
                                
                                            
                                $result_today = $connection->query($sql_today);
                                if($result_today->num_rows > 0){
                                    while ($row_today = $result_today->fetch_assoc()) {
                                        ?>
                                        <div class="date"><?php echo $row_today['date']; ?></div>
                                        <div class="sales">₱<?php echo $row_today['total_sales_today']; ?></div>
                                        <?php
                                    }
                                }
                                else{
                                    echo "No sales yet";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-3 ">
                       
                        <div class="today">
                        <div class="title">Yearly Total Sales</div>
                        <?php 
                                $sql_today = "SELECT YEAR(date) AS date, ROUND(SUM(totalprice),2) AS total_sales_today
                                FROM overall_payment
                                WHERE YEAR(date) = YEAR(CURDATE())
                                GROUP BY YEAR(date);";
                                
                                            
                                $result_today = $connection->query($sql_today);
                                if($result_today->num_rows > 0){
                                    while ($row_today = $result_today->fetch_assoc()) {
                                        ?>
                                        <div class="date"><?php echo $row_today['date']; ?></div>
                                        <div class="sales">₱<?php echo $row_today['total_sales_today']; ?></div>
                                        <?php
                                    }
                                }
                                else{
                                    echo "No sales yet";
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row graphss ">
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 ">
                        <div class="">
                        <?php 
                                // Fetch data from database
                                $sql_product_sold = "SELECT product_name, SUM(quantity) as qty  
                                FROM product_payment
                                GROUP BY pid
                                ORDER BY product_name;";
                                $result_sold = $connection->query($sql_product_sold);
        
                                // Initialize arrays to store data
                                $nameArray = [];
                                $quantityArray = [];
        
                                // Check if data is available
                                if ($result_sold->num_rows > 0) {
                                    // Loop through each row
                                    while ($row_sold = $result_sold->fetch_assoc()) {
                                        // Store date and total price in arrays
                                        $name = $row_sold['product_name'];
                                        if (!empty($name)) {
                                            $nameArray[] = $name;
                                            $quantityArray[] = $row_sold['qty'];
                                            
                                        }
                                    }
                                }
        
                                // Encode arrays to JSON
                                $nameJSON = json_encode($nameArray);
                                $quantityJSON = json_encode($quantityArray);
                            ?>
                            <canvas id="chartjs_bar_product" height="300" class="chartjs_product"></canvas>
                        </div>

                     </div>
    
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 ">
                            
                            <?php 
                                // Fetch data from database
                                $sql_sales = "SELECT MONTHNAME(date) AS date, ROUND(SUM(totalprice), 2) AS totalprice
                                FROM overall_payment
                                GROUP BY MONTH(date)
                                ORDER BY MONTH(date);";
                                $result_sales = $connection->query($sql_sales);
        
                                // Initialize arrays to store data
                                $dateArray = [];
                                $totalpriceArray = [];
        
                                // Check if data is available
                                if ($result_sales->num_rows > 0) {
                                    // Loop through each row
                                    while ($row_sales = $result_sales->fetch_assoc()) {
                                        // Store date and total price in arrays
                                        $date = $row_sales['date'];
                                        if (!empty($date)) {
                                            $dateArray[] = $date;
                                            $totalpriceArray[] = $row_sales['totalprice'];
                                        }
                                    }
                                }
        
                                // Encode arrays to JSON
                                $dateJSON = json_encode($dateArray);
                                $totalpriceJSON = json_encode($totalpriceArray);
                            ?>
                            <canvas id="chartjs_bar" height="300" class="chartjs_bar"></canvas>
                        </div>
                </div>
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



<script type="text/javascript">
    var ctx = document.getElementById("chartjs_bar").getContext('2d');


    var backgroundColors = [
    "#5969ff", "#ff407b", "#25d5f2", "#ffc750", "#2ec551",
    "#7040fa", "#ff004e", "#ff66cc", "#33cccc", "#9900cc",
    "#ff6666", "#339933", "#cc3366", "#663399", "#99cc00",
    "#009688", "#8bc34a", "#ff9800", "#673ab7", "#e91e63",
    "#795548", "#00bcd4", "#009688", "#4caf50", "#ff5722",
    "#3f51b5", "#9c27b0", "#2196f3", "#f44336", "#9e9e9e",
    "#607d8b", "#ffc107", "#cddc39", "#673ab7", "#e91e63",
    "#FFA07A", "#20B2AA", "#778899", "#FF4500", "#7CFC00",
    "#6495ED", "#FF00FF", "#008080", "#DC143C", "#6A5ACD",
    "#FF1493", "#FF6347", "#00FFFF", "#7FFFD4", "#ADFF2F",
    "#800000", "#40E0D0", "#FF8C00", "#FFD700", "#008000",
    "#B0C4DE", "#FF69B4", "#F0E68C", "#ADD8E6", "#FFA500",
    "#C71585", "#4682B4", "#B0E0E6", "#FF7F50", "#9932CC",
    "#A52A2A", "#8A2BE2", "#5F9EA0", "#DAA520", "#D2691E",
    "#8B008B", "#32CD32", "#FA8072", "#0000FF", "#00FF00",
    "#FF00FF", "#800080", "#FFDAB9", "#D8BFD8", "#4B0082",
    "#FFFF00", "#00FF7F", "#FF4500", "#87CEEB", "#FFC0CB",
    "#FFA500", "#4682B4", "#B0E0E6", "#9932CC", "#FF7F50",
    "#DAA520", "#D2691E", "#8B008B", "#32CD32", "#FA8072",
    "#0000FF", "#00FF00", "#FF00FF", "#800080", "#FFDAB9"
];

    
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo $dateJSON; ?>,
            datasets: [{
            backgroundColor: 'rgba(89, 105, 255, 0.2)',
            borderColor: '#5969ff',
            borderWidth: 3,
            data: <?php echo $totalpriceJSON; ?>,
            pointRadius: 5,
            pointHoverRadius: 8,
            tension: 0.4,
            pointBackgroundColor: backgroundColors,
            pointBorderColor: 'rgba(0, 0, 0, 0.1)', 
            }],
           
        },
        options: {
            title: {
                display: true,
                text: 'SALES PER MONTH', // Your title here
                fontSize: 26,
                fontColor: '#12171e',
                fontFamily: 'Circular Std Book',
                fontStyle: 'normal',
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#71748d',
                    fontFamily: 'Circular Std Book',
                    fontSize: 14,
                }
            }
        }
    });
</script>



<script type="text/javascript">
    var ctx = document.getElementById("chartjs_bar_product").getContext('2d');



    var backgroundColors = [
    "#5969ff", "#ff407b", "#25d5f2", "#ffc750", "#2ec551",
    "#7040fa", "#ff004e", "#ff66cc", "#33cccc", "#9900cc",
    "#ff6666", "#339933", "#cc3366", "#663399", "#99cc00",
    "#009688", "#8bc34a", "#ff9800", "#673ab7", "#e91e63",
    "#795548", "#00bcd4", "#009688", "#4caf50", "#ff5722",
    "#3f51b5", "#9c27b0", "#2196f3", "#f44336", "#9e9e9e",
    "#607d8b", "#ffc107", "#cddc39", "#673ab7", "#e91e63",
    "#FFA07A", "#20B2AA", "#778899", "#FF4500", "#7CFC00",
    "#6495ED", "#FF00FF", "#008080", "#DC143C", "#6A5ACD",
    "#FF1493", "#FF6347", "#00FFFF", "#7FFFD4", "#ADFF2F",
    "#800000", "#40E0D0", "#FF8C00", "#FFD700", "#008000",
    "#B0C4DE", "#FF69B4", "#F0E68C", "#ADD8E6", "#FFA500",
    "#C71585", "#4682B4", "#B0E0E6", "#FF7F50", "#9932CC",
    "#A52A2A", "#8A2BE2", "#5F9EA0", "#DAA520", "#D2691E",
    "#8B008B", "#32CD32", "#FA8072", "#0000FF", "#00FF00",
    "#FF00FF", "#800080", "#FFDAB9", "#D8BFD8", "#4B0082",
    "#FFFF00", "#00FF7F", "#FF4500", "#87CEEB", "#FFC0CB",
    "#FFA500", "#4682B4", "#B0E0E6", "#9932CC", "#FF7F50",
    "#DAA520", "#D2691E", "#8B008B", "#32CD32", "#FA8072",
    "#0000FF", "#00FF00", "#FF00FF", "#800080", "#FFDAB9"
];
   

    
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo $nameJSON; ?>,
            datasets: [{
                backgroundColor: backgroundColors,
                data: <?php echo $quantityJSON; ?>,
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Unit Sales', // Your title here
                fontSize: 26,
                fontColor: '#12171e',
                fontFamily: 'Circular Std Book',
                fontStyle: 'normal',
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#71748d',
                    fontFamily: 'Circular Std Book',
                    fontSize: 14,
                }
            }
        }
    });
</script>


</html>