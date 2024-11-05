
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


//check connection
if($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateProductBtn'])) {
    // Retrieve form data
    $updateProductId = $_POST['updateProductId'];
    $updateproductName = $_POST['updateproductname'];
    $updateproductCategory = $_POST['updateproductcategory'];
    $updateproductInformation = $_POST['updateproductinformation'];
    $updateproductPrice = $_POST['updateproductprice'];
    $updateproductStocks = $_POST['updateproductstocks'];

    // Check if image file is uploaded
    if (isset($_FILES['update_image']) && $_FILES['update_image']['error'] === UPLOAD_ERR_OK) {
        $updateimage = $_FILES['update_image']['tmp_name'];

        // Validate image type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $imageType = $_FILES['update_image']['type'];

        if (!in_array($imageType, $allowedTypes)) {
            echo "Invalid image format. Only JPEG, PNG, and GIF images are allowed.";
        } else {
            // No image uploaded, update without image
           
            // Read the image file content
            $imageContent = file_get_contents($updateimage);

            // Prepare the SQL statement with placeholders
            $sql = "UPDATE products SET product_name=?, category=?, information=?, price=?, stock=?, image=? WHERE PID=?";
            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, "ssssisi", $updateproductName, $updateproductCategory, $updateproductInformation, $updateproductPrice, $updateproductStocks, $imageContent, $updateProductId);

            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                echo "Product updated successfully";
                header("location: admin-product.php");
                exit;

            } else {
                echo "Error updating product: " . mysqli_error($connection);
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
        }
    } else {
        $sql = "UPDATE products SET product_name=?, category=?, information=?, price=?, stock=? WHERE PID=?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "ssssii", $updateproductName, $updateproductCategory, $updateproductInformation, $updateproductPrice, $updateproductStocks, $updateProductId);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Product updated successfully";
            header("location: admin-product.php");
            exit;
        } else {
            echo "Error updating product: " . mysqli_error($connection);
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
    <title>Products | University Hills</title>
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
            <a class="nav-link active"href="admin-product.php">Products</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin-billiard.php">Billiads</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin-song.php">Song</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" aria-current="page"href="admin-order.php">Orders</a>
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
            <h1>Product</h1>

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
                    margin-left: 15px;
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
                    margin-left: 0px;
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

                .showprodbox{
  
                    background-color: #12171e;
                    color: white;
                    padding: 0% 0.5% 1% 1%;
                    border-radius: 10px ;
                    margin-top: 40px;
                    float: left;
                    margin-right: 2.5%;
                    height: 500px;
                    overflow:hidden;
                    
                    
                    
                }
                .actionbutton{
                    margin-bottom: 5%;
                    margin-top: 5%;
                    padding-left: 80% ;

                }
                .actionbutton .edit{
                    color: #50D9E1;

                }
                .actionbutton .delete{
                    color: red;
                }

                .crop-img{
                    max-width: 95%; 
                    max-height: 230px;
                    overflow: hidden;
                    border-radius: 10px;
                    border: 1px solid white; 
                
                }
                .prodimg{
                    width: 100%;
                    height: 250px;

                     
                }
                .details{
                    margin-top: 10px;
                }
                .infodetail{
                    width: 97%;
                    height: 100px;
                    overflow-y: auto;
                    border: 1px solid white;

                    background-color: white;
                    color: #12171e;
                   
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

                <select id="gender" name="gender" class="category" >
                    <option class="categoryoption" value="" disabled selected>Category</option>
                    <option class="categoryoption" value="Drinks">Drinks</option>
                    <option class="categoryoption" value="Foods">Foods</option>   
                    
                        <?php
                            $sql = "SELECT category_name FROM product_category";

                            $result = $connection->query($sql);
                            if(!$result){
                                die("Invalid query: ". $connection->connect_error);
                            }

                            while($row = $result->fetch_assoc()){
                                echo"
                                <option class='categoryoption' value='$row[category_name]'>$row[category_name]</option>
                                ";
                            }
                        ?>

                        <?php ob_end_flush(); ?>
                </select>

            <br>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary addbutton" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    Add Category
                </button>
                <button type="button" class="btn btn-primary addbutton" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal">
                    Delete Category
                </button>
                <button type="button" class="btn btn-primary addbutton" data-bs-toggle="modal" data-bs-target="#ProductModal">
                    Add Products
                </button>
                <button type="button" class="btn btn-primary addbutton" data-bs-toggle="modal" data-bs-target="#TableModal">
                    Add Table
                </button>
                <button type="button" class="btn btn-primary addbutton" data-bs-toggle="modal" data-bs-target="#deleteTableModal">
                    Delete Table
                </button>

            </form>

            


        
            <div class="container-fluid">
                <div class="row f" >
                    <div class="col-xl-12 c">
                        <div class="row">
                            
                         <?php

                $sql = "SELECT * FROM products";


                if(isset($_GET['searchbutton'])) {
                    $search = $_GET['search'];
                    $sql = "SELECT * FROM products WHERE product_name LIKE '%$search%' OR category LIKE '%$search%' OR information LIKE '%$search%' OR price LIKE '%$search%' OR stock LIKE '%$search%'";
                }

                if(isset($_GET['refreshbtn'])){
                    $sql = "SELECT * FROM products";
                    
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
                    <i  type='button' data-bs-toggle='modal' data-bs-target='#updateModal' class='fa-regular fa-pen-to-square edit' form='updateProductFormId' onclick="populateUpdateModal('<?php echo $row['PID']; ?>', '<?php echo $row['product_name']; ?>', '<?php echo $row['category']; ?>', '<?php echo $row['information']; ?>', '<?php echo $row['price']; ?>', '<?php echo $row['stock']; ?>','<?php echo base64_encode($row['image']); ?>')"></i>
                <?php
                     echo   
                     "
                
                    </div>
                    <div class='crop-img'>";
        
                    $imageData = $row['image'];

                    // Convert binary data to base64 encoding
                    $base64Image = base64_encode($imageData);

                    // Generate a data URL to display the image
                    $dataURL = 'data:image/jpeg;base64,' . $base64Image;
                    
                    echo "                   
                    <img src='$dataURL' alt='' class='prodimg'>
                    </div>
                    <div class='details'>
                        <div class='namedetail'>Name: $row[product_name]</div>
                        <div class='categorydetail'>Category: $row[category]</div>
                        <div class='stockdetail'>Stocks: $row[stock] </div>
                        <div class='pricedetail'>Price: $row[price] </div>
                        <div class='infodetail'>Information: $row[information] </div>
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
                        $categoryname = $_POST['categoryName'];
                        $sql = "INSERT INTO product_category (category_name, item_number) VALUES ('$categoryname', '1')";
                        if ($connection->query($sql) === TRUE) {
                            // Insertion successful, now fetch all categories again
                            $sql_fetch_categories = "SELECT category_name FROM product_category";
                            $result_categories = $connection->query($sql_fetch_categories);
                            if($result_categories) {
                                // Clear existing options
                                echo "<script>document.getElementById('gender').innerHTML = ''; </script>";
                                // Add new options
                                while($row = $result_categories->fetch_assoc()){
                                    echo "<script>document.getElementById('gender').innerHTML += \"<option class='categoryoption' value='{$row['category_name']}'>{$row['category_name']}</option>\";</script>";
                                }
                            }
                            echo "";
                        } else {
                            echo "Error: " . $sql . "<br>" . $connection->error;
                        }
                    }
                }
            ?>


                
                <!-- Modal -->
                <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="categoryForm" method="POST" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-3">
                                    <label for="categoryName" class="form-label" name="categoryname">Category Name:</label>
                                    <input type="text" class="form-control" id="categoryName" name="categoryName">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveCategoryBtn" name="saveCategoryBtn" form="categoryForm">Save</button>
                        </div>
                        </div>
                    </div>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="TableModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Table</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="tableForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="mb-3">
                                        <label for="code" class="form-label">Code</label>
                                        <input type="text" class="form-control" id="code" name="code" placeholder="Code">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="saveTableBtn" name="saveTableBtn">Save</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- PHP Validation for Adding Tables -->
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST['saveTableBtn'])) {
                        // Fetch the latest table number from the database
                        $latest_table_query = "SELECT MAX(table_number) AS latest_table FROM tables";
                        $latest_table_result = $connection->query($latest_table_query);
                        $latest_table_row = $latest_table_result->fetch_assoc();
                        $new_table_number = $latest_table_row['latest_table'] + 1;

                        // Validate input
                        $code = $_POST['code'];

                        if (!empty($code)) {
                            // Sanitize input to prevent SQL injection
                            $code = mysqli_real_escape_string($connection, $code);

                            // SQL query to insert data into the database
                            $sql = "INSERT INTO tables (table_number, verification_code,flag) VALUES ('$new_table_number', '$code','false')";
                            
                            if ($connection->query($sql) === TRUE) {
                                echo "<script>alert('New table has been added!');</script>";
                            } else {
                                echo "Error: " . $sql . "<br>" . $connection->error;
                            }
                        } else {
                            echo "<script>alert('Please fill in the code field.');</script>";
                        }
                    }
                }
                ?>






                <!-- Modal -->
                <div class="modal fade" id="ProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Products</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="ProductForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="productname" name="productname" placeholder="Name">
                            </div>

                            <div class="mb-3">
                                <select id="productcategory" name="productcategory" class="form-control">
                                    <option value="" disabled selected>Category</option>
                                    <option class="" value="Drinks">Drinks</option>
                                    <option class="" value="Foods">Foods</option>   
                                    <?php
                                        // Fetch categories from the database and populate the dropdown
                                        $sql = "SELECT category_name FROM product_category";
                                        $result = $connection->query($sql);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row["category_name"] . "' >" . $row["category_name"] . "</option>";
                                            }
                                        }

                                    ?>
                                </select>
                            </div>
                            
                                <div class="mb-3">
                                    <textarea type="text" class="form-control" id="productinformation" name="productinformation" placeholder="Description"></textarea>
                                </div>

                                <style>
                                    .price, .stocks{
                                        width: 40%;
                                        float: left;
                                    }
                                    .stocks{
                                        margin-left: 3%;
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
                                </style>

                            

                                    <div class="mb-3 ">
                                        <input type="number" class="form-control price" id="productprice" name="productprice" placeholder="Price">
                                        <input type="number" class="form-control stocks" id="productstocks" name="productstocks" placeholder="stocks">
                                    </div>
                                    <br><br>
                                    
                                    <?php
                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                                        if(isset($_POST['saveProductBtn'])){
                                        // Retrieve form data
                                        $productName = $_POST['productname'];
                                        $productCategory = $_POST['productcategory'];
                                        $productInformation = $_POST['productinformation'];
                                        $productPrice = $_POST['productprice'];
                                        $productStocks = $_POST['productstocks'];
                                        $image = $_FILES['image']['tmp_name'];


                                     


                                        

                                    
                                        // Check if file is uploaded
                                        if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

                                            $image = $_FILES['image']['tmp_name'];
                                            $imageName = $_FILES['image']['name'];
                                    
                                            // Validate image type
                                            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                                            $imageType = $_FILES['image']['type'];

                                            $points = 1;
                                            $status = "available";

                                            if (!in_array($imageType, $allowedTypes)) {
                                                $error_messages[] = "Invalid image format. Only JPEG, PNG, and GIF images are allowed.";
                                            } else{
                                                 // Read the image file content
                                                $imageContent = file_get_contents($image);

                                                 // Insert data into the database
                                                 $sql = "INSERT INTO products (product_name, category, information, price, stock, image, status ,points) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                                                 $stmt = $connection->prepare($sql);

                                                 $stmt->bind_param("sssiissi", $productName, $productCategory, $productInformation, $productPrice, $productStocks, $imageContent,$status, $points);

                                               // Execute the statement
                                                                                
                                                if ($stmt->execute()) {
                                                    // Product added successfully
                                                    echo "<script>
                                                            var newProductHTML = `<div class='showprodbox col-sm-12 col-md-12 col-lg-4 col-xl-2'>
                                                                <div class='actionbutton'>
                                                                    <i type='button' data-bs-toggle='modal' data-bs-target='#updateModal' class='fa-regular fa-pen-to-square edit' form='updateProductFormId' onclick=\"populateUpdateModal('$stmt->insert_id', '$productName', '$productCategory', '$productInformation', '$productPrice', '$productStocks', '" . base64_encode($imageContent) . "')\"></i>
                                                                </div>
                                                                <div class='crop-img'>
                                                                    <img src='data:image/jpeg;base64," . base64_encode($imageContent) . "' alt='' class='prodimg'>
                                                                </div>
                                                                <div class='details'>
                                                                    <div class='namedetail'>Name: $productName</div>
                                                                    <div class='categorydetail'>Category: $productCategory</div>
                                                                    <div class='stockdetail'>Stocks: $productStocks</div>
                                                                    <div class='pricedetail'>Price: $productPrice</div>
                                                                    <div class='infodetail'>Information: $productInformation</div>
                                                                </div>
                                                            </div>`;
                                                            document.querySelector('.container-fluid .row.f .col-xl-12.c .row').innerHTML += newProductHTML;
                                                        </script>";



                                                        $_POST['productname'] = "";
                                                        $_POST['productcategory'] = "";
                                                        $_POST['productinformation'] = "";
                                                        $_POST['productprice'] = "";
                                                        $_POST['productstocks'] = "";
                                                        unset($_FILES['image']);

                                                        $productName = '';
                                                        $productCategory = '';
                                                        $productInformation = '';
                                                        $productPrice = '';
                                                        $productStocks = '';
                                                        $image = '';

                                                        mysqli_stmt_close($stmt);
                                                } else {
                                                    echo "Error: " . $sql . "<br>" . $connection->error;
                                                }
                                            }

                                        } else {
                                            echo "Error: File not uploaded";
                                        }
                                        }
                                    }                                    
                                    ?>

                                    <div class="mb-3 uploadimg">
                                        <input type="file" id="productImageInput" class="form-control fileupload" accept="image/*" onchange="previewImage(event)" name="image">
                                        <img id="productImagePreview" class="productImagePreview" src="#" alt="Product Image Preview">
                                    </div>
                                    
                                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="confirmClose()">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveProductBtn" name="saveProductBtn" form="ProductForm">Insert</button>
                </div>
                </div>
            </div>
            </div>

            <!-- Modal FOR DELETE TABLE -->
            <div class="modal fade" id="deleteTableModal" tabindex="-1" aria-labelledby="deleteTableModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteTableModalLabel">Delete Table</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="deleteTableForm">
                                <div class="mb-3">
                                    <label for="tableToDelete" class="form-label">Select Table Number:</label>
                                    <select class="form-select" id="tableToDelete" name="tableToDelete">
                                        <option value="" disabled selected>Select Table Number</option>
                                        <!-- PHP code to fetch and display table numbers -->
                                        <?php
                                        $sql = "SELECT table_number FROM tables";
                                        $result = $connection->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row['table_number'] . "'>" . $row['table_number'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteTableBtn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Category Modal -->
            <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <select id="categoryToDelete" name="categoryToDelete" class="form-select">
                                <option value="" disabled selected>Select Category</option>
                                <option value="Drinks">Drinks</option>
                                <option value="Foods">Foods</option>
                                <!-- PHP code to fetch categories from the database -->
                                <?php
                                $sql = "SELECT category_name FROM product_category";
                                $result = $connection->query($sql);
                                if (!$result) {
                                    die("Invalid query: " . $connection->connect_error);
                                }
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='$row[category_name]'>$row[category_name]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Modal -->
            <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Products</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateProductForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                            <input type="hidden" id="updateProductId" name="updateProductId">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="updateproductname" name="updateproductname" placeholder="Name">
                            </div>

                            <div class="mb-3">
                                <select id="updateproductcategory" name="updateproductcategory" class="form-control">
                                    <option value="" disabled selected>Category</option>
                                    <option class="categoryoption" value="Drinks">Drinks</option>
                                    <option class="categoryoption" value="Foods">Foods</option>   
                                    <?php
                                        // Fetch categories from the database and populate the dropdown
                                        $sql = "SELECT category_name FROM product_category";
                                        $result = $connection->query($sql);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row["category_name"] . "' >" . $row["category_name"] . "</option>";
                                            }
                                        }

                                    ?>
                                </select>
                                </div>
                                <div class="mb-3">
                                    <textarea type="text" class="form-control" id="updateproductinformation" name="updateproductinformation" placeholder="Description"></textarea>
                                </div>

                                <div class="mb-3">
                                    <input type="number" class="form-control price" id="updateproductprice" name="updateproductprice" placeholder="Price" min="0">
                                    <input type="number" class="form-control stocks" id="updateproductstocks" name="updateproductstocks" placeholder="stocks" min="0">
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
                    <button type="button" class="btn btn-danger" id="deleteProductBtn">Delete Product</button>

                    <button type="submit" class="btn btn-primary" id="updateProductBtn"  name="updateProductBtn" form="updateProductForm">Save changes</button>
                </div>
                </div>
            </div>
            </div>


            <!-- DELETE Modal
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deleteProductForm" method="POST" action="#">
                    <input type="hidden" id="deleteProductId" name="deleteProductId">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="deleteproductname" disabled name="deleteproductname" placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <img id="deleteproductImagePreview" class="deleteproductImagePreview" src="#" alt="Product Image Preview">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary deleteproductImagePreview" id="deleteProductBtn">Delete</button>
            </div>
        </div>
    </div>
</div> -->

        
            <script>
            // Function to handle edit icon click
            function populateUpdateModal(productId, productName, category, information, price, stocks, imageData) {
                // Populate values in the modal form
                document.getElementById('updateProductId').value = productId;
                document.getElementById('updateproductname').value = productName;
                document.getElementById('updateproductcategory').value = category;
                document.getElementById('updateproductinformation').value = information;
                document.getElementById('updateproductprice').value = price;
                document.getElementById('updateproductstocks').value = stocks;
                document.getElementById('updateproductImagePreview').src = 'data:image/jpeg;base64,' + imageData;
            }

             // Function to handle edit icon click
        // function populatedeleteModal(productId, productName, imageData) {
        //         // Populate values in the modal form
        //         document.getElementById('deleteProductId').value = productId;
        //         document.getElementById('deleteproductname').value = productName;
        //         document.getElementById('deleteproductImagePreview').src = 'data:image/jpeg;base64,' + imageData;
        // }
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

            <!-- Validation for Updating Products -->
            <script>
                document.getElementById('updateProductBtn').addEventListener('click', function(event) {
                    var priceInput = document.getElementById('updateproductprice');
                    var stockInput = document.getElementById('updateproductstocks');

                    if (!isNumeric(priceInput.value) || !isNumeric(stockInput.value)) {
                        alert('Price and stock must be numeric values.');
                        event.preventDefault(); // Prevent form submission
                        return false;
                    }

                    if (priceInput.value < 0 || stockInput.value < 0) {
                        alert('Price and stock must be non-negative values.');
                        event.preventDefault(); // Prevent form submission
                        return false;
                    }

                    // Ask for confirmation before proceeding
                    var confirmation = confirm("Are you sure you want to update the product?");
                    if (!confirmation) {
                        event.preventDefault(); // Prevent form submission
                        return false;
                    }

                    return true; // Allow form submission
                });

                // Function to check if input is numeric
                function isNumeric(value) {
                    return !isNaN(parseFloat(value)) && isFinite(value);
                }

            </script>

            <!-- Delete Table Script -->
            <script>
                document.getElementById('confirmDeleteTableBtn').addEventListener('click', function() {
                    var selectedTable = document.getElementById('tableToDelete').value;
                    if (selectedTable) {
                        if (confirm("Are you sure you want to delete this table number?")) {
                            // Proceed with deletion
                            // You can perform AJAX request or form submission here to delete the selected table
                            // Example AJAX request:
                            $.ajax({
                                type: "POST",
                                url: "delete_table.php",
                                data: { tableNumber: selectedTable },
                                success: function(response) {
                                    // Handle success response here
                                    alert(response);
                                    $('#deleteTableModal').modal('hide');
                                },
                                error: function(xhr, status, error) {
                                    // Handle error
                                    alert("An error occurred while deleting the table number.");
                                    console.error(xhr.responseText);
                                }
                            });
                        } else {
                            // Do nothing or handle cancellation
                            console.log("Deletion canceled.");
                        }
                    } else {
                        alert("Please select a table number to delete.");
                    }
                });
            </script>

            <!-- Delete Category Script -->
            <script>
                document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                    var selectedCategory = document.getElementById('categoryToDelete').value;
                    if (selectedCategory) {
                        if (confirm("Are you sure you want to delete this category?")) {
                            // Proceed with deletion
                            $.ajax({
                                type: "POST",
                                url: "delete_category.php",
                                data: { categoryName: selectedCategory },
                                success: function(response) {
                                    // Handle success response here
                                    alert(response);
                                    $('#deleteCategoryModal').modal('hide');
                                    // Optionally, you can perform additional actions after successful deletion
                                    // For example, you may want to update the UI to reflect the deletion
                                },
                                error: function(xhr, status, error) {
                                    // Handle error
                                    alert("An error occurred while deleting the category.");
                                    console.error(xhr.responseText);
                                }
                            });
                        } else {
                            // Do nothing or handle cancellation
                            console.log("Deletion canceled.");
                        }
                    } else {
                        alert("Please select a category to delete.");
                    }
                });
            </script>

            <!-- Add Category Validation -->
            <script>
                // Function to validate category name input
                function validateCategory() {
                    var categoryNameInput = document.getElementById('categoryName');

                    if (categoryNameInput.value.trim() === "") {
                        alert('Please enter a category name.');
                        return false;
                    }
                    return true;
                }

                // Event listener for "Save" button in category modal
                document.getElementById('saveCategoryBtn').addEventListener('click', function(event) {
                    if (!validateCategory()) {
                        event.preventDefault(); // Prevent form submission
                    }
                });
            </script>

            <!-- Inserting Products Validation -->
            <!-- Event listener for "Insert" button click -->
            <script>
                document.getElementById('saveProductBtn').addEventListener('click', function(event) {
                    // Call the validateProduct() function before form submission
                    if (!validateProduct()) {
                        event.preventDefault(); // Prevent form submission
                    }
                });

                // Function to validate product input fields
                function validateProduct() {
                    var productNameInput = document.getElementById('productname');
                    var productCategoryInput = document.getElementById('productcategory');
                    var productInformationInput = document.getElementById('productinformation');
                    var productPriceInput = document.getElementById('productprice');
                    var productStocksInput = document.getElementById('productstocks');
                    var productImageInput = document.getElementById('productImageInput');

                    if (productNameInput.value.trim() === "" ||
                        productCategoryInput.value === "" ||
                        productInformationInput.value.trim() === "" ||
                        productPriceInput.value === "" ||
                        productStocksInput.value === "" ||
                        productImageInput.files.length === 0) {
                        alert('Please fill in all fields and select an image.');
                        return false;
                    }

                    if (!isNumeric(productPriceInput.value) || !isNumeric(productStocksInput.value)) {
                        alert('Price and stock must be numeric values.');
                        return false;
                    }

                    if (productPriceInput.value < 0 || productStocksInput.value < 0) {
                        alert('Price and stock must be non-negative values.');
                        return false;
                    }

                    // File type validation
                    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.svg|\.webp)$/i;
                    if (!allowedExtensions.exec(productImageInput.value)) {
                        alert('Please select a file with one of the following extensions: .jpg, .jpeg, .png, .svg, .webp');
                        productImageInput.value = '';
                        return false;
                    }

                    return true;
                }

                // Function to check if input is numeric
                function isNumeric(value) {
                    return !isNaN(parseFloat(value)) && isFinite(value);
                }
            </script>





            <!-- Validation for Adding Tables -->
            <script>
                // Function to validate table input fields
                function validateTable() {
                    var tablesInput = document.getElementById('tables');
                    var codeInput = document.getElementById('code');

                    if (tablesInput.value.trim() === "" || codeInput.value.trim() === "") {
                        alert('Please fill in all fields.');
                        return false;
                    }

                    if (!(/^\d+$/.test(tablesInput.value.trim())) || parseInt(tablesInput.value) < 1) {
                        alert('Table number should be a positive integer.');
                        return false;
                    }

                    return true;
                }

                // Event listener for "Save" button in table modal
                document.getElementById('saveTableBtn').addEventListener('click', function(event) {
                    if (!validateTable()) {
                        event.preventDefault(); // Prevent form submission
                    }
                });
            </script>


            <!-- Script for Close button in Adding Products -->
            <script>
                function confirmClose() {
                    var productNameInput = document.getElementById('productname');
                    var productCategoryInput = document.getElementById('productcategory');
                    var productInformationInput = document.getElementById('productinformation');
                    var productPriceInput = document.getElementById('productprice');
                    var productStocksInput = document.getElementById('productstocks');
                    var productImageInput = document.getElementById('productImageInput');

                    // Check if any of the fields have been modified
                    if (productNameInput.value.trim() !== "" ||
                        productCategoryInput.value !== "" ||
                        productInformationInput.value.trim() !== "" ||
                        productPriceInput.value !== "" ||
                        productStocksInput.value !== "" ||
                        productImageInput.files.length > 0) {
                        // If fields are changed, ask for confirmation
                        if (!confirm("Are you sure you want to close without saving changes?")) {
                            return; // If user cancels, do not close the modal
                        }
                    }

                    // If no changes or user confirms, close the modal and reset fields
                    productNameInput.value = '';
                    productCategoryInput.value = '';
                    productInformationInput.value = '';
                    productPriceInput.value = '';
                    productStocksInput.value = '';
                    productImageInput.value = ''; // Reset file input (clear selected file)
                    
                    var modalElement = document.getElementById('ProductModal');
                    var modal = bootstrap.Modal.getInstance(modalElement);
                    modal.hide();
                }
            </script>


<script>
    document.getElementById("deleteProductBtn").addEventListener("click", function() {
        if (confirm("Are you sure you want to delete this product?")) {
            // If user confirms deletion, submit the form to delete_product.php
            var productId = document.getElementById("updateProductId").value;
            var formData = new FormData();
            formData.append("deleteProductId", productId);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_product.php", true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    // Reload the page after deletion
                    window.location.reload();
                } else {
                    alert("Error: " + xhr.statusText);
                }
            };
            xhr.send(formData);
        }
    });
</script>

</body>
</html>