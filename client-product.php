
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/sidebar.css">

    <style>
        .main-content{
            height: 100vh;
            overflow-x: hidden;
            padding-left: 5%;
            
        }
        
        h1{
            padding-top: 10px;
        }
        
    </style>

    <style>
        .nickname{
            border-bottom: 2px solid white;
            margin-bottom: 3%;
            padding-left: 25%;
            padding-right: 5%;
            padding-bottom: 12%;
        }
        .inputsong{
            width: 30%;
            float: left;
            margin-right: 30px;
            
        }
        #songform{
            margin-top: 15px;
            margin-bottom: 0px;
        }
        #songform{
            display: none;
        }
       
        .tab{
            background-color: white;
            color: black;
            font-weight: 600;
            margin-left: 1%;
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
            padding-left: 0%;
           
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
            .inputsong{
                width: 70%;
                margin-right:1%;
            }
            .rquestbtn{
                width: 25%;
                font-size: 10pt;
            }
            .foraccurate{
                font-size: 10pt;
                clear: both;
            }

        }
        @media only screen and (max-width: 840px) {
            .main-content{
                padding-left: 1%;
            }
        }

        @media only screen and (max-width: 732px){
            .navbar-brand{
                font-size: 13pt;
            }
            .tab{
                background-color: white;
                color: black;
                font-weight: 600;
                margin-top: 10px;
                border: 1px solid #12171e;
                width: 66px;
                font-size: 9pt;
                text-align: center;
            }
            .main-content{
                padding-left: 10px;
                padding-right: 0%;
                
            }
        }
        @media only screen and (max-width: 380px){
            .tab{
                background-color: white;
                width: 60px;
                font-size: 9pt;
                padding-left: 13px;
                
            }
        }
        @media only screen and (max-width: 320px){
            .tab{
                background-color: white;
                width: 54px;
                font-size: 9pt;
                padding-left: 9px;
                
            }
        }

      

        .sticky-cart {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 1000;
                background-color: #007bff;
                color: #fff;
                width: 60px;
                height: 60px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: background-color 0.3s, box-shadow 0.3s;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            }
            .sticky-cart:hover {
                background-color: #0056b3;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            }


    </style>

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
                    <a class="nav-link active" aria-current="page" href="client-product.php">Client Panel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="client-cart.php">My Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="client-order.php">Orders</a>
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
  
    <div class="main-content">
        <div class="container-fluid">


        

        <?php


        // Check if the order add button is clicked
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['orderBtn'])) {
            $pid = $_POST['pid'];
            $product_name = $_POST['pname'];
            $price = $_POST['pprice'];
            $pstock = $_POST['pstock'];
            $table_number =  $_SESSION['table_number'];
        
            $sql_tid = "SELECT cid FROM customer WHERE table_number = ? and nickname = ?";
            $stmt_tid = $connection->prepare($sql_tid);
            if (!$stmt_tid) {
                echo "Error preparing statement: " . $connection->error;
                exit;
            }
            $stmt_tid->bind_param("is", $table_number, $_SESSION['table_name']);
            if (!$stmt_tid->execute()) {
                echo "Error executing statement: " . $stmt_tid->error;
                exit;
            }
            $result_tid = $stmt_tid->get_result();
            
            if ($result_tid->num_rows > 0) {
                // Fetch the result
                $row_tid = $result_tid->fetch_assoc();
                $cid = $row_tid['cid'];
            } else {
                echo "No matching record found in the customer table.";
                exit;
            }

            //end ng submit button for food
            
        
            
            // Insert data into the database
            $sql = "INSERT INTO customer_cart (cid, pid, table_number, product_name, price, quantity, stock) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $quantity = 1; // Assuming 1 for example, replace it with your actual value
            $stmt->bind_param("iiisiii", $cid, $pid, $table_number, $product_name, $price, $quantity, $pstock);
        
        
        
            if ($stmt->execute()) {
                echo "";
            } else {
                echo "Error: " . $stmt->error;
            }
        
            $stmt->close();
        
            
        }
        
        ?>
       

<!--End ng song form-->
    
            <div class="col-xl-12 c ">
                <div class="row ">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                        <div class="row">
                            <nav>
                                
                                <div class="nav nav-tabs sticky-top" id="nav-tab" role="tablist">
                                    
                                    <button  onclick="showFoodForm(); loadContent('client-product-food.php', this)" class="nav-link tab" id="food" data-bs-toggle="tab"  type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Foods</button>
                                    <button onclick="showFoodForm(); loadContent('client-product-drinks.php', this)" class="nav-link tab" id="drinks" data-bs-toggle="tab"  type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Drinks</button>

                                    <button onclick="showFoodForm(); loadContent('client-product-others.php', this)" class="nav-link tab" id="others" data-bs-toggle="tab"  type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Others</button>

                                    <button onclick="showSongForm(); loadContent('uh_server/client-song-server.php', this)" class="nav-link tab" id="song" data-bs-toggle="tab"  type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Song</button>
                                    <button onclick="showBilliardForm(); loadContent('client-billiard.php', this)" class="nav-link tab" id="billiard" data-bs-toggle="tab"  type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Billiard</button>
                                    
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <form id="songform" method="POST" action="">
                <h2 class="text-center">Song Requests</h2>
                <p class="text-center"><i>(Song requests have a 4-minute cooldown.)</i></p>
                    <div class="form-group divsong">
                        <input type="text" class="form-control inputsong" id="songrequest" placeholder="Starboy by The Weeknd" name="songrequest" maxlength="100" required>
                        
                        <button type="submit" class="btn btn-primary rquestbtn" id="savesongBtn">Request</button>
                        <p class="foraccurate"><i>For accurate song requests, please include the artist.<br>Example: Starboy by The Weeknd</i></p>
                    </div>
                </form>
                <div id="link_wrapper"></div>
            </div>
        </div>
    </div>

    <div class="sticky-cart" id="cartButton">
    <i class="fas fa-shopping-cart"></i>
</div>
    
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // JavaScript to handle cart button interactions (if any)
    // For example, you can add a click event listener to show a cart modal, etc.
    document.getElementById('cartButton').addEventListener('click', function() {
        // Your cart functionality here
        window.location.href = 'client-cart.php'
    });
</script>



</body>


 <script>
   function populateorder(productId, productName, price,stock) {
                // Populate values in the modal form
                document.getElementById('pid').value = productId;
                document.getElementById('pname').value = productName;
                document.getElementById('pprice').value = price;
                document.getElementById('pstock').value = stock;
        }
 </script>


<script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function () {
        sidebar.classList.toggle('active');
    };
</script>


<script>
    function showFoodForm(){
        //once I click the food form, magtatago yung songform.
        var songForm = document.getElementById('songform');
            songForm.style.display = 'none';
    }
     function showSongForm() {
        //magvivisible yung songform
            var songForm = document.getElementById('songform');
            songForm.style.display = 'block';
        }
    function showBilliardForm(){
        //once I click the food form, magtatago yung songform.
        var songForm = document.getElementById('songform');
            songForm.style.display = 'none';
    }
</script>


<script>
    
    var intervalId; 
    function loadContent(filename, button) {
        // Clear previous interval
        clearInterval(intervalId);
        // Load content
        loadXMLDoc(filename);
        // Set interval only if "Food" button is clicked
        localStorage.setItem('lastClickedButtonId', button.id);

        if (button.innerText === "Foods") {
            intervalId = setInterval(function() {
                loadXMLDoc('client-product-food.php');
            }, 1000);
        }
        else if (button.innerText === "Drinks") {
            intervalId = setInterval(function() {
                loadXMLDoc('client-product-drinks.php');
            }, 1000);
        }
        else if (button.innerText === "Others") {
            intervalId = setInterval(function() {
                loadXMLDoc('client-product-others.php');
            }, 1000);
        }

       
        else if (button.innerText === "Song") {
            intervalId = setInterval(function() {
                loadXMLDoc('uh_server/client-song-server.php');
            }, 1000);
        }
        else if (button.innerText === "Billiard") {
            intervalId = setInterval(function() {
                loadXMLDoc('client-billiard.php');
            }, 1000);
        }
    }

    function loadXMLDoc(filename) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        document.getElementById("link_wrapper").innerHTML =
        this.responseText;
        }
    };
    xhttp.open("GET", filename, true);
    xhttp.send();
    }

    // On page load
    window.onload = function() {
            var lastClickedButtonId = localStorage.getItem('lastClickedButtonId'); // Retrieve the ID of the last clicked button from local storage
            var lastClickedButton = document.getElementById(lastClickedButtonId); // Get the button element using its ID
            if (lastClickedButton) {
                // If a last clicked button exists, load its content
                loadContent(lastClickedButton.getAttribute('data-filename'), lastClickedButton);
            } else {
                // If no last clicked button exists, load default content
                loadContent('client-product-food.php', document.getElementById('food'));
            }
        };
</script>




<script>

    // Function to handle song request submission
    document.getElementById("songform").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent form submission

        // Get song request data
        var songRequest = document.getElementById("songrequest").value;

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Define the request parameters
        xhr.open("POST", "insert_song_request.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Define callback function for when the request is complete
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Song request submitted successfully
                    console.log("Song request submitted successfully");
                    // You can add any additional actions here
                } else {
                    // Error submitting song request
                    console.error("Error submitting song request: " + xhr.responseText);
                }
            }
        };

        // Send the request with the song request data
        xhr.send("songrequest=" + encodeURIComponent(songRequest));
        document.getElementById("songrequest").value = "";
    });
</script>


<script>
     // Function to reserve a pool table
     function reservePoolTable() {
            var confirmReserve = confirm("Are you sure you want to reserve a pool table?");
            if (confirmReserve) {
                // Send AJAX request to reserve pool
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "client-billiard-reserve.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Handle response
                        alert(xhr.responseText);
                        // Refresh the page to update the reservation table and queue list
                        location.reload();
                    }
                };
                xhr.send();
            }
        }

        // Add event listener to reserve button
        document.getElementById("reserve-btn").addEventListener("click", reservePoolTable);
</script>


<script>
    // Function to cancel a reservation
    function cancelReservation(queueId) {
        var confirmCancel = confirm("Are you sure you want to cancel this reservation?");
        if (confirmCancel) {
            // Send AJAX request to cancel reservation
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "cancel-reservation.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle response
                    alert(xhr.responseText);
                    // Refresh the page to update the queue list
                    location.reload();
                }
            };
            // Send queue_id and table_number in the request data
            var formData = "queue_id=" + queueId;
            xhr.send(formData);
        }
    }

</script>


</html>