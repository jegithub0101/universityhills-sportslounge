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
    <link rel="icon" href="Pic/logo.svg" type="image/x-icon">
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
    <?php
        require 'client-sidebar.php';
    ?>

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

    <style>

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2; /* Same background as admin history */
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 50px;
            padding: 20px;
        }

        .uhlogo img {
            width: 150px;
            height: auto;
            border-radius: 50%; /* Make logo circular */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background-color: #ffffff; /* White background for the card */
        }

        .card-body {
            padding: 30px;
        }

        .card-title {
            font-family: Arial, sans-serif;
            font-size: 30px;
            text-align: center;  /* Horizontally center the text */
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 18px;
            
            color: #333;
        }

        textarea.form-control {
            border-radius: 5px;
            border: 1px solid #555555; /* Green border */
            padding: 15px;
            font-size: 16px;
            background-color: #e7e7e7; color: black;
            transition: border-color 0.3s ease-in-out;
        }

        textarea.form-control:focus {
            border-color: #45a049; /* Darker green on focus */
            background-color: #ffffff; /* White background on focus */
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5); /* Green shadow on focus */
        }

        button.btn-primary {
            background-color: #555555; /* Change to a blue background */
            border-color: #555555; /* Blue border */
            width: 20%; /* Button width */
            margin: 10px auto; /* Center align the button */
            padding: 10px 0; /* Vertical padding for the button */
            font-family: Arial, sans-serif;
            font-size: 18px; /* Font size */

            border-radius: 5px; /* Slightly rounded corners */
            transition: background-color 0.3s ease-in-out; /* Smooth transition on hover */
            color: #ffffff; /* White text color */
            display: block; /* Make the button a block element for centering */
        }

        button.btn-primary:hover {
            background-color: #e7e7e7; color: black;
        }

        @media only screen and (max-width: 768px) {
            .card {
                margin: 15px;
            }

            .card-body {
                padding: 20px;
            }

            button.btn-primary {
                font-size: 16px;
            }
        }

        .name {
            font-family: Arial, sans-serif;
            font-size: 15px;
            text-align: left;  /* Keep text left-aligned */
        }
    </style>

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
                                <label for="concernTextarea" class = "name">Enter Your Concern:</label>
                                <textarea class="name form-control" id="concernTextarea" name="concern" rows="5" required></textarea>
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