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
    <title>Orders | University Hills</title>
    <link rel="icon" href="Pic/uhicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-straight/css/uicons-bold-straight.css'>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="icon" href="Pic/logo.svg" type="image/x-icon">

    <style>

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

    <?php   
        require 'admin-sidebar.php';
    ?>
    

    <div class="main-content">
    <div class="container-fluid">
        <div class="container">
            <h1>Orders</h1>
            <div class="row">
                <div id="link_wrapper">



                </div>
            </div>
        </div>
    </div>
</div>





<script>
function loadXMLDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("link_wrapper").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "admin_order_server.php", true);
  xhttp.send();
}

setInterval(function(){
    loadXMLDoc();
},1000);

window.onload = loadXMLDoc;
</script>


 <script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function () {
        sidebar.classList.toggle('active');
    };
</script>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    document.querySelectorAll('.btnaccept').forEach(function(btn) {
        btn.addEventListener('click', function() {
            // Code to hide btnaccept, btndelete, and show DONE button
            const cardBody = this.closest('.card-body');
            cardBody.querySelector('.btnaccept').style.display = 'none';
            cardBody.querySelector('.btndelete').style.display = 'none';
            cardBody.querySelector('.donebtn').style.display = 'block';
        });
    });
</script>


<script>
        function acceptOrder(cid, tracking, button) {
            var cardElement = $(button).closest('.card');

            $.ajax({
                url: 'admin_order_status.php',
                type: 'POST',
                data: {
                    action: 'accept',
                    cid: cid,
                    tracking: tracking
                },
                success: function(response) {
                    alert(response);
                    // Optionally, you can remove the card from the HTML after accepting
                    // cardElement.remove();
                }
            });
        }

        function deleteOrder(cid, tracking, button) {
            var cardElement = $(button).closest('.card');

            $.ajax({
                url: 'admin_order_status.php',
                type: 'POST',
                data: {
                    action: 'delete',
                    cid: cid,
                    tracking: tracking
                },
                success: function(response) {
                    cardElement.remove();
                    alert(response);
                }
            });
        }

        function doneOrder(cid, tracking, button) {
            var cardElement = $(button).closest('.card');

            $.ajax({
                url: 'admin_order_status.php',
                type: 'POST',
                data: {
                    action: 'done',
                    cid: cid,
                    tracking: tracking
                },
                success: function(response) {
                    cardElement.remove();
                    alert(response);
                }
            });
        }
    </script>

<script>
    function confirmAccept(cid, tracking, button) {
        if (confirm("Are you sure you want to accept this order?")) {
            acceptOrder(cid, tracking, button);
        }
    }

    function confirmDelete(cid, tracking, button) {
        if (confirm("Are you sure you want to delete this order?")) {
            deleteOrder(cid, tracking, button);
        }
    }

    function confirmDone(cid, tracking, button) {
        if (confirm("Are you sure you want to mark this order as DONE?")) {
            doneOrder(cid, tracking, button);
        }
    }
</script>

</body>

</html>