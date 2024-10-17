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
    $updateStaffName = $_POST['updateStaffName'];
    $updateStaffPosition = $_POST['updateStaffPosition'];
    $updateStaffEmail = $_POST['updateStaffEmail'];
    $updateStaffPhone = $_POST['updateStaffPhone'];

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
            $sql = "UPDATE staff SET name=?, position=?, email=?, phone=?, image=? WHERE SID=?";
            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, "sssssi", $updateStaffName, $updateStaffPosition, $updateStaffEmail, $updateStaffPhone, $imageContent, $updateStaffId);

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
        $sql = "UPDATE staff SET name=?, position=?, email=?, phone=?, image=? WHERE SID=?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "sssssi", $updateStaffName, $updateStaffPosition, $updateStaffEmail, $updateStaffPhone, $imageContent, $updateStaffId);
        
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
        
        $sql = "DELETE from staff where SID=?";
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
<style>
.card-container {
    display: flex;
    flex-wrap: nowrap; /* Prevents wrapping to the next line */
    justify-content: flex-start;
    gap: 20px;
    padding: 20px;
    overflow-x: auto; /* Enables horizontal scrolling if cards exceed the container width */
}

.card {
    flex: 0 0 auto; /* Ensures cards maintain their defined width */
    max-width: 250px;
    min-width: 200px;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    display: flex;
    flex-direction: column;
}

.card:hover {
    transform: translateY(-5px);
}

.card-img-top {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card-body {
    padding: 15px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.card-title {
    font-size: 18px;
    margin-bottom: 10px;
}

.card-text {
    font-size: 14px;
    margin-bottom: 5px;
}

@media (max-width: 1200px) {
    .card {
        flex: 0 0 auto; /* Keeps cards from resizing on medium screens */
    }
}

@media (max-width: 900px) {
    .card {
        flex: 0 0 auto; /* Keeps cards from resizing on smaller screens */
    }
}

@media (max-width: 600px) {
    .card {
        flex: 0 0 auto; /* Keeps cards from resizing on mobile */
    }
}
</style>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "university_hills";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get records with type 'staff'
$sql = "SELECT firstname, lastname, address, birthday, gender, pic FROM account WHERE type = 'staff'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through the records
    while($row = $result->fetch_assoc()) {
        // Display data in a card layout
        echo "<div class='card'>";
        echo "<img src='data:image/jpeg;base64,".base64_encode($row['pic'])."' alt='Profile Picture' class='card-img-top'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</h5>";
        echo "<p class='card-text'><strong>Address:</strong> " . htmlspecialchars($row['address']) . "</p>";
        echo "<p class='card-text'><strong>Birthday:</strong> " . htmlspecialchars($row['birthday']) . "</p>";
        echo "<p class='card-text'><strong>Gender:</strong> " . htmlspecialchars($row['gender']) . "</p>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No staff members found.</p>";
}


$conn->close();
?>

            <script>
            // Function to handle edit icon click
            function populateUpdateModal(staffId, staffName, position, email, phone, imageData) {
                // Populate values in the modal form
                document.getElementById('updateStaffId').value = staffId;
                document.getElementById('updateStaffName').value = staffName;
                document.getElementById('updateStaffPosition').value = position;
                document.getElementById('updateStaffEmail').value = email;
                document.getElementById('updateStaffPhone').value = phone;
                document.getElementById('updateproductImagePreview').src = 'data:image/jpeg;base64,' + imageData;
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

