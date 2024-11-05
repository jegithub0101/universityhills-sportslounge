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
     <title>Products | University Hills</title>
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="icon" href="Pic/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/sidebar.css">

    <style>

        *{
            font-family: Arial, sans-serif;
        }
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



        .inputsong{
            width: 30%;
            float: left;
            margin-right: 30px;
            
        }
        #songform{
            margin-top: 15px;
            margin-bottom: 0px;
        }
        #songform>.divsong{
            margin-left: 12%;
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

        @media only screen and (max-width: 992px) {
            
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


                /* General Navigation Tabs Styling */
            .nav-tabs {
                border-bottom: none;
                justify-content: center;
                background-color: #343a40; /* Dark background for the tab area */
                padding: 10px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                display: flex;
                flex-wrap: wrap;
                width: 95%;
            }

            .nav-link {
                color: #f8f9fa; /* White text for inactive tabs */
                font-weight: 600;
                font-size: 16px;
                padding: 12px 20px;
                margin: 0 10px;
                border: none;
                background-color: #6c757d; /* Gray background for inactive tabs */
                border-radius: 30px;
                transition: all 0.3s ease;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
                white-space: nowrap; /* Prevents text from wrapping */
            }

            .nav-link:hover {
                background-color: #495057; /* Darker gray for hover */
                color: #ffffff; /* Bright white for hover state */
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow on hover */
            }

            .nav-link.active {
                background-color: #212529; /* Darker for the active tab */
                color: #ffffff; /* White text for active tab */
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4); /* Stronger shadow for active */
            }

            .nav-link:focus {
                outline: none;
            }

            .tab {
                cursor: pointer;
            }

            /* Responsive Design for Mobile Devices */
            @media (max-width: 768px) {
                .nav-tabs {
                    flex-direction: column;
                    align-items: stretch; /* Make tabs stretch across the screen */
                }

                .nav-link {
                    width: 100%; /* Full-width tabs */
                    text-align: center; /* Center-align text */
                    margin: 5px 0; /* Add space between vertical tabs */
                    font-size: 18px; /* Increase font size for easier tapping */
                    padding: 15px; /* Larger tap area for mobile */
                }
            }

            /* Responsive Design for Extra Small Screens */
            @media (max-width: 480px) {
                .nav-link {
                    font-size: 16px; /* Slightly smaller font for very small screens */
                    padding: 12px; /* Adjust padding for smaller devices */
                }
            }



    </style>

</head>
<body>

    <?php
        require 'client-sidebar.php';
    ?>
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
    
    //--- DITO LUMALABAS YUNG INDEX
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
            }, 10000);
        }
        else if (button.innerText === "Drinks") {
            intervalId = setInterval(function() {
                loadXMLDoc('client-product-drinks.php');
            }, 10000);
        }
        else if (button.innerText === "Others") {
            intervalId = setInterval(function() {
                loadXMLDoc('client-product-others.php');
            }, 10000);
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
            // If no last clicked button exists, load default content
            loadContent('client-product-food.php', document.getElementById('food'));
        };

    //------------------------------------
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
    function reservePoolTable() {
    $.ajax({
        url: "client-billiard-reserve.php", // The PHP file handling the reservation
        type: "POST",
        data: {
            table_number: $("#table_number").val() // Assuming you have table number input
        },
        success: function(response) {
            alert(response); // Notify user about reservation status
            // Optionally, you could refresh only the reservation section instead of the whole page
            $('#billiard-tab').trigger('click'); // Keeps the user on the Billiard Reservation tab
        },
        error: function(xhr, status, error) {
            alert("Error: " + error); // Error handling
        }
    });
}

</script>



<script>
    // Function to cancel a reservation
    // Function to cancel a reservation
function cancelReservation(queueId) {
    var confirmCancel = confirm("Are you sure you want to cancel this reservation?");
    if (confirmCancel) {
        $.ajax({
            url: "cancel-reservation.php", // The PHP file handling cancellation
            type: "POST",
            data: {
                queue_id: queueId // Sending queue ID to cancel the reservation
            },
            success: function(response) {
                alert(response); // Notify user about the cancellation status
                // Optionally, you could refresh only the reservation section instead of the whole page
                $('#billiard-tab').trigger('click'); // Keeps the user on the Billiard Reservation tab
            },
            error: function(xhr, status, error) {
                alert("Error: " + error); // Error handling
            }
        });
    }
}

</script>


<!-- Include jQuery for AJAX -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function addToCart(pid) {
    // Get the form data
    var formData = $('#foodform_' + pid).serialize();

    // Perform AJAX request
    $.ajax({
        type: 'POST',
        url: 'handle_add_to_cart.php',  // This is the file handling the cart addition
        data: formData,
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === "success") {
                // Update button text and disable it
                $('#foodform_' + pid + ' .orderBtn').html('Added').prop('disabled', true).css('background-color', 'gray');
                $('#response_' + pid).html('<span style="color:green;">' + res.message + '</span>');
            } else {
                $('#response_' + pid).html('<span style="color:red;">' + res.message + '</span>');
            }
        },
        error: function() {
            $('#response_' + pid).html('<span style="color:red;">An error occurred.</span>');
        }
    });
}
</script>

</html>