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

    <link rel="stylesheet" href="css/sidebar.css">

    <style>
         
        .navbar{
            display:none
        }
        .main-content{
            height: 100vh;
            overflow-x: hidden;
            padding-left: 1%;
            padding-right: 1%;
        }

        .cards{
            float: left;
            margin-left: 2.5%;
            margin-top: 2.5%;
            overflow-x: none;
           
        }
        .card-body{
            min-height: 350px;
            max-height: 350px;
            overflow-y: auto;
            position: relative;
            padding-top: 4% ;
            color: red;
            
        }
        .pname{
           
            float: left;
            left: 0px;
            margin-right: 40px;
            width: 50%;
        }
        .pqty{
            
            right: 0px;
        }
        .btnaccept,.btndelete{
            position: absolute;

        }
        .btnaccept{
            right: 70px;
        }
        .btndelete{
            right: 10px;
        }
        .card-title{
            margin-bottom: 10%;
            width: 100%;
            
        }
        .donebtn{
            position: absolute;
            bottom: 0px;
            width: 100%;
            left: 0px;
        }
        .donebtn {
            display: none;
        }

        .donebtn1{
            position: absolute;
            bottom: 0px;
            width: 100%;
            left: 0px;
        }

        .hide{
            display: none;
        }
        @media only screen and (max-width: 1300px) {
        .cards{
            float: left;
            margin-left: 4.5%;
        }
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
        .pquantity{
            width: 23%;
            color: gray;
           
            
            
        }
        .ptitle{
            font-weight: 600;
            color: black;
           
        }
    </style>

</head>
<body>

    <nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Offcanvas dark navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Dark offcanvas</h5>
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
                <a class="nav-link" href="#">Logout</a>
                </li>
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
                <a href="staff-cart.php">
                <i class="fa-solid fa-cart-plus"></i>
                    <span class="nav-item">Cart</span>
                </a>
                <span class="tooltip">Cart </span>
            </div>

            <div class="lii">
                <a href="staff-logout.php">
                <i class='bx bx-log-out' ></i>
                    <span class="nav-item">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
            </div>

    </div>


    <div class="main-content">
    <div class="container-fluid">
        <div class="container">
            <h1>University Sport Louge</h1>
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <div class="cards">
                    <?php $total_amount = 0; ?>
            
             
               
                <?php
                    $sql_monitor_cid = "SELECT DISTINCT cid, table_number FROM admin_order WHERE  status = 'Done'";
                    $result_monitor_cid = $connection->query($sql_monitor_cid);

                  

                    if ($result_monitor_cid->num_rows > 0) {
                        // Loop through cid
                        while ($row_cid = $result_monitor_cid->fetch_assoc()) {
                            $cid_user = $row_cid['cid'];
                            $table_number = $row_cid['table_number'];
                            ?>
                             <h3 class="title">ORDERS OF TABLE <?php echo $table_number ?></h3>
                            <?php

                            $sql_monitor_name = "SELECT nickname FROM customer WHERE cid=$cid_user";
                            $result_monitor_name = $connection->query($sql_monitor_name);
                            $row_monitor_name = $result_monitor_name->fetch_assoc();

                            //echo $cid_user;
                            ?>
                            <div class="name lead"><?php echo $row_monitor_name['nickname']; ?></div>

                            <div class="containeritem d-flex bd-highlight">
                                <div class="prodnameh flex-fill bd-highlight"> NAME </div>
                                <div class="pquantityh flex-fill bd-highlight"> QTY </div>
                                <div class="ppriceh flex-fill bd-highlight">PRICE</div>
                                <div class="pstotalh flex-fill bd-highlight">SUBTOTAL</div>
                                <div class="prodstatush flex-fill bd-highlight">STATUS</div>
                            </div>

                            <?php
                            $sql_monitor = "SELECT DISTINCT tracking_no FROM admin_order WHERE table_number = $table_number AND cid=$cid_user";
                            $result_monitor = $connection->query($sql_monitor);
                            if ($result_monitor->num_rows > 0) {
                                
                                // Loop through each tracking number
                                while ($row = $result_monitor->fetch_assoc()) {
                                    $tracking = $row['tracking_no'];

                                            //count of tracking order
                                    $sql_cancelled_preparing = "SELECT * FROM admin_order WHERE cid=$cid_user AND tracking_no = '$tracking' AND table_number = $table_number";
                                    $result_can_pre = $connection->query($sql_cancelled_preparing);
                                    $row_can_pre = $result_can_pre->fetch_assoc();

                                    if($row_can_pre['status'] === "Done"){
                                        ?>
                                            <div class="containerorder"><?php //echo $tracking; ?>
                                                <?php
                                                $sql_monitor_item = "SELECT * FROM admin_order WHERE cid=$cid_user AND tracking_no = '$tracking' AND table_number = $table_number AND status = 'DONE'";
                                                $result_monitor_item = $connection->query($sql_monitor_item);
                                                if ($result_monitor_item->num_rows > 0) {
                                                    // Loop through each item
                                                    while ($row_item = $result_monitor_item->fetch_assoc()) {
                                                        $subtotal = $row_item['quantity'] * $row_item['price'];
                                                        $total_amount += $subtotal; // Add the subtotal to the total amount
                                                    ?>
                                                        <div class="containeritem d-flex bd-highlight">
                                                            <div class="prodname flex-fill bd-highlight"> <?php echo $row_item['product_name']; ?> </div>
                                                            <div class="pquantity flex-fill bd-highlight"><?php echo $row_item['quantity']; ?></div>
                                                            <div class="pprice flex-fill bd-highlight"><?php echo $row_item['price']; ?></div>
                                                            <?php
                                                                $subtotal = $row_item['quantity'] * $row_item['price'];
                                                            ?>
                                                            <div class="pstotal flex-fill bd-highlight"><?php echo $subtotal; ?></div>
                                                            <div class="prodstatus flex-fill bd-highlight"><?php echo $row_item['status']; ?></div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        <?php
                                    }

                                    
                                }
                            }
                            else{
                                echo "NO ORDERS AT THE MOMENT";
                            }
                            
                        }
                        
                    }
                    else{
                        echo "NO ORDERS AT THE MOMENT";
                    }
                    ?>
                    
                    </div>
                    <h3 class="totalamt">Total Amount: <?php echo $total_amount; ?></h3>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function () {
        sidebar.classList.toggle('active');
    };
</script>

</body>
</html>


