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
    <title>Dashboard</title>

    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <script src="chart.min.js"></script>
    <script src="jquery_graph.js"></script>

    <link rel="stylesheet" href="css/sidebar.css">


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
            <a class="nav-link active" aria-current="page" href="admin-dashboard.php">Dashboard</a>
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
            <a class="nav-link" href="admin-staff.php">Staff</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-comment.php">Comment</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-signup.php">Create Account</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="admin-concern.php">Customer's Concerns</a>
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
                <form action="" method="post">
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
                <form action="" method="post">
                    <button type="submit" name="logout" class="logout-button">
                        <i class='bx bx-log-out'></i>
                    </button>
                </form>
                <span class="tooltip">Logout</span>
            </div>

    </div>

 
 
    
    <style>
                            .top_prod{
                                background-color: white;
                                border-radius: 8px;
                                border:1px solid #12171e;
                                height: 230px;
                            }
                            .top_prod_graph{
                                background-color: white;
                                border-radius: 8px;
                                border:1px solid #12171e;
                                height: 400px;
                            }

                            .top_prod_comment{
                                background-color: white;
                                color: black;
                                border-radius: 8px;
                                border:1px solid #12171e;
                                height: 400px;
                                overflow: auto;
                            }

                            .crop-img{
                                background-color: pink;
                                max-width: 40%;
                                max-height: 350px;
                                overflow:hidden;
                                float: left;
                                margin: 7%;
                                margin-top: 3%;
                                margin-right: 3%;
                                border: #12171e 1px solid;
                                border-radius: 5px;
                                
                            }
                            .prod_info{
                                margin-top: 3%;
                                float: left;
                                font-size: 15pt;
                                font-weight: 600;
                            }
                            .top_image{
                                height: 150px;
                                
                            }
                            .sold{
                                
                                width: 50%;
                                margin-left: 50%;
                                text-align: center;
                                margin-top: 5%;
                            }
                            .sold > h2 {
                                margin-top: 0%;
                            }
                            .asdate, #time{
                                color: gray;
                                font-size: 15pt;
                            }
                            .top_title{
                                margin: 1%;
                                margin-left: 5%;
                            }
                            .lowstock_icon{
                                
                                height: 100%;
                                width: 30%;
                                padding-top: 7%;
                                padding-left: 3%;
                                float: left;
                                margin-right: 5%;
                              
                            }
                            .down{
                                font-size: 50pt;
                                margin-left: 15%;
                                color: red;
                            }
                            .containeritem{
                               font-size: 16pt;
                            }
                            .lowitem{
                                margin-top: 6%;
                                font-weight: 700;

                            }
                            .margintop{
                                margin-top: 6%;
                            }
                            .chartjs_bar{
                                height: 500px;
                               
                            }
                            .margin{
                                padding-left: 6%;
                                padding-right: 6%;
                            }
                        </style>
  
    <div class="main-content">
    <h1>University Hills Sports Lounge</h1>
        <div class="container-fluid margin">
            <div class="">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 margintop">
                    <div class="topproducts">
                        
                    <?php
// Fetch the top-selling product from the admin_order table
$sql_top_selling = "SELECT product_name, SUM(quantity) AS total_quantity, PID
                    FROM admin_order
                    GROUP BY product_name
                    ORDER BY total_quantity DESC
                    LIMIT 1;";

$result_top = $connection->query($sql_top_selling);

if ($result_top->num_rows > 0) {
    $row_top = $result_top->fetch_assoc();
    $top_name = $row_top['product_name'];
    $top_quantity = $row_top['total_quantity'];
    $PID = $row_top['PID']; // Get the PID

    // Fetch category, price, and image from the products table for the top-selling product using PID
    $sql_info = "SELECT DISTINCT product_name, price, image FROM products WHERE PID = '$PID' LIMIT 1;";
    $result_info = $connection->query($sql_info);

    if ($result_info->num_rows > 0) {
        $row_info = $result_info->fetch_assoc();
        $price = $row_info['price'];
        // Fetch the image blob data
        $image_blob = $row_info['image'];
        // Convert blob data to base64 for display
        $image = base64_encode($image_blob);
    } else {
        // Handle the case where the product information is not found
        // You can set default values or display an error message
        $price = 0;
        $image = ""; // Set a default image URL or leave it empty
    }

    $current_datetime = date('Y-m-d');
} else {
    // Handle the case where no top-selling product is found
    // You can set default values or display an error message
    $top_name = "Unknown";
    $top_quantity = 0;
    $category = "Unknown";
    $price = 0;
    $image = ""; // Set a default image URL or leave it empty
    $current_datetime = date('Y-m-d');
}
?>





                        <div class="top_prod">
                            <h5 class="top_title">Top Selling Product</h5>
                            <div class="crop-img"> <img class="top_image" src="data:image/jpeg;base64,<?php echo $image; ?>" alt=""></div>
                            <div class="prod_info">
                                <p class="top_name">Name: <?php echo $top_name ?></p>
                                <p class="top_price">Price: <?php echo $price ?></p>
                            </div>

                            <div class="sold">
                                <h2>Sold: <?php echo $top_quantity ?></h2>
                                <p class="asdate">As of <?php echo $current_datetime; ?></p>
                                <p id="time"></p>
                            </div>
                        </div>
                        

                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 margintop">
                <div class="topproducts">
                        
                        <div class="top_prod">
                            <div class="lowstock_icon">
                                <i class="fa-solid fa-arrow-trend-down down"></i>
                                <h3>Low Stocks</h3>
                            </div>
                            <div>
                                <?php
                                $sql_low = "SELECT * from products where stock <= 15
                                ORDER BY stock ASC
                                LIMIT 3;";
                                $result_low = $connection->query($sql_low);
                                    if ($result_low->num_rows > 0) {
                                        ?>

                                        

                                        <div class="containeritem d-flex bd-highlight lowitem">
                                            <div class="prodnameh flex-fill bd-highlight"> # </div>
                                            <div class="pquantityh flex-fill bd-highlight">Product Name </div>
                                            <div class="ppriceh flex-fill bd-highlight">Stocks</div>
                                        </div>
                                        <?php

                                        $k = 1;

                                        // Loop through each item
                                        while ($row_low = $result_low->fetch_assoc()) {
                                            ?>
                                            <div class="containeritem d-flex bd-highlight">
                                                <div class="pquantity flex-fill bd-highlight"><?php echo $k ?></div>
                                                <div class="pquantity flex-fill bd-highlight"><?php echo $row_low['product_name'] ?></div>
                                                <div class="pquantity flex-fill bd-highlight"><?php echo $row_low['stock'] ?></div>
                                            </div>
                                            
                                            <?php
                                            $k +=1;
                                        }
                                    }
                                    

                                ?>
                            </div>

                            

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                

    
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 ">
                <div class="top_prod_graph">
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
                        <canvas id="chartjs_bar" class="chartjs_bar"></canvas>
                        
                        </div>


                </div>
                <style>
                    .comment{
                        width: 50%;
                       
                        float: left;
                        height: 80px;
                        padding: 3%;
                    }
                    
                    .comment1{
                        width: 100%;
                        padding: 3%;
                        
                    }
                    .comment_name{
                        font-size: 17pt;
                        

                    }   
                    .comment_comment{
                        font-size: 12pt;
                        border-bottom: 1px solid gray;
                        margin-bottom: 2%;
                        border-top: 1px  gray; 
                        clear: left;
                        background-color: #12171e;
                        color: white;
                        margin-top: 10%;
                        padding: 1%;
                        border-radius: 10px;
                        overflow: auto;                       
                    }
                    .comment_date{
                         float:left;
                         margin-bottom: 3px;
                    }
                    .comment_rate{
                        font-size: 18pt;
                        color: black;
                    }
                    .container_comment{
                        border: 1px solid gray;
                        margin: 2%;
                        border-radius: 8px;
                        
                    }
                    .profile{
                        border-radius: 100%;
                        width: 50px;
                        float: left;
                        margin-right: 10px;
                        border: 1px solid black;
                    }
                    .fas{
                        font-size: 16pt;
                        
                    }
                </style>
                
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 ">
                    <div class="top_prod_comment">
                        <?php 
                             $sql_comment = "SELECT * FROM feedback";
                             $result_comment = $connection->query($sql_comment);
                                 if ($result_comment->num_rows > 0) {
                                    while ($row_comment = $result_comment->fetch_assoc()){
                                        ?>
                                        <div class="container_comment">
                                        <div class="comment">
                                            <img class="profile" src="Pic/user.png" alt="">
                                            <div class="comment_name"> <?php echo $row_comment['name'] ?></div>
                                        </div>
                                        <div class="comment">
                                            <div class="comment_rate">  
                                            <?php 
                                                // Get the numeric rating
                                                $rating = floatval($row_comment['rate']);
                                                
                                                // Display full stars
                                                $full_stars = floor($rating);
                                                for ($i = 0; $i < $full_stars; $i++) {
                                                    echo '<i class="fas fa-star"></i>';
                                                }
                                                
                                                // Display half star if applicable
                                                $decimal_part = $rating - $full_stars;
                                                if ($decimal_part >= 0.25 && $decimal_part <= 0.75) {
                                                    echo '<i class="fas fa-star-half-alt"></i>';
                                                }
                                                
                                                // If the decimal part is greater than 0.75, display an additional full star
                                                if ($decimal_part > 0.75) {
                                                    echo '<i class="fas fa-star"></i>';
                                                }
                                            ?>
                                            </div>
                                            <div class="comment_date"> <?php echo $row_comment['date'] ?></div>
                                           
                                        </div>
                                        <div class="comment1">
                                        <div class="comment_comment"> <?php echo $row_comment['comment'] ?></div>
                                        </div>
                                        </div>


                                            

                                        <?php
                                 }
                            }
                        ?>
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

<script>
function updateTime() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    
    // Convert hours to 12-hour format
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // Handle midnight (0 hours)
    
    // Format the time
    var timeString = padZero(hours) + ":" + padZero(minutes) + ":" + padZero(seconds) + " " + ampm;
    
    // Update the time display
    document.getElementById("time").innerText = timeString;
}

function padZero(number) {
    if (number < 10) {
        return "0" + number;
    } else {
        return number;
    }
}

// Update the time every second
setInterval(updateTime, 1000);

// Initial call to display time immediately
updateTime();
</script>


<!-- Place the canvas element -->
<canvas id="chartjs_bar"></canvas>

<script type="text/javascript">
    var ctx = document.getElementById("chartjs_bar").getContext('2d');

    
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
            pointBackgroundColor: [ // Array of colors for each dot
                "#5969ff", "#ff407b", "#25d5f2", "#ffc750", "#2ec551",
                "#7040fa", "#ff004e", "#ff66cc", "#33cccc", "#9900cc",
                "#ff6666", "#339933", "#cc3366", "#663399", "#99cc00"
            ],
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

</html>