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

// Check if the session variable is set
if (!isset($_SESSION['table_number'])) {
    // Redirect to an error page or handle the lack of session variable
    exit("Error: Table number not set.");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get table number from session
    $table_number = $_SESSION['table_number'];

    // Get concern from form submission
    $concern = $_POST['concern'];

    // Prepare and execute SQL statement
    $sql = "INSERT INTO university_hills.concerns (date_time, table_number, concern) VALUES (CURRENT_TIMESTAMP, ?, ?)";
    $stmt = $connection->prepare($sql);

    // Check if the statement is prepared successfully
    if ($stmt === false) {
        // Handle statement preparation error
        exit("Error: Unable to prepare SQL statement.");
    }

    // Bind parameters
    $stmt->bind_param("is", $table_number, $concern);

    // Execute statement
    if ($stmt->execute()) {
        // Set success message in session
        $_SESSION['success_message'] = "Concern submitted successfully.";
    } else {
        echo "<script>alert('Error: " . $connection->error . "');</script>";
    }

    // Close statement
    $stmt->close();

    // Redirect to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer's Concern</title>

    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="css/sidebar.css">
    <style>
        
        .uhlogo img {
            width: 20%;
        }

        .container {
            padding: 0% 0% 0% 10%;
        }
        
        .card {
            margin: 0% 5% 0% 5%;
        }

        .navbar{
            display:none
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
            .navbar-toggler{
                height: 30px;
                padding-top: 0px;
            }
            .navbar-toggler-icon{
                font-size: 8pt;
                margin-top: 0px;
            }
        }
        .prodimg{
            max-width: 120px;
        }
        .main-content{
            height: 100vh;
            overflow-x: hidden;
            padding-left: 1%;
            padding-right: 1%;
        }
        .whitcontainer{
                
                margin-left: 0%;
                margin-right: 0%;
                padding: 0%;
            
                background-color: white;
                width: 100%;
                height: 850px;
                overflow-x:hidden;
                border-radius:15px ;
                position: relative;
            }
            .placeorder{
                position: absolute;
                bottom: 0px;
                height: 12%;
                width: 98%;
                background-color: #12171e;
            }
            .btnorder{
                position: absolute;
                right: 50px;
                bottom: 30px;

            }
            .total{
                color: white;
                text-align: center;
                margin-top: 1%;
                font-size: 30pt;
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

            .container {
            padding: 15% 0% 0% 0%;
            }

        }

        @media only screen and (min-width: 1200px) {
            .container {
            padding: 5% 0% 0% 10%;
            }
        } 
    </style>

    <style>
        
    </style>

</head>
<body>


        <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">University Hills Sports Lounge</a>
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
                    <a class="nav-link" href="client-product.php">Products</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="client-cart.php">Cart</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="client-order.php">Orders</a>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="client-concern.php">Report a Concern</a>
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

            <?php
            function isAssist()
            {
                return isset($_SESSION['staff_access'] );
            }

            if (isAssist()) {
                ?>
                <div class="lii">
                    <a href="staff-assist.php">
                        <i class="fa-solid fa-hands-helping"></i>
                        <span class="nav-item">Assist</span>
                    </a>
                    <span class="tooltip">Staff-Assist </span>
                </div>
                <?php
            }
            ?>

    </div>
        <?php
    // Check if the success message is set in the session
    if (isset($_SESSION['success_message'])) {
        $success_message = $_SESSION['success_message'];
        unset($_SESSION['success_message']); // Unset the session variable after displaying the message
    ?>
        <script>
            alert("<?php echo $success_message; ?>");
        </script>
    <?php } ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="text-center">
                <div class="uhlogo">
                    <img src="pic/logo.png" alt="">
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10 ">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Customer's Concern</h2>
                         <form id="concernForm" method="post" action="submit-concern.php">
                            <div class="form-group">
                                <label for="concernTextarea">Enter Your Concern:</label>
                                <textarea class="form-control" id="concernTextarea" name="concern" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function () {
        sidebar.classList.toggle('active');
    };
</script>

</body>
</html>