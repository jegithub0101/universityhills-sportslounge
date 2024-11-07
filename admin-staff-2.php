<?php

ob_start();

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

//Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

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





//check connection
if($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateProductBtn'])) {
    // Retrieve form data
    $updateStaffId = $_POST['updateStaffId'];
    $updatefName = $_POST['updatefName'];
    $updatemName = $_POST['updatemName'];
    $updatelName = $_POST['updatelName'];
    $updateposition = $_POST['updateStaffPosition'];
    $updategender = $_POST['updategender'];
    $updateaddress = $_POST['updateaddress'];
    $updatebirthday = $_POST['updatebirthday'];


    // Check if image file is uploaded
    if (isset($_FILES['update_image']) && $_FILES['update_image']['error'] === UPLOAD_ERR_OK) {
        $updateimage = $_FILES['update_image']['tmp_name'];

        // Validate image type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $imageType = $_FILES['update_image']['type'];

        if (!in_array($imageType, $allowedTypes)) {
            echo "Invalid image format. Only JPEG, PNG, and GIF images are allowed.";
        } else {
            // Read the image file content
            $imageContent = file_get_contents($updateimage);

            // Prepare the SQL statement with placeholders
            $sql = "UPDATE account SET firstname=?, middlename=?, lastname=?, type=?, gender=?, address=?, birthday=?, pic=? WHERE id=?";
            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssssi", $updatefName, $updatemName, $updatelName, $updateposition, $updategender, $updateaddress, $updatebirthday, $imageContent, $updateStaffId);

            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                echo "Staff updated successfully";
                header("location: admin-staff.php");
                exit;

            } else {
                echo "Error updating staff: " . mysqli_error($connection);
            }

             // Close the prepared statement
             mysqli_stmt_close($stmt);

        }
    } else {
        // No image uploaded, update without image
        $sql = "UPDATE account SET firstname=?, middlename=?, lastname=?, type=?, gender=?, address=?, birthday=? WHERE id=?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssi", $updatefName, $updatemName, $updatelName, $updateposition, $updategender, $updateaddress, $updatebirthday, $updateStaffId);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Staff updated successfully";
            header("location: admin-staff.php");
            exit;
        } else {
            echo "Error updating staff: " . mysqli_error($connection);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    }
        
}


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['deleteProductBtn'])){
        $deleteStaffId = $_POST['deleteStaffId'];
        
        $sql = "DELETE from account where id=?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $deleteStaffId);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Staff deleted successfully";
            header("location: admin-staff.php");
                exit;
        } else {
            echo "Error updating staff: " . mysqli_error($connection);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staffs | University Hills</title>
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
            <a class="nav-link active" aria-current="page" href="admin-staff.php">Staff</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-comment.php">Comment</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-signup.php">Create Account</a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="admin-concern.php">Customer's Concerns</a>
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

    <style>
        .main-content{
            height: 100vh;
            overflow-x: hidden;
            padding-left: 5%;
        }
        .x{
            padding-top: 0;
        }
        h1{
            padding-top: 10px;
        }
        
    </style>
  
    <div class="main-content x">
        <div class="container-fluid">
            <h1>Staff</h1>

            <style>

                .empty{
                    width: 50%;
                    margin: 8%;
                    margin-left: 20%;

                }


            /*----------------------------------- */

                .search{
                    width: 50%;
                    float: left;
                    position: relative;
                    
                }
                .search .inputsearch{
        
                    position: relative;
                    z-index: 0;
                    width: 100%;
                    padding: 6px;
                    padding-left: 40px;
                    border-radius: 8px;
                    border: 1px solid #12171e ;
                    
                }

                .searchbutton{
                    position: absolute;
                    border: none;
                    width: 30px;
                }
                .search .inputsearch +  .searchbutton{
                    height: 90%;
                    left: 6px;
                    top: 0px;
                    margin: 2px;
                    cursor:pointer;
                    transition: 0.3s ease;
                    background-color: white;
                }
                .search .inputsearch:focus{
                    z-index: 0;
                    
                }

                .search .inputsearch:focus + .searchbutton,
                .search .inputsearch:valid + .searchbutton{
                    z-index: 1;
                }

                .refresh{
                    background-color: #12171e;
                    color: #EEEEEE;
                    width: 3%;
                    margin-left: 2px;
                    margin-bottom: 8px;
                }
                .refresh:hover{
                    background-color: white;
                    color: #12171e;
                    border: 1px solid #12171e;
                }
                /*----------------------------------- */
                .category{
                    width: 10%;
                    padding: 6px;
                    border-radius: 8px;
                    color: #12171e;
                    background-color: white;
                    margin-left: 30px;
                    border-color: #12171e;
                }
                .category:focus{
                    border: 2px solid #12171e;

                }

                .categoryoption{
                    border: #12171e solid ;
                    width: 800px;
                }
                .addbutton{
                    background-color: #12171e;
                    color: white;
                    border-radius: 8px;
                    padding: 6px;
                    width: 10%;
                    margin-left: 30px;
                    border: none;
                }

                .addbutton:hover{
                    background-color: white;
                    color: #12171e;
                    border: #12171e 2px solid;
                }
                
                .form1{
                    background-color:#EEEEEE;;
                    padding: 3px;
                    margin-top: 0px;
                }


                /*----------------*/
                .showprodbox {
                background-color: #E8DFCA;
                color: #12171e;
                padding: 1rem;
                border-radius: 10px;
                margin-top: 40px;
                float: left;
                margin-right: 2.5%;
                height: 450px;
                overflow: hidden;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 4px 8px rgba(0, 0, 0, 0.1);
                transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
            }

            .showprodbox:hover {
                box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3), 0 8px 16px rgba(0, 0, 0, 0.2);
            }

           

                .actionbutton{
                    margin-bottom: 5%;
                    margin-top: 3%;
                    padding-left: 85% ;

                }
                .actionbutton .edit{
                    color: #000000;

                }
                .actionbutton .delete{
                    color: red;
                }

                .crop-img{
                    max-width: 100%; 
                    max-height: 100%;
                    overflow: hidden;
                    border-radius: 10px;
                    border: 1px solid white; 
                
                }
                .prodimg{
                    width: 100%;
                    height: 250px;

                     
                }
                .details {
                margin-top: 10px;
                font-family: Arial, sans-serif;
                font-size: 18px;
                
            }

                .infodetail{
                    width: 97%;
                    height: 100px;
                    overflow-y: auto;
                    border: 1px solid white;

                    background-color: white;
                    color: #12171e;
                   
                }
                                   
                                    .productImagePreview{
                                        display: none;
                                        max-width: 50%;
                                        max-width: 50%;
                                        margin-top: 10px;
                                    }
                                    .updateproductImagePreview{
                                        max-width: 50%;
                                        max-width: 50%;
                                        margin-top: 10px;
                                    }

                                    .uploadimg{
                                        margin-bottom: 6%;
                                    }

                                    .deleteproductImagePreview{
                                        max-width: 50%;
                                        max-width: 50%;
                                        margin-top: 10px;
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

            <form action="" method="GET" class="form1 sticky-top">
                <div class="search">
                    <input type="text" class="inputsearch" name="search" placeholder="Search...">
                    <button type="submit" class=" searchbutton" name="searchbutton"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>

                <button class="refresh btn" id="refresh" name="refreshbtn">
                    <i class='bx bx-refresh'></i>
                </button>

                <select id="position" name="position" class="category" >
                    <option class="categoryoption" value="" disabled selected>Position</option>
                        <?php
                            $sql = "SELECT position_name FROM staff_positions";

                            $result = $connection->query($sql);
                            if(!$result){
                                die("Invalid query: ". $connection->connect_error);
                            }

                            while($row = $result->fetch_assoc()){
                                echo"
                                <option class='categoryoption' value='$row[position_name]'>$row[position_name]</option>
                                ";
                            }
                        ?>

                        <?php ob_end_flush(); ?>
                </select>

            
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary addbutton" data-bs-toggle="modal" data-bs-target="#categoryModal">
                        +Position
                </button>
                <button type="button" class="btn btn-primary addbutton" data-bs-toggle="modal" data-bs-target="#ProductModal">
                    +Staff
                </button>

            </form>


            <div class="container-fluid">
                <div class="row f" >
                    <div class="col-xl-12 c">
                        <div class="row">
                            
                         <?php

                $sql = "SELECT * FROM account where type='staff'";


                if(isset($_GET['searchbutton'])) {
                    $search = $_GET['search'];
                    $sql = "SELECT * FROM staff WHERE name LIKE '%$search%' OR position LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%'";
                }

                if(isset($_GET['refreshbtn'])){
                    $sql = "SELECT * FROM staff";
                    
                }


                $result = $connection->query($sql);
                if(!$result){
                    die("Invalid query: ". $connection->connect_error);
                }

                if($result->num_rows === 0) {
                    echo "
                       <div class='col-xl-12 colempty'>
                       <img class ='empty' src='Pic/empty.svg' alt=''>
                       </div
                    ";
                } else {

                while($row = $result->fetch_assoc()){
                    echo"
                    <div class='showprodbox col-sm-12 col-md-12 col-lg-4 col-xl-2'>
                    <div class='actionbutton'>";
                    ?>
                    <i  type='button' data-bs-toggle='modal' data-bs-target='#updateModal' class='fa-regular fa-pen-to-square edit' form='updateProductFormId' onclick="populateUpdateModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>','<?php echo $row['middlename']; ?>','<?php echo $row['lastname']; ?>', '<?php echo $row['type']; ?>', '<?php echo $row['gender']; ?>', '<?php echo $row['address']; ?>', '<?php echo $row['birthday']; ?>', '<?php echo base64_encode($row['pic']); ?>')"></i>
                    <i  type='button' data-bs-toggle='modal' data-bs-target='#deleteModal' class='fa-solid fa-trash delete' form='deleteProductFormId' onclick="populatedeleteModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>','<?php echo base64_encode($row['pic']); ?>')"></i>
                <?php
                     echo   
                     "
                
                    </div>
                    <div class='crop-img'>";
        
                    $imageData = $row['pic'];

                    // Convert binary data to base64 encoding
                    $base64Image = base64_encode($imageData);

                    // Generate a data URL to display the image
                    $dataURL = 'data:image/jpeg;base64,' . $base64Image;
                    
                    echo "                   
                    <img src='$dataURL' alt='' class='prodimg'>
                    </div>
                    <div class='details'>
                        <div class='namedetail'>Name: $row[firstname] $row[lastname]</div>
                        <div class='positiondetail'>Address: $row[address]</div>
                        <div class='emaildetail'>Birthday: $row[birthday] </div>
                        <div class='phonedetail'>Gender: $row[gender] </div>
                    </div>
                </div>";
                }
                }
            ?>

                        </div>
                    </div>
                </div>
            </div>



             <!--show products-->

             <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST['saveCategoryBtn'])) {
                        $positionname = $_POST['positionname'];
                        $sql = "INSERT INTO staff_positions (position_name) VALUES ('$positionname')";
                        if ($connection->query($sql) === TRUE) {
                            // Insertion successful, now fetch all categories again
                            $sql_fetch_positions = "SELECT position_name FROM staff_positions";
                            $result_positions = $connection->query($sql_fetch_positions);
                            if($result_positions) {
                                // Clear existing options
                                echo "<script>document.getElementById('position').innerHTML = ''; </script>";
                                // Add new options
                                while($row = $result_positions->fetch_assoc()){
                                    echo "<script>document.getElementById('position').innerHTML += \"<option class='categoryoption' value='{$row['position_name']}'>{$row['position_name']}</option>\";</script>";
                                }
                            }
                            echo " ";
                        } else {
                            echo "Error: " . $sql . "<br>" . $connection->error;
                        }
                    }
                }
            ?>

            


            <!-- Update Modal -->
            <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Staff</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateProductForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <input type="hidden" id="updateStaffId" name="updateStaffId">
                            <div class="mb-3">
                            <input type="text" class="form-control" id="updatefName" name="updatefName" placeholder="Firstname">
                            </div>

                            <div class="mb-3">
                            <input type="text" class="form-control" id="updatemName" name="updatemName" placeholder="Middlename">
                            </div>

                            <div class="mb-3">
                            <input type="text" class="form-control" id="updatelName" name="updatelName" placeholder="Lastname">
                            </div>

                            <div class="mb-3">
                                <select id="updateStaffPosition" name="updateStaffPosition" class="form-control">
                                    <option value="" disabled selected>Position</option>
                                    <option value='staff' >staff</option>;
                                    <option value='admin' >admin</option>;
                                </select>
                            </div>


                            

                            <div class="mb-3">
                                <select id="updategender" name="updategender" class="form-control">
                                    <option value="" disabled selected>Gender</option>
                                    <option value='male' >male</option>;
                                    <option value='female' >female</option>;
                                </select>
                            </div>

                                
                                <div class="mb-3 ">
                                    <input type="text" class="form-control" id="updateaddress" name="updateaddress" placeholder="Address">
                                </div>
                                <div class="mb-3 ">    
                                    <input type="date" class="form-control" id="updatebirthday" name="updatebirthday" placeholder="Birthday" required>
                                </div>
                                <br><br> 
                                <div class="mb-3 uploadimg">
                                    <input type="file" id="updateproductImageInput" class="form-control fileupload" accept="image/*" onchange="updatepreviewImage(event)" name="update_image">
                                    <img id="updateproductImagePreview" class="updateproductImagePreview" src="#" alt="Product Image Preview">
                                </div>
                                    
                            </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="updateProductBtn"  name="updateProductBtn" form="updateProductForm">Save changes</button>
                </div>
                </div>
            </div>
            </div>


            <!-- DELETE Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Staff</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="deleteProductForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <input type="hidden" id="deleteStaffId" name="deleteStaffId">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="deleteStaffName" disabled name="deleteStaffName" placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <img id="deleteproductImagePreview" class="deleteproductImagePreview" src="#" alt="Product Image Preview">
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary deleteproductImagePreview" id="deleteProductBtn" name="deleteProductBtn" form="deleteProductForm">Delete</button>
                </div>
                </div>
            </div>
            </div>

            <script>
            // Function to handle edit icon click
            function populateUpdateModal(staffId, stafName, stafmName, staflName, position, gender, address, bday, imageData) {
                // Populate values in the modal form fields
                document.getElementById('updateStaffId').value = staffId;
                document.getElementById('updatefName').value = stafName;
                document.getElementById('updatemName').value = stafmName;
                document.getElementById('updatelName').value = staflName;
                document.getElementById('updateStaffPosition').value = position;
                document.getElementById('updategender').value = gender;
                document.getElementById('updateaddress').value = address;
                document.getElementById('updatebirthday').value = bday;

                // Handle image preview if available
                if (imageData) {
                    document.getElementById('updateproductImagePreview').src = 'data:image/jpeg;base64,' + imageData;
                } else {
                    document.getElementById('updateproductImagePreview').src = ''; // Clear the preview if no image
                }
            }

             // Function to handle edit icon click
        function populatedeleteModal(staffId, staffName, imageData) {
                // Populate values in the modal form
                document.getElementById('deleteStaffId').value = staffId;
                document.getElementById('deleteStaffName').value = staffName;
                document.getElementById('deleteproductImagePreview').src = 'data:image/jpeg;base64,' + imageData;
        }

        function capitalizeFirstLetter(input) {
            return input.replace(/\b\w/g, function(char) { return char.toUpperCase(); });
        }

        document.getElementById('staffName').addEventListener('input', function() {
            this.value = capitalizeFirstLetter(this.value);

        });

        document.getElementById('positionname').addEventListener('input', function() {
            this.value = capitalizeFirstLetter(this.value);
        });

        document.getElementById('updateStaffName').addEventListener('input', function() {
            this.value = capitalizeFirstLetter(this.value);
        });


        // Add event listener to the Position Name input field
        document.getElementById('StaffPosition').addEventListener('input', function() {
            this.value = capitalizeFirstLetter(this.value);
        });

        </script>   

        <script>
            let btn = document.querySelector('#btn');
            let sidebar = document.querySelector('.sidebar');

            btn.onclick = function () {
                sidebar.classList.toggle('active');
            };
        </script>


        <script>
                function updatepreviewImage(event) {
                var image = document.getElementById('updateproductImagePreview');
                image.style.display = 'block';
                image.src = URL.createObjectURL(event.target.files[0]);
            }

        </script>


        <script>
                function previewImage(event) {
                var image = document.getElementById('productImagePreview');
                image.style.display = 'block';
                image.src = URL.createObjectURL(event.target.files[0]);
            }
        </script>

            
            

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

