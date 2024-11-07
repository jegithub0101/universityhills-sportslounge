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

// Query the data from the tables
$sql = "SELECT table_number, verification_code FROM tables";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table | University Hills</title>

    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>
  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-straight/css/uicons-bold-straight.css'>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="icon" href="Pic/logo.svg" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5; /* Light gray on hover */
        }

        .bg-light {
            background-color: #f8f9fa; /* Light gray for even rows */
        }

        .bg-white {
            background-color: #ffffff; /* White for odd rows */
        }

        .main-content {
            height: 100vh;
            overflow-x: hidden;
            padding-left: 5%;
        }
       
        h1 {
            padding-top: 10px;
        }

        .navbar {
            display: none;
        }

        @media only screen and (max-width: 992px) {
            .sidebar {
                display: none;
            }

            .main-content {
                top: 50px;
                left: 0px;
                width: 100%;
            }

            .navbar {
                display: block;
                background-color: #12171e;
            }

            .navbar-toggler {
                height: 30px;
                padding-top: 0px;
            }

            .navbar-toggler-icon {
                font-size: 8pt;
                margin-top: 0px;
            }

            h1 {
                font-size: 2.5rem; 
            }
        }

        @media (max-width: 576px) { 
            h1 {
                font-size: 1.8rem; 
            }

            .table {
                font-size: 0.9rem; 
            }

            .btn {
                font-size: 0.8rem; 
            }
        }

        /* Custom table container for responsive design */
        .table-responsive-wrapper {
            overflow-x: auto;
        }

        /* Apply scrollbar only below 430px width */
        @media (max-width: 430px) {
            .table-responsive-wrapper {
                overflow-x: scroll;
            }
        }
    </style>
</head>
<body>
    <?php
        require 'staff-sidebar.php';
    ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div id="link_wrapper" class="table-responsive-wrapper">
                        <!-- Table goes here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadXMLDoc() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("link_wrapper").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "admin-table-server.php", true);
            xhttp.send();
        }

        setInterval(function(){
            loadXMLDoc();
        }, 1000);

        window.onload = loadXMLDoc;
    </script>

    <script>
        function generateCode(tid, tableNumber, button) { 
            var verificationElement = $('#verification-' + tableNumber);
            
            $.ajax({
                url: 'generate-code.php', 
                type: 'POST',
                data: { tid: tid },
                success: function(response) {
                    verificationElement.text(response);
                    alert('Change verification code of table ' + tableNumber + '?');
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                    alert('Error generating code. Please try again.');
                }
            });
        }
    </script>

    <script>
        let btn = document.querySelector('#btn');
        let sidebar = document.querySelector('.sidebar');

        btn.onclick = function () {
            sidebar.classList.toggle('active');
        };
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
