<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}


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
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['loginbtn'])){
            $nickname = $_POST['nickname'];
            $tablenumber = $_POST['tablenumber'];
        
             // Prepared statement to retrieve tid based on the selected table_number
             $sql_tid = "SELECT nickname FROM customer WHERE table_number = ? and nickname = '$nickname'";
             $stmt_tid = $connection->prepare($sql_tid);
             $stmt_tid->bind_param("i", $tablenumber);
             $stmt_tid->execute();
             $result_tid = $stmt_tid->get_result();
     
    
            // Check if a row is returned, indicating successful verification
            if($result_tid->num_rows > 0){
    
                $_SESSION['table_number'] = $tablenumber;
                $_SESSION['table_name'] = $nickname;
                // Redirect to client-product.php
                header("location: client-product.php");
                exit;
    
            } else {
                $_SESSION['table_number'] = $tablenumber;
                $_SESSION['table_name'] = $nickname;
    
                $insertSql = "INSERT INTO CUSTOMER (table_number, nickname) VALUES (?,?)";
                $insertStmt = $connection->prepare($insertSql);
                $insertStmt->bind_param("is", $tablenumber, $nickname);
                $insertStmt->execute();
                
                // Redirect to client-product.php
                header("location: client-product.php");
                exit;
            }
        }
    }
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assist | University Hills</title>
    <link rel="icon" href="Pic/uhicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/sidebar.css">

    <style>
        .main-content{
            height: 100vh;
            overflow-x: hidden;
           
        }
        .x{
            padding-top: 0;
        }
        body{
            font-family: "Poppins", sans-serif;
        }

        .containerblack{
            width: 100%;
           
        
        }
        h2{
            margin-bottom: 5%;
        }
        .formlogin{
            background-color: #fff;
            width: 90%;
            margin: 14% 0% 0% 14%;
            padding: 7% 7% 7% 7%;
            border-radius: 13px;
        }
        .formlogin>h2{
            text-align: center;
            font-weight: bold;
        }
        .formlogin>p{
            font-size: 14pt;
            text-align: center;
        }
        .formlogin>label{
            width: 100%;
            margin-bottom: 2%;
            margin-top: 5%
        }

        .formlogin label .input,.formlogin label select {
            background-color: #F6F6F6;
            width: 100%;
            padding: 20px 05px 05px 10px;
            outline: 0;
            border: 1px solid rgba(105, 105, 105, 0.397);
            border-radius: 10px;
        }

        .formlogin label .input {
            background-color: #F6F6F6;
            width: 100%;
            padding: 20px 05px 05px 10px;
            outline: 0;
            border: 1px solid rgba(105, 105, 105, 0.397);
            border-radius: 10px;
        }
        
        .formlogin label {
            position: relative;
        }
        .formlogin label .input + span {
            color: black;
            position: absolute;
            left: 10px;
            top: 0px;
            font-size: 0.9em;
            cursor: text;
            transition: 0.3s ease;
        }
                /*malaki lang yung text*/
        .formlogin label .input:placeholder-shown + span {
                top: 12.5px;
                font-size: 0.9em;
        }

        .formlogin label .input:focus + span,
            .formlogin label .input:valid + span {
            color: #00bfff;
            top: 0px;
            font-size: 0.7em;
            font-weight: 600;
        }

        
        .formlogin label select + span{
            color: black;
            position: absolute;
            left: 10px;
            top: 3px;
            font-size: 0.9em;
            cursor: text;
            transition: 0.3s ease;
        }

        .formlogin label select:placeholder-shown + span {
                top: 12.5px;
                font-size: 0.9em;
        }

        .formlogin label select:focus + span,
        .formlogin label select:valid + span
                {
            color: #00bfff;
            top: 0px;
            font-size: 0.7em;
            font-weight: 600;
            
        }




        #loginbtn{
            background-color: #141414;
            color: whitesmoke;
            margin-left: 28%;
            width: 40%;
            height: 36px;
            border-radius: 7px;

        }
        #loginbtn:hover{
            background-color: whitesmoke;
            color: #141414;

        }

        .navbar{
            display:none;
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
                    <a class="nav-link active" aria-current="page" href="staff-assist.php">Assist</a>
                </li>

                <li class="nav-item">
                <a class="nav-link " href="staff-concern.php">Customer's Concerns</a>
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
  
    <div class="main-content">
        <div class="container-fluid">
                <div class="container">
                <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10 con1">
                    <div class="containerblack">

                        <form method="POST" class="formlogin">
                            <h2>Assist a customer</h2>
                            <label>
                                <input class="input" type="text" placeholder="" required="" name="nickname">
                                <span>Name</span>
                            </label>

                            <label class="">
                                <select id="tablenumber" name="tablenumber" class="" required="">
                                    <option value="" disabled selected>Table Number</option>
                                    <?php
                                        $sql = "SELECT table_number FROM tables";

                                        $result = $connection->query($sql);
                                        if(!$result){
                                            die("Invalid query: ". $connection->connect_error);
                                        }

                                        while($row = $result->fetch_assoc()){
                                            
                                            echo"
                                            <option value='$row[table_number]'>$row[table_number]</option>
                                            ";
                                        }
                                    ?>
                                </select>
                                <span class="tablenumber">Table Number</span>
                                </label>

                            <button type="submit" name="loginbtn" id="loginbtn">Enter</button>
                        </form>
                    </div>
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

</html>