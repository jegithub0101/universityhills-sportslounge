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



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | University Hills</title>
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
        
        .navbar{
            display:none
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
                width: 100%;
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

            <li class="nav-item">
            <a class="nav-link" href="staff-orders.php">Orders</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="staff-bills.php">Bills</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="staff-billiard.php">Billiads</a>
            </li>


            <li class="nav-item">
            <a class="nav-link" href="staff-song.php">Song</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="staff-assist.php">Staff Assist</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="staff-assist.php">Cart</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="staff-logout.php">Logout</a>
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
                <a href="staff-concern.php">
                <i class="fa-solid fa-exclamation-triangle"></i>
                    <span class="nav-item">Concerns</span>
                </a>
                <span class="tooltip">Customer's Concerns</span>
            </div>

            <div class="lii">
                <a href="staff-logout.php">
                <i class='bx bx-log-out' ></i>
                    <span class="nav-item">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
            </div>

    </div>
        <?php

        $table_number =  $_SESSION['table_number'];
        $table_name = $_SESSION['table_name'];

        $sql_cid = "SELECT cid FROM customer WHERE table_number = $table_number and nickname = '$table_name'";
        $result_cid = $connection->query($sql_cid);
        $row_cid = $result_cid->fetch_assoc();
        $cid = $row_cid['cid'];


        


        // Fetch products from the database
        $sql = "SELECT * FROM customer_cart where cid = $cid";
        $result = $connection->query($sql);

        
        ?>
  
    <div class="main-content">
        <div class="container-fluid">
            <h1>Cart</h1>
            <div class="row">
                <div class="whitcontainer">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                    <th>Instruction</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while ($row = $result->fetch_assoc()) {
                                    
                                    $sql_quantity = "SELECT pid FROM products WHERE pid=$row[PID]";
                                    $result_quantity = $connection->query($sql_quantity);
                                    $row_quantity = $result_quantity->fetch_assoc();


                                    // Fetch products from the database
                                        $image_pid = "SELECT image FROM products where pid = $row[PID]";
                                        $result_img = $connection->query($image_pid);
                                        $row_img = $result_img->fetch_assoc();

                                        $imageData = $row_img['image'];

                                        // Convert binary data to base64 encoding
                                        $base64Image = base64_encode($imageData);

                                        // Generate a data URL to display the image
                                        $dataURL = 'data:image/jpeg;base64,' . $base64Image;
                                                    
                                
                                    echo "<tr id='cart_row_" . $row["cart_id"] . "'> 
                                            <td> 
                                                <img src='$dataURL' alt='' class='prodimg'>
                                            </td>
                                            <td>" . $row["product_name"] . $row["product_name"] . "  <input type='hidden' id='pid' value='$row[PID]'></td>";
                                            ?>
                                        <td>
                                                <input class="orderquantity" type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1" max="<?php echo $row['stock']; ?>" onchange="this.form.submit()">
                                            </td>

                                            <?php
                                        echo" 
                                            <td>" . $row["price"] . "</td>
                                            <td class='subtotal'></td>
                                            <td> <input type='text'>  </td>
                                            <td><button type='button' class='btn btn-danger' onclick='deleteCartItem(" . $row["cart_id"] . ")'>Delete</button></td>
                                        </tr>";
                                }
                                
                                ?>
                            </tbody>
                            
                        </table>  
                    </div>

                    
                    <div class="placeorder">
                    

                        <div class="total">Total: <span id="overall_total"></span>
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
                                </label>
                    </div>
                        
                            
                        <button class="btn btn-primary btnorder" id="placeOrderBtn">Place Order</button>
                        
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

<script>
        // Function to handle delete button click
        function deleteCartItem(cartID) {
            // Send an AJAX request to delete the item from the cart
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Item deleted successfully, remove the row from the table
                        var rowToRemove = document.getElementById("cart_row_" + cartID);
                        if (rowToRemove) {
                            rowToRemove.remove();
                        }
                    } else {
                        // Error deleting item
                        console.error("Error deleting item: " + xhr.responseText);
                    }
                }
            };
            xhr.open("POST", "client_cart_delete.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("cart_id=" + cartID);
        }



                // Function to calculate subtotal and overall total
        function calculateTotals() {
            var rows = document.querySelectorAll("tbody tr");
            var overallTotal = 0;

            rows.forEach(function(row) {
                var quantity = parseInt(row.querySelector(".orderquantity").value);
                var price = parseFloat(row.cells[3].innerText); // Assuming price is in the fourth column
                var subtotal = quantity * price;
                row.querySelector(".subtotal").innerText = subtotal.toFixed(2);
                overallTotal += subtotal;
            });

            // Update the overall total
            document.getElementById("overall_total").innerText = overallTotal.toFixed(2);
        }

        // Attach onchange event listener to quantity inputs
        var quantityInputs = document.querySelectorAll(".orderquantity");
        quantityInputs.forEach(function(input) {
            input.addEventListener("change", function() {
                calculateTotals();
                this.form.submit(); // Submit the form after updating quantity
            });
        });

        // Call calculateTotals initially to set up the totals
        calculateTotals();

    </script>

    <script>
        document.getElementById("placeOrderBtn").addEventListener("click", function() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Request successful, you can optionally redirect the user or show a success message
                        alert('Order placed successfully!');
                    } else {
                        // Error handling if the request fails
                        alert('Failed to place order. Please try again.');
                    }
                }
            };
            xhr.open("GET", "process_orders.php", true);
            xhr.send();
        });
    </script>




    <script>
        document.getElementById("placeOrderBtn").addEventListener("click", function() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Request successful, you can optionally redirect the user or show a success message
                        
                        // Clear the cart table
                        var cartTableBody = document.querySelector("tbody");
                        cartTableBody.innerHTML = "";
                        // Update the overall total to zero
                        document.getElementById("overall_total").innerText = "0.00";
                    } else {
                        // Error handling if the request fails
                        alert('Failed to place order. Please try again.');
                    }
                }
            };
            xhr.open("GET", "process_orders.php", true);
            xhr.send();
        });
    </script>





</html>