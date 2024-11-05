<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

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

// Check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['table_number']);
}

// Redirect to login page if not logged in
if (!isLoggedIn()) {
    session_unset();
    session_destroy();
    header("Location: client-login.php");
    exit;
}

$table_number = $_SESSION['table_number'];
$table_name = $_SESSION['table_name'];

// Adjust this query according to your actual table structure
$sql_active = "SELECT active FROM customer WHERE table_number = $table_number AND nickname = '$table_name'";
$result_active = $connection->query($sql_active);

if ($result_active->num_rows > 0) {
    $row_active = $result_active->fetch_assoc();
    
    // Debugging output to check the value of active
    error_log("Active value for table number $table_number: " . $row_active['active']);

    // Check if active field is true (1) or not
    if ($row_active['active'] !== 'trues') { // Ensure you're comparing with an integer
        session_unset();
        session_destroy();

        session_start();
        $_SESSION['billout'] = true;
        $_SESSION['table_name'] = $table_name;
        header("Location: client-comment.php");
        
        exit;
    }
   
} else {
    // If no customer found, destroy session and redirect
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['billout'] = true;
    $_SESSION['table_name'] = $table_name;
    header("Location: client-comment.php");
    exit;
}

$_SESSION['billout'] = true;

// Your existing code to run the system goes here


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
    <link rel="icon" href="Pic/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/sidebar.css">

    <style>
        
        .prodimg{
            max-width: 120px;
        }
        
        .main-content{
            height: 100vh;
            overflow-x: hidden;
            padding-left: 1%;
            padding-right: 1%;
        } 

        /*
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
            } */
            /* .placeorder{
                position: absolute;
                bottom: 0px;
                height: 12%;
                width: 98%;
                background-color: #12171e;
            } */
            /* .btnorder{
                position: absolute;
                right: 50px;
                bottom: 30px;

            } */
            .total{
                color: black;
                text-align: center;
              
                font-size: 20pt;
            }
            .emptyword{
            font-size: 40pt;
            text-align: center;
        }
        #noResults {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%; /* Adjust as needed */
            text-align: center;
            padding: 20px;
        }

        .emptypic {
            width: 30%;
            margin: 0 auto;
            display: block;
        }

        @media only screen and (max-width: 992px) {
            .emptyword {
                font-size: 30pt;
            }
            .emptypic {
                width: 90%;
                margin: 0 auto;
            }


        }
        @media (max-width: 732px) {
            .navbar-brand{
                font-size: 13pt;
            }

        }

        @media (max-width: 767px) {
            .table-responsive {
                border: none;
            }

            .table-responsive .table thead {
                display: none;
            }

            .table-responsive .table tr {
                display: block;
                margin-bottom: 15px;
            }

            .table-responsive .table td {
                display: flex;
                align-items: center;
                text-align: left;
            }

            .table-responsive .table td:before {
                content: attr(data-label);
                font-weight: bold;
                text-transform: uppercase;
                margin-right: 10px;
                flex: 0 0 40%;
                font-size: 0.8rem;
            }

            .table-responsive .table td > span {
                margin-left: 10px; /* Adjust this value to move the data more or less */
            }
            .emptyword{
                font-size: 20pt;
            }

            }
            .fixed-order-section {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background-color: #fff;
                padding: 10px;
                box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .fixed-order-section .total {
                font-weight: bold;
                margin-right: 10px;
            }
            
        


        

    </style>

</head>
<body>
        <?php
            require 'client-sidebar.php';
        ?>
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

        <style>
            
            textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }
        
        </style>
  
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="whitcontainer">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="table-responsive">
                                <?php
                                if ($result->num_rows > 0) {
                                    ?>
                                     
                                     <div class="description" id="description-con">
                                        <textarea id="description" name="description" placeholder="Enter instructions. e.g. no mayo on sisig. (optional)" rows="4" cols="50"></textarea>
                                    </div>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                            
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Subtotal</th>
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
                                                        <td data-label='Image'> 
                                                            <img src='$dataURL' alt='' class='prodimg'>
                                                        </td>
                                                        <td data-label='Name'>" . $row["product_name"] . "  <input type='hidden' id='pid' value='$row[PID]'></td>";

                                                        $sql_stock = "SELECT stock FROM products WHERE PID = $row[PID]";
                                                        $result_stock = $connection->query($sql_stock);
                                                        $row_stock = $result_stock->fetch_assoc();
                                                    
                                                        $newqty = 0;
                                                        if($row_stock['stock'] >= $row['quantity']){
                                                            $newqty = $row['quantity'];
                                                        }
                                                        else if($row_stock['stock'] <= $row['quantity'] ){
                                                            
                                                        }


                                                        ?>
                                                        <td data-label='Quantity'>
                                                            <input class="orderquantity" type="number" name="quantity" value="<?php echo $newqty; ?>" min="0" max="<?php echo $row['stock']; ?>" onchange="updateQuantity(<?php echo $row['cart_id']; ?>, this.value)">
                                                        </td>

                                                        <?php
                                                    echo" 
                                                        <td data-label='price'>" . $row["price"] . "</td>
                                                        <td data-label='subtotal' class='subtotal'></td>
                                                        <td data-label='action'><button type='button' class='btn btn-danger' onclick='deleteCartItem(" . $row["cart_id"] . ")'>Delete</button></td>
                                                    </tr>";
                                            }
                                            
                                            ?>
                                        </tbody>
                                        
                                    </table>
                                <?php
                                }
                                else{
                                    echo "<p class='emptyword'></p>";
                                    echo " <img class='emptypic' src='Pic/emptycart.svg' alt=''>";

                                }
                                ?>
                            </div>
                        </div>
                        <div class="placeorder fixed-order-section">
                            <div class="total">Total: <span id="overall_total"></span></div>
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
                // Function to calculate subtotal and overall total
        function calculateTotals() {
            var rows = document.querySelectorAll("tbody tr");
            var overallTotal = 0;

            rows.forEach(function(row) {
                var quantity = parseInt(row.querySelector(".orderquantity").value);

                // Get the price and remove the peso sign for calculations
                var priceElement = row.cells[3];
                var price = parseFloat(priceElement.innerText.replace('₱', '')); // Assuming price is in the fourth column

                var subtotal = quantity * price;

                // Add the peso sign to the price and update it in the table
                priceElement.innerText = '₱' + price.toFixed(2);

                // Add the peso sign before the subtotal and update it in the table
                row.querySelector(".subtotal").innerText = '₱' + subtotal.toFixed(2);

                overallTotal += subtotal;
            });

            // Update the overall total with the peso sign
            document.getElementById("overall_total").innerText = '₱' + overallTotal.toFixed(2);
        }

        // Call calculateTotals initially to set up the totals
        calculateTotals();

    </script>

<script>
    document.getElementById("placeOrderBtn").addEventListener("click", function() {
    // Check if the cart is empty
    var description = document.getElementById("description").value;
    var rows = document.querySelectorAll("tbody tr");
    if (rows.length === 0) {
        alert("Your cart is empty. Please add items before placing an order.");
        return;
    }

    // Ask for confirmation before placing the order
    var confirmation = confirm("Are you sure you want to place this order?");
    if (!confirmation) {
        return; // If the user cancels, do nothing
    }

    // Show loading animation
    showLoading();

    // Check stock availability for each item in the cart
    var allItemsAvailable = true;
    var itemsProcessed = 0;
    rows.forEach(function(row) {
        var quantity = parseInt(row.querySelector(".orderquantity").value);
        var pid = parseInt(row.querySelector("#pid").value);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (!response.available) {
                        allItemsAvailable = false;
                    }
                    itemsProcessed++;
                    // If all items have been processed, check if all are available
                    if (itemsProcessed === rows.length) {
                        hideLoading();
                        if (!allItemsAvailable) {
                            alert("One or more items in your cart have insufficient stock. Please adjust your quantities.");
                        } else {
                            // If all items are available, proceed with placing the order
                            placeOrder(description);
                        }
                    }
                } else {
                    // Error handling if the request fails
                    alert('Failed to check stock availability. Please try again.');
                }
            }
        };
        xhr.open("GET", "check_stock.php?pid=" + pid + "&quantity=" + quantity, true);
        xhr.send();
    });
});

function showLoading() {
    // Show loading animation here
    // You can display a spinner or any loading indicator
}

function hideLoading() {
    // Hide loading animation here
}

function placeOrder(description) {
    // Proceed with placing the order
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Request successful, you can optionally redirect the user or show a success message
                alert('Order placed successfully!');
                // Clear the cart table
                var cartTableBody = document.querySelector("tbody");
                cartTableBody.innerHTML = "";
                // Update the overall total to zero
                document.getElementById("overall_total").innerText = "0.00";

                document.getElementById("description").value = "";
            } else {
                // Error handling if the request fails
                alert('Failed to place order. Please try again.');
            }
        }
    };
    xhr.open("GET", "process_orders.php?description=" + encodeURIComponent(description), true);
    xhr.send();
}


    // Function to handle delete button click
    function deleteCartItem(cartID) {
        // Ask for confirmation before deleting the item
        var confirmation = confirm("Are you sure you want to delete this item from your cart?");
        if (!confirmation) {
            return; // If the user cancels, do nothing
        }

        // If the user confirms, proceed with deleting the item
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Item deleted successfully, remove the row from the table
                    var rowToRemove = document.getElementById("cart_row_" + cartID);
                    if (rowToRemove) {
                        rowToRemove.remove();
                        calculateTotals(); // Recalculate totals after deleting the item
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
</script>


<script>
// Function to handle updating the quantity of an item in the cart
// Function to handle updating the quantity of an item in the cart
function updateQuantity(cartID, newQuantity) {
    // Check if the new quantity is 0
    if (parseInt(newQuantity) <= 0) {
        // Show an alert informing the user
        alert("0 and below is not a valid quantity!");
        
        // Set the quantity back to 1
        document.getElementById("cart_row_" + cartID).querySelector(".orderquantity").value = 1;
        
        return; // Exit the function
    }

    // Get the maximum stock available for the product
    var maxStock = parseInt(document.getElementById("cart_row_" + cartID).querySelector(".orderquantity").max);

    // Check if the new quantity exceeds the maximum stock
    if (parseInt(newQuantity) > maxStock) {
        // Show a dialog box informing the user
        alert("Maximum quantity is reached.");
        
        // Set the quantity to 1 instead of the maximum stock available
        document.getElementById("cart_row_" + cartID).querySelector(".orderquantity").value = 1;
        
        // Recalculate totals
        calculateTotals();
        
        return; // Exit the function
    }

    // If the new quantity is within the maximum stock, proceed with updating the quantity
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Quantity updated successfully
                calculateTotals(); // Recalculate totals after updating quantity
            } else {
                // Error updating quantity
                console.error("Error updating quantity: " + xhr.responseText);
            }
        }
    };
    xhr.open("POST", "update_quantity.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("cart_id=" + cartID + "&quantity=" + newQuantity);
}



</script>

</html>