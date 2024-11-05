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
    <title>Bills | University Hills</title>
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
            position: relative;
            background-color: #eee;
            min-height: 100vh;
            top:0;
            left:80px;
            transition: all 0.5s ease;
            width: calc(100% - 80px);
            padding: 1rem;
            height: 100vh;
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
            height: 100vh;
            overflow-x: hidden;
            
            padding-right: 1%;

        }
        h3{
            text-align: center;
        }
        .conn{
            margin-left: 3%;
        }

        .cards{
            background-color: white;
            height: 650px;
            border: 1px solid gray;
            
            overflow-y: auto;
            overflow-x: hidden ;
            margin-left: 10px;
            position: relative;
            padding: 4%;
           
            
           
        }

        .containerorder{
            margin-bottom: 4px;
            height: auto;
            border-bottom: 1px solid #1F1F1F;
            
        }
        .containeritem{
            height: auto;
            width: 100%;
            margin-bottom: 1%;
            
           
        }

        .prodnameh, .prodstatush, .pquantityh, .ppriceh ,.pstotalh{
            font-weight: 700;
        }
        .name{
            color: gray;
            font-weight: 500;
            background-color: #D8D8D8;
            border: 1px solid #D8D8D8;
            position: relative;
            padding-top: 2%;
            padding-left: 2%;
            padding-right: 3%;
            
        }
        .name> p{
            float: left;
            
        }
        
        /* .prodname{
            width: 100%;
       
            float: left;
            height: 100%;
            border-right: 1px solid #1F1F1F;
            background-color: pink;

        } */
        /* .prodstatus{
            height: 100%;
            text-align: center;
            background-color: yellow;
            width: 10%;
            float: right;
        } */
        /* .white{
            background-color: #1F1F1F;
            position: absolute;
            bottom: 0px;
            width: 100;

        } */
        .requestbill{
            border: none;
            margin-bottom: 2%;
            margin-left: 87%;
        }
        
        /* .pprice{
            width: 10%;
            float: left;
        } */ 
        .flex-fill{
            width: 25%;
        }
        .tableno{
            background-color: #4D4D4D;
            text-align: center;
            color: white;
            font-size: 25pt;
            width: 98.2%;
            margin-left: 1.8%;
            border-top-left-radius: 8px ;
            border-top-right-radius: 8px;
        }
        .totalamt{
            background-color: #4D4D4D;
            text-align: center;
            color: white;
            font-size: 20pt;
            width: 98.2%;
            margin-left: 1.8%;
            border-bottom-left-radius: 8px ;
            border-bottom-right-radius: 8px;
        }

        .useramt{
            color: red;
            margin-bottom: 50px;
            font-size: 15pt;
            text-align: left;
        }
  
        .useramt > input{
            outline: none;
            border: none;

        }
        .pooltotal{
            font-size: 15pt;
            font-weight: 600;
        }
        .billtable{
            margin-bottom: 50px;
        }
        .btnpay{
            background-color: #12171e;
            outline: none;
            border: none;
            font-size: 15pt;
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
            <a class="nav-link active" aria-current="page" href="admin-bill.php">Bills</a>
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
                <a class="nav-link "  href="admin-concern.php">Customer's Concerns</a>
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
            <h1>Bills</h1>
            <div class="row">
            <?php
            $sql_bill_table = "SELECT DISTINCT table_number FROM admin_order WHERE status = 'Request' order by billout_by";
            $result_bill_table = $connection->query($sql_bill_table);
            if ($result_bill_table->num_rows > 0) {
                
                // Loop through each tracking number
                while ($row_bill_table = $result_bill_table->fetch_assoc()) {
                    $bill_table =  $row_bill_table['table_number'];
                    $k = 0;
                    
                ?>
                <div class="col-sm-12 col-md-10 col-lg-4 col-xl-4 billtable">
                    <div class="tableno "><?php echo $bill_table; ?></div>
                    <div class="cards">
                    <?php
                        $sql_monitor_cid = "SELECT DISTINCT cid FROM admin_order WHERE table_number = $bill_table AND status = 'Request'";
                        $result_monitor_cid = $connection->query($sql_monitor_cid);

                    

                        if ($result_monitor_cid->num_rows > 0) {
                            ?>
                            <form method="POST">
                                <?php
                                // Loop through cid
                            while ($row_cid = $result_monitor_cid->fetch_assoc()) {
                                $cid_user = $row_cid['cid'];

                                $sql_monitor_name = "SELECT nickname FROM customer WHERE cid=$cid_user";
                                $result_monitor_name = $connection->query($sql_monitor_name);
                                $row_monitor_name = $result_monitor_name->fetch_assoc();

                                 $k += 1;

                                //echo $cid_user;
                                ?>
                                <div class="name lead d-flex" data-user-id="<?php echo $user['cid']; ?>">
                                    <div class="me-auto">
                                        <p >
                                            <span><?php echo $row_monitor_name['nickname']; ?></span>
                                            <input type="hidden" id="name_<?php echo $bill_table. $k  ?>" name="name_<?php echo $bill_table. $k  ?>"  value="<?php echo $row_monitor_name['nickname']; ?>">
                                        </p>
                                    </div>
                                    <div class="">
                                        <input type="checkbox" onclick="updateValidIdCount('<?php echo $bill_table; ?>')" class="validid" id="validid_<?php echo $bill_table. $k  ?>" name="validid_<?php echo $bill_table. $k  ?>" data-user-id="<?php echo $user['cid']; ?>" value="validid">
                                        <label for="validid_<?php echo $bill_table. $k  ?>"> valid id</label><br>
                                        <input type="hidden" class="isvalid_<?php echo $bill_table. $k  ?>" value="">
                                    </div>
                                </div>

                                <div class="containeritem d-flex bd-highlight">
                                    <div class="prodnameh flex-fill bd-highlight"> NAME </div>
                                    <div class="pquantityh flex-fill bd-highlight"> QTY </div>
                                    <div class="ppriceh flex-fill bd-highlight">PRICE</div>
                                    <div class="pstotalh flex-fill bd-highlight">SUBTOTAL</div>
                                </div>

                                <?php

                                $total_user = 0;

                                $sql_monitor = "SELECT DISTINCT tracking_no FROM admin_order WHERE table_number = $bill_table AND cid=$cid_user";
                                $result_monitor = $connection->query($sql_monitor);
                                if ($result_monitor->num_rows > 0) {
                                    
                                    // Loop through each tracking number
                                    while ($row = $result_monitor->fetch_assoc()) {
                                        $tracking = $row['tracking_no'];

                                        //count of tracking order
                                        $sql_cancelled_preparing = "SELECT * FROM admin_order WHERE cid=$cid_user AND tracking_no = '$tracking' AND table_number = $bill_table";
                                        $result_can_pre = $connection->query($sql_cancelled_preparing);
                                        $row_can_pre = $result_can_pre->fetch_assoc();

                                        if($row_can_pre['status'] === "Request"){
                                            ?>
                                                <div class="containerorder"><?php //echo $tracking; ?>
                                                    <?php
                                                    $sql_monitor_item = "SELECT * FROM admin_order WHERE cid=$cid_user AND tracking_no = '$tracking' AND table_number = $bill_table AND status = 'Request'";
                                                    $result_monitor_item = $connection->query($sql_monitor_item);
                                                    if ($result_monitor_item->num_rows > 0) {
                                                        // Loop through each item
                                                        while ($row_item = $result_monitor_item->fetch_assoc()) {
                                                           

                                                            $usersubtotal = $row_item['quantity'] * $row_item['price'];
                                                            $total_user += $usersubtotal; // Add the subtotal to the user total amount
                                                            
                                                        ?>
                                                            <div class="containeritem d-flex bd-highlight">
                                                                <div class="prodname flex-fill bd-highlight"> 
                                                                    <?php echo $row_item['product_name']; ?>
                                                                    <input type="hidden" id="pname_<?php echo $bill_table. $k  ?>" name="pname_<?php echo $bill_table. $k  ?>"  value="<?php echo $row_item['product_name']; ?>"> 
                                                                </div>
                                                                <div class="pquantity flex-fill bd-highlight">
                                                                    <?php echo $row_item['quantity']; ?>
                                                                    <input type="hidden" id="pquantity_<?php echo $bill_table. $k  ?>" name="pquantity_<?php echo $bill_table. $k  ?>"  value="<?php echo $row_item['quantity']; ?>">
                                                                </div>
                                                                <div class="pprice flex-fill bd-highlight">
                                                                    <?php echo $row_item['price']; ?>
                                                                    <input type="hidden" id="pprice_<?php echo $bill_table. $k  ?>" name="pprice_<?php echo $bill_table. $k  ?>"  value="<?php echo $row_item['price']; ?>"> 
                                                                </div>
                                                                <?php
                                                                    $subtotal = $row_item['quantity'] * $row_item['price'];
                                                                ?>
                                                                <div class="pstotal flex-fill bd-highlight">
                                                                    <?php echo $subtotal; ?>
                                                                    <input type="hidden" id="psubtotal_<?php echo $bill_table. $k  ?>" name="psubtotal_<?php echo $bill_table. $k  ?>"  value="<?php echo $subtotal; ?>"> 
                                                                </div>
                                                                <!--<div class="prodstatus flex-fill bd-highlight">-->
                                                                   
                                                                    <input type="hidden" id="pstatus_<?php echo $bill_table. $k  ?>" name="pstatus_<?php echo $bill_table. $k  ?>"  value="<?php echo $row_item['status']; ?>">
                                                                <!--</div>-->
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
                                ?>
                                    <h3 class="useramt"> 
                                        Amount: <span> <?php //echo $total_user; ?> </span>
                                        <input type="text" readonly id="usertotal_<?php echo $bill_table. $k  ?>" name="usertotal_<?php echo $bill_table. $k  ?>"  value="<?php echo $total_user; ?>">
                                    </h3>
                                <?php
                                
                            } 
                            ?>
                             <!--<input type="text" id="increment_<echo $bill_table . $k ?>" name="" value="<echo $bill_table. $k; ?>"-->
                            <?php
                                $sql_bill_pool = "SELECT COUNT(*) as table_payment FROM pool_accepted WHERE table_number = $bill_table";
                                $result_bill_pool = $connection->query($sql_bill_pool);
                                if ($result_bill_pool->num_rows > 0) {
                                    
                                    $row_bill_pool = $result_bill_pool->fetch_assoc();
                                    $bill_pool =  $row_bill_pool['table_payment'];
                                    $total_pool = 150 * $bill_pool;

                                    $poolprice = 150;
                                    echo "<p class='pooltotal'>Table Pool: ". $poolprice."x".$bill_pool."=".$total_pool . "</p>";
                                    ?>
                                    <input  type="hidden" id="num_user_<?php echo $bill_table ?>" name="num_user_<?php echo $bill_table ?>" value="<?php echo $k; ?>">
                                        <input type="hidden" id="pool_<?php echo $bill_table ?>" value="<?php echo $total_pool ?>">
                                    <?php
                                }
                                        
                            ?>
                                
                        </form>

                            <?php
                        
                        }
                        
                        else{
                            echo "NO ORDERS AT THE MOMENT";
                        }
                        
                    ?>
                    </div>
      
                    
                    <div class="totalamt">
                        <p id="overalltotal_<?php echo $bill_table;  ?>" name = "overalltotal_<?php echo $bill_table; ?>">Total Amount: </p><!--Overall total amout per table-->
                        <input type="hidden" name="inputoveralltotal_<?php echo $bill_table;  ?>" id="inputoveralltotal_<?php echo $bill_table;  ?>"> 
                        <input type="hidden" name="countvalidid_<?php echo $bill_table;  ?>" id="countvalidid_<?php echo $bill_table;  ?>" value="0">
                        <button class="btn btn-primary w-100 btnpay" id="btnpay" name="btnpay">Done</button></div>  
                    </div>
                 <?php
                
                }
            }
            ?>
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
    document.addEventListener("DOMContentLoaded", function () {
        // Add event listeners to all valid ID checkboxes within each table
        let tables = document.querySelectorAll('.cards');
        tables.forEach(function (table) {
            let validIdCheckboxes = table.querySelectorAll('.validid');
            validIdCheckboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    // Get the corresponding user's total amount and original total
                    let userId = checkbox.id.split('_')[1];
                    let totalElement = table.querySelector('#usertotal_' + userId);
                    let originalTotal = parseFloat(totalElement.getAttribute('data-original-total'));
                    let total = parseFloat(totalElement.value);

                    // Apply discount if the checkbox is checked
                    let discount = checkbox.checked ? 0.8 : 1; // 20% discount if checked
                    let discountedTotal = total * discount;

                    // Update the displayed total for the user
                    if (checkbox.checked) {
                        // Store original total if checkbox is checked
                        totalElement.setAttribute('data-original-total', total);
                        totalElement.value = discountedTotal.toFixed(2);
                        calculateOverallTotal(table);
                    } else {
                        // Restore original total if checkbox is unchecked
                        totalElement.value = originalTotal.toFixed(2);
                        calculateOverallTotal(table);
                    }
                    totalElement.nextElementSibling.textContent = 'Amount: ' + totalElement.value;

                    // Recalculate the overall total amount for the table
                    calculateOverallTotal(table);
                });
            });

            // Calculate the initial overall total amount for the table
            calculateOverallTotal(table);
        });
    });

    function calculateOverallTotal(table) {
        let userTotals = table.querySelectorAll('input[id^="usertotal_"]');
        let overallTotal = 0;
        let poolPrice = parseFloat(table.querySelector('#pool_' + table.parentNode.querySelector('.tableno').textContent)?.value || 0);

        userTotals.forEach(function (userTotal) {
            overallTotal += parseFloat(userTotal.value);
        });

        overallTotal += poolPrice;

        let overallTotalDisplay = table.parentNode.querySelector('#overalltotal_' + table.parentNode.querySelector('.tableno').textContent);
        let inputOverallTotalDisplay = table.parentNode.querySelector('#inputoveralltotal_' + table.parentNode.querySelector('.tableno').textContent);

        overallTotalDisplay.textContent = 'Total Amount: ' + overallTotal.toFixed(2);
        inputOverallTotalDisplay.value = overallTotal.toFixed(2);
    }
</script>


<script>
// Get all checkboxes with the class 'validid'
const validIdCheckboxes = document.querySelectorAll('.validid');

// Add an event listener to each checkbox
validIdCheckboxes.forEach(checkbox => {
  checkbox.addEventListener('change', function() {
    // Get the corresponding 'isvalid_' input field
    const isValidInput = document.querySelector(`.isvalid_${checkbox.id.replace('validid_', '')}`);

    // Update the value of the 'isvalid_' input field
    isValidInput.value = this.checked ? 'with valid id' : '';
  });
});
</script>


<script>
// Get all "Pay" buttons
const payButtons = document.querySelectorAll('.btnpay');

// Add a click event listener to each button
payButtons.forEach(button => {
    button.addEventListener('click', function() {
        const tableNumber = button.parentNode.parentNode.querySelector('.tableno').textContent;
        const overallTotal = button.parentNode.querySelector('#inputoveralltotal_' + tableNumber).value;
        var inputValue = document.getElementById("countvalidid_"+ tableNumber).value;

        // Gather product details
        const products = button.parentNode.querySelectorAll('.containeritem');

        let data = 'table_number=' + encodeURIComponent(tableNumber) + '&overall_total=' + encodeURIComponent(overallTotal) + '&pix=' + inputValue;

        // Call the new function to send the payment data
        sendPaymentDataWithConfirmation(data);
    });
});

function sendPaymentDataWithConfirmation(data) {
    sendPaymentData(data);
}

function sendPaymentData(data) {
    // Create an XMLHttpRequest object
    const xhr = new XMLHttpRequest();

    // Confirm with the user before sending the request
    if (confirm("Are you sure you want to proceed?")) {
        // Set up the request
        xhr.open('POST', 'process_payment.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Send the request
        xhr.send(data);
        window.location.reload();
    }
}

</script>

<script>
    // Function to handle checkbox click event
    function updateValidIdCount(tableNumber) {
        // Get all checkboxes for the specified table
        var checkboxes = document.querySelectorAll('input[name^="validid_' + tableNumber + '"]');
        var validIdCount = 0;

        // Loop through each checkbox
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                validIdCount++;
            }
        });

        // Update the count of valid IDs for the table
        document.getElementById('countvalidid_' + tableNumber).value = validIdCount;
    }
</script>

<script>
    // Function to send payment data with confirmation
    function sendPaymentDataWithConfirmation(data) {
        // Confirm with the user before sending the request
        if (confirm("Are you sure you want to proceed?")) {
            // Send the payment data
            sendPaymentData(data);
        }
    }

    // Function to send payment data
    function sendPaymentData(data) {
        // Create an XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Set up the request
        xhr.open('POST', 'process_payment.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Send the request
        xhr.send(data);

        // Reload the page after sending the payment data
        location.reload();
    }
</script>






</html>