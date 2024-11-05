<?php


session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";
//Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Set the session variable to true to indicate that the user has visited the page

function isbillout()
{
    return isset($_SESSION['visited'] );
}

// Redirect to login page if not logged in
if (isbillout()) {
    session_unset();
    session_destroy();

    header("Location: client-login.php");
    exit;
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

$_SESSION['billout'] = true;


// Check if there are orders with "Done" status
$sql_done_orders = "SELECT COUNT(*) AS done_count FROM admin_order WHERE status = 'Done'";
$result_done_orders = $connection->query($sql_done_orders);
$row_done_orders = $result_done_orders->fetch_assoc();
$done_count = $row_done_orders['done_count'];

?>

<style>

        .navbar{
            display:none
        }
        .main-content{
            height: 100vh;
            overflow-x: hidden;
            
            padding-right: 1%;

        }
        h3{
            text-align: center;
        }
        
        .cards{
            background-color: white;
            height: 650px;
            border: 1px solid gray;
            border-radius: 10px;
            overflow-y: auto;
            overflow-x: hidden ;
           
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
            color: white;
            text-align: center;
            font-weight: 500;
            background-color: #1F1F1F;
            border: 1px solid #1F1F1F
        }
       
        .requestbill{
            border: none;
            margin-bottom: 2%;
            margin-left: 87%;
        }
        
       
        .flex-fill{
            width: 20%;
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
            
        }
        @media (max-width: 732px) {
            .navbar-brand{
                font-size: 13pt;
            }

        }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders | University Hills</title>
    <link rel="icon" href="Pic/uhicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="css/sidebar.css">

</head>
<body>




    <nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">University Hills Sport Lounge</a>
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
                    <a class="nav-link" href="client-product.php">Client Panel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="client-cart.php">My Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active"  aria-current="page"href="client-order.php">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link "  href="client-concern.php">Report Concern</a>
                </li>
                
            </ul>
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
                <p class="bold">Welcome, Table <?php echo $_SESSION['table_number']; ?></p>
                <p class="nickname"> <?php echo $_SESSION['table_name']; ?></p>
            </div>
        </div>
                
            <div class="lii">
                <a href="client-product.php">
                        <i class="bx bxs-shopping-bag"></i>
                        <span class="nav-item">Order</span>
                </a>
                <span class="tooltip">Order</span>
            </div>

            <div class="lii">
                <a href="client-cart.php">
                <i class="fa-solid fa-cart-plus"></i>
                    <span class="nav-item">Cart</span>
                </a>
                <span class="tooltip">Your Cart</span>
            </div>

            <div class="lii">
                <a href="client-order.php">
                <i class="fa-solid fa-bag-shopping"></i>
                    <span class="nav-item">Orders</span>
                </a>
                <span class="tooltip">Orders</span>
            </div>

            <div class="lii">
                <a href="client-concern.php">
                <i class="fa-solid fa-exclamation-triangle"></i>
                    <span class="nav-item">Concern</span>
                </a>
                <span class="tooltip">Submit Concern</span>
            </div>

    </div>

    <style>
       
        .navbar{
            display:none
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
            border-radius: 10px;
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
            color: white;
            text-align: center;
            font-weight: 500;
            background-color: #1F1F1F;
            border: 1px solid #1F1F1F
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
            width: 20%;
        }
        
       

    </style>

    <?php
    $table_number =  $_SESSION['table_number'];
    $table_name = $_SESSION['table_name'];
    
    $sql_cid = "SELECT cid FROM customer WHERE table_number = $table_number and nickname = '$table_name'";
    $result_cid = $connection->query($sql_cid);
    $row_cid = $result_cid->fetch_assoc();
    $cid = $row_cid['cid'];

    

    ?>



        
    <div class="main-content">
        <div class="container-fluid">
            <h1>Orders</h1>
            <button name="requestbill" id="requestbill" class="requestbill btn btn-primary">BILL OUT</button>
            <div id="link_wrapper">



            </div>
            <!-- Modal -->
<div class="modal fade" id="billingOutModal" tabindex="-1" aria-labelledby="billingOutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="billingOutModalLabel">Waiting for confirmation for billing out...</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Please wait while we process your request...
      </div>
      <!-- You can add additional content to the modal body if needed -->
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

    function loadXMLDoc() {
        console.log("Calling loadXMLDoc...");
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("link_wrapper").innerHTML = this.responseText;
                console.log("Response received:", this.responseText);
            }
        };
        xhttp.open("GET", "client_order_server.php", true);
        xhttp.send();
    }

    setInterval(function(){
        console.log("Calling loadXMLDoc periodically...");
        loadXMLDoc();
    }, 10000);

    window.onload = function() {
        console.log("Window loaded.");
        loadXMLDoc();
        toggleBillingOutButton(); // Check button state on page load
    };
    
    // Function to save scroll position to localStorage
    function saveScrollPosition() {
        localStorage.setItem('scrollPosition', window.scrollY);
        console.log("Scroll position saved:", window.scrollY);
    }

    // Function to restore scroll position from localStorage
    function restoreScrollPosition() {
        var scrollPosition = localStorage.getItem('scrollPosition');
        if (scrollPosition !== null) {
            console.log("Scroll position restored:", scrollPosition);
            window.scrollTo(0, parseInt(scrollPosition));
        }
    }

    // Save scroll position when the user scrolls
    window.addEventListener('scroll', saveScrollPosition);

    // Restore scroll position when the page is loaded
    window.addEventListener('load', restoreScrollPosition);



// Function to enable/disable billing out button based on the count of "Done" orders and pending/preparing orders
function toggleBillingOutButton() {
    var requestBillButton = document.getElementById("requestbill");
    
    // Make an AJAX request to check for pending/preparing orders
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            var pendingCount = response.pending_count;
            
            // Disable the button if there are no "Done" orders and there are pending/preparing orders
            requestBillButton.disabled = (<?php echo $done_count; ?> === 0 || pendingCount > 0);
        }
    };
    xhttp.open("GET", "check_pending_orders.php", true);
    xhttp.send();
}

window.onload = function() {
    console.log("Window loaded.");
    loadXMLDoc();
    toggleBillingOutButton(); // Check button state on page load
};

document.getElementById("requestbill").addEventListener("click", function() {
    if (<?php echo $done_count; ?> > 0) {
        // Display confirmation dialog
        var confirmation = confirm("Are you sure you want to bill out?");
        
        // If user confirms, proceed with billing out
        if (confirmation) {
            toggleBillingOutButton(); // Check button state again after confirmation
            requestbill();
        }
    } else {
        alert("There are no orders with 'Done' status to bill out.");
    }
});

// Function to request bill
function requestbill() {
    // Make AJAX request to check for pool reservation
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Check the response from the server
            var response = JSON.parse(this.responseText);
            if (response.hasReservation) {
                // There is an existing reservation, ask the user if they want to cancel it
                var cancelReservation = confirm("You have an active pool reservation. Do you want to cancel it?");
                if (cancelReservation) {
                    // User confirmed to cancel the reservation, proceed with billing out
                    cancelPoolReservation();
                } else {
                    // User chose not to cancel the reservation, do nothing
                    return;
                }
            } else {
                // No reservation, proceed with billing out
                proceedWithBillingOut();
            }
        }
    };
    xhttp.open("POST", "check-pool-reservation.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("table_number=" + encodeURIComponent(<?php echo $table_number; ?>));
}

// Function to cancel pool reservation
function cancelPoolReservation() {
    // Make AJAX request to delete the reservation
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Handle the response from the server if needed
            console.log(this.responseText);
            // Proceed with billing out after canceling reservation
            proceedWithBillingOut();
        }
    };
    xhttp.open("POST", "cancel-pool-reservation.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("table_number=" + encodeURIComponent(<?php echo $table_number; ?>));
}


// Function to proceed with billing out
function proceedWithBillingOut() {
    // Display confirmation dialog
    var confirmation = confirm("Are you sure you want to bill out?");
    
    // If user confirms, proceed with billing out
    if (confirmation) {
        // Make AJAX request to request bill
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Handle the response from the server if needed
                console.log(this.responseText);
                // Display alert after the response is received
                showAlert();
            }
        };
        xhttp.open("POST", "customer_bill_request.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("table_number=" + encodeURIComponent(<?php echo $table_number; ?>) + "&cid=" + encodeURIComponent(<?php echo $cid; ?>));
    }
}

// Function to show alert
function showAlert() {
    // Display alert to inform the user to wait for staff assistance
    alert("Please wait, a staff will assist you.");
    // Redirect the user to client-comment.php after they click "Okay"
    window.location.href = "client-comment.php";
}
</script>

</html>