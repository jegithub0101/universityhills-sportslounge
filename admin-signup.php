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



$firstname = "";
$lastname = "";
$middlename = "";
$age = "";
$birthday = "";
$address = "";
$gender = "";
$user = "";
$password = "";
$error_message = "";
$success_message = "";

$error_messages = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $middlename = $_POST["middlename"];
    $age = $_POST["age"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $gender = $_POST["gender"];
    $user = $_POST["user"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $type = $_POST["type"];

    // Validate Firstname, Middlename, and Lastname
    if (!preg_match("/^[a-zA-Z .-]*$/", $firstname) || !preg_match("/^[a-zA-Z .-]*$/", $middlename) || !preg_match("/^[a-zA-Z .-]*$/", $lastname)) {
        $error_messages[] = "Invalid name format. Names should only contain letters, spaces, dots, and hyphens.";
    }

    // Validate Birthday
    $birth_year = date('Y', strtotime($birthday));
    $current_year = date('Y');
    if (($current_year - $birth_year) < 18 || ($current_year - $birth_year) > 60) {
        $error_messages[] = "Age must be between 18 and 60 years old.";
    }

    // Validate Age
    if (!is_numeric($age)) {
        $error_messages[] = "Age must be a number.";
    }

    // Validate Username
    $check_username_query = "SELECT * FROM account WHERE username='$user'";
    $check_username_result = mysqli_query($connection, $check_username_query);
    if (mysqli_num_rows($check_username_result) > 0) {
        $error_messages[] = "Username already exists. Try a different username.";
    }

    // Validate Password
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
        $error_messages[] = "Password must contain at least one uppercase letter, one lowercase letter, one digit, one special character, and be at least 8 characters long.";
    }

    // Validate Confirm Password
    if ($password != $confirmpassword) {
        $error_messages[] = "Passwords do not match.";
    }

    if ($gender === 'male') {
        $defaultPicPath = 'Pic/user.png';
    } else {
        $defaultPicPath = 'Pic/user.png';
    }

    $picData = file_get_contents($defaultPicPath);
    $picData = mysqli_real_escape_string($connection, $picData);

    if (empty($error_messages)) {
        // Insert data into database
        $insert_query = "INSERT INTO account (firstname, lastname, middlename, age, birthday, address, gender, username, password, type, pic) VALUES ('$firstname', '$lastname', '$middlename', '$age', '$birthday', '$address', '$gender', '$user', '$password', '$type', '$picData')";
        if (mysqli_query($connection, $insert_query)) {
            $success_message = "New account added successfully.";
        } else {
            $error_messages[] = "Error: " . mysqli_error($connection);
        }
    } else {
        $error_message = implode("<br>", $error_messages);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | University Hills</title>
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


            </style>

            <style>

                .biglogo{
                            width: 30%;
                            margin: auto;
                            margin-top: -10%;

                            
                        }

                        .con11{
                                display: flex;
                                justify-content: center; /* Horizontally center the content */
                                align-items: center; /* Vertically center the content */
                            }
                .formlogin{
                    background-color: white;
                    /* margin: 0% 9% 9% 9%; */
                    padding: 5%;
                    border-radius: 10px;
                    height: auto;
                    width: 50%;

                }
                .formlogin input, .formlogin select{
                    width: 50%;
                }

                .formcolumn1{
                    
                    
                    float: left;
                }
                .formcolumn2{
                    
                    
                    float: left;
                }



                /*-------------------------------- */

                .formlogin{
                    background-color: #fff;
                    padding: 7% 7% 7% 7%;
                    border-radius: 13px;
                    margin: auto;
                }

                .formlogin>h2{
                    text-align: center;
                    font-weight: bold;
                }
                .formlogin>p{
                    font-size: 14pt;
                    text-align: center;
                }

                .formlogin label{
                    width: 95%;
                    margin-bottom: 2%;
                    
                }

                .formlogin label .input,.formlogin label select {
                    background-color: #F6F6F6;
                    width: 100%;
                    padding: 20px 05px 05px 10px;
                    outline: 0;
                    border: 1px solid rgba(105, 105, 105, 0.397);
                    border-radius: 10px;
                    
                    
                }
                .formlogin label .input:focus,.formlogin label select:focus{
                    border: 1px solid black;
                }

                .formlogin label {
                    position: relative;
                }
                .formlogin label .input + span  {
                    color: black;
                    position: absolute;
                    left: 10px;
                    top: 0px;
                    font-size: 0.9em;
                    cursor: text;
                    transition: 0.3s ease;
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

                .formlogin label .input:placeholder-shown + span {
                        top: 12.5px;
                        font-size: 0.9em;
                }

                .formlogin label select:placeholder-shown + span {
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

                .formlogin label select:focus + span,
                .formlogin label select:valid + span
                        {
                    color: #00bfff;
                    top: 0px;
                    font-size: 0.7em;
                    font-weight: 600;
                    
                }

                .btnsignup{
                    background-color: #141414;
                    color: whitesmoke;
                    margin-left: 28%;
                    width: 40%;
                    height: 36px;
                    border-radius: 7px;
                    margin-top: 15px;

                }

                
                .btnsignup:hover{
                    background-color: whitesmoke;
                    color: #141414;

                }


                @media screen and (max-width: 1200px) {
                    .containerblack{
                        padding-top: 10%;
                        height: 1230px;
                    }
                    .formlogin {
                        width: 60%
                    }
                    .alert {
                        width: 50%

                    }
                }

                @media screen and (max-width: 990px) {
                    .containerblack{
                        padding-top: 10%;
                        height: 1230px;
                    
                    }
                    .formlogin {
                        width: 70%
                    }
                    .alert {
                        width: 50%

                    }

                    .biglogo {
                        margin-top: -5%;
                    }
                }
                @media screen and (max-width: 608px) {
                    .containerblack{
                        padding-top: 10%;
                        height: 1230px;
                    
                    }
                    .wineglass{
                        display: none;
                    }
                    .formlogin {
                        width: 80%
                    }
                    .alert {
                        width: 50%

                    }

                    .biglogo {
                        margin-top: 0%;
                    }
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
            <a class="nav-link" href="admin-sales.php">Sales</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-staff.php">Staff</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-comment.php">Comment</a>
            </li>

            <li class="nav-item">
            <a class="nav-link active"  aria-current="page" href="admin-signup.php">Create Account</a>
            </li>

            <li class="nav-item">
                <a class="nav-link "href="admin-concern.php">Customer's Concerns</a>
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
                <h1>Create Account</h1>

                <?php
                            if (!empty($error_message)){
                                echo "
                                <div class='alert alert-warning alert-dismissible fad show' role='alert'>
                                    <strong>$error_message</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' area-label='Close'></button>
                                </div>
                                ";
                            }
                        ?>
                
                <form method="POST" action="" class="formlogin">

<div class="con11">
<img src="Pic/Logo.svg" alt="Loading" class="biglogo">
</div>


    <h2>WELCOME, NEW USER!</h2>
    <p class="lead">Kindly provide your details below to create an account.!</p>


    <div class="formcolumn1 col-md-12 col-lg-12 col-xl-6">
        <label class="col-sm-12">
            <input class="input" type="text" placeholder="" required="" name="firstname" value="<?php echo $firstname?>">
            <span>First Name</span>
        </label>

        <label class="col-sm-12 ">
            <input class="input" type="text" placeholder="" required="" name="middlename" value="<?php echo $middlename?>">
            <span>Middle Name</span>
        </label>

        <label class="col-sm-12">
            <input class="input" type="text" placeholder="" required="" name="lastname" value="<?php echo $lastname?>">
            <span>Last Name</span>
        </label>

        <label class="col-sm-12">
            <input class="input" type="text" placeholder="" required="" name="address" value="<?php echo $address?>">
            <span>Address</span>
        </label>

        <label class="col-sm-12">
            <input class="input" type="date" placeholder="" required="" name="birthday" value="<?php echo $birthday?>">
            <span>Birthday</span>
        </label>
    </div>
    <div class="formcolumn2 col-md-12 col-xl-6">
        <label class="col-sm-12">
            <input class="input" type="text" placeholder="" required="" name="age" value="<?php echo $age?>">
            <span>Age</span>
        </label>

        <label class="col-sm-12">
        <select id="gender" name="gender" class="" required="">
            <option value="" disabled selected>Choose Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        <span class="gender1">Gender</span>
        </label>

        <label class="col-sm-12">
            <input class="input" type="text" placeholder="" required="" name="user" value="<?php echo $user?>">
            <span>Username</span>
        </label>

        <label class="col-sm-12">
            <input class="input" type="password" placeholder="" required="" name="password" value="<?php echo $password?>">
            <span>Password</span>
        </label class="col-sm-12">

        <label class="col-sm-12">
        <input class="input" type="password" placeholder="" required="" name="confirmpassword">
         <span>Confirm Password</span>

        </label>
    </div>

    <label class="col-sm-12">
        <select id="type" name="type" class="" required="">
            <option value="" disabled selected>Account type</option>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
        </select>
        <span class="gender1">Account Type</span>
        </label>                            
    <?php

    if(!empty($success_message)){
        echo "
        <div class='row mb-3'>
        <div class='offset-sm-3 col-sm-6'>
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>$success_message</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' area-label='Close'></button>
            </div>

        </div>
    </div>
        ";
    }

    ?>


    <button type="submit" class="btnsignup">Sign Up</button>
</form>
            
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

    

</script>

</html>