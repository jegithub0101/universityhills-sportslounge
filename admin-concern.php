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




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concerns | University Hills</title>
    <link rel="icon" href="Pic/uhicon.png" type="image/x-icon" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="Pic/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-straight/css/uicons-bold-straight.css'>
    <link rel="stylesheet" href="css/sidebar.css">


    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .clearbtn {
            float: right;
            margin-bottom: 2%;
        }

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
        padding: 5% 0% 0% 0%;
        }

    }

        @media only screen and (min-width: 1200px) {
            .container {
            padding: 5% 0% 0% 10%;
            }
        } 

        body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
    }

    .container {
        font-family: Arial, sans-serif;
        max-width: 1500px;
        margin: 30px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    /* Table styles */
    .table-margin {
        margin-top: 20px;
    }

    .clearbtn {
        text-align: right; /* Align the button to the right */
        margin-bottom: 10px;
        font-family: Arial, sans-serif;
    }

    #clear-all-btn {
        background-color: #dc3545;
        font-family: Arial, sans-serif;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #clear-all-btn:hover {
        background-color: #c82333;
        font-family: Arial, sans-serif;
    }

    .table {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
        
    }

    .table th, .table td {
        padding: 15px;
        text-align: center;
        border: 1px solid #ddd;
        font-family: Arial, sans-serif;
        
    }

    .table th {
        background-color: #f0f0f0;
        font-family: Arial, sans-serif;
    }

    .table-striped tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Responsive Design for Tablets and Small Screens */
    @media only screen and (max-width: 768px) {
        .container {
            margin: 15px auto;
            max-width: 100%;
        }

        #clear-all-btn {
            width: 100%;
            margin-top: 10px;
            font-family: Arial, sans-serif;
        }

        .table th, .table td {
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
    }

    /* Responsive Design for Mobile Phones */
    @media only screen and (max-width: 480px) {
        .container {
            padding: 15px;
        }

        .clearbtn {
            text-align: center; /* Center the button on mobile */
            font-family: Arial, sans-serif;
        }

        #clear-all-btn {
            width: 100%;
            margin-top: 10px;
            font-family: Arial, sans-serif;
        }

        .table th, .table td {
            font-size: 12px;
            padding: 10px;
        }
    }

    .name {
        font-family: Arial, sans-serif;
        font-size: 35px;
        text-align: center;  /* Horizontally center the text */
        margin-bottom: 10px; /* Add space below the header */
        margin-top: 10px;

    }

    </style>
</head>
<body>
    <?php   
        require 'admin-sidebar.php';
    ?>
<div class="main-content">
        <h1 class="name">Customer Concerns</h1>
        <div class="container mt-4">
        <div class="table-margin">
            <div class="clearbtn">
                <button class="btn btn-danger" id="clear-all-btn">Clear All</button>
            </div>
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>Date and Time</th>
                        <th>Table Number</th>
                        <th>Concern</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch concerns from the database
                    $sql = "SELECT * FROM concerns";
                    $result = mysqli_query($connection, $sql);

                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Format the date and time
                                $formatted_date_time = date("M j, Y g:ia", strtotime($row["date_time"]));
                                echo "<tr>";
                                echo "<td>" . $formatted_date_time . "</td>";
                                echo "<td>" . $row["table_number"] . "</td>";
                                echo "<td>" . $row["concern"] . "</td>";
                                echo "<td><button class='btn btn-primary done-btn' data-cid='" . $row["CID"] . "'>Done</button></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No concerns found.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Error fetching concerns.</td></tr>";
                    }

                    // Close connection
                    mysqli_close($connection);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        $(document).ready(function() {
            // Remove button click event
            $(document).on('click', '.done-btn', function() {
                var cid = $(this).data('cid');
                var confirmRemove = confirm("Are you sure you want to remove this concern?");
                if (confirmRemove) {
                    removeConcern(cid);
                }
            });

            // Clear All button click event
            $('#clear-all-btn').click(function() {
                var confirmClearAll = confirm("Are you sure you want to clear all concerns?");
                if (confirmClearAll) {
                    clearAllConcerns();
                }
            });

            function removeConcern(cid) {
                $.ajax({
                    url: 'admin-concern-remove.php',
                    type: 'POST',
                    data: {cid: cid},
                    success: function(response) {
                        // alert(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function clearAllConcerns() {
                $.ajax({
                    url: 'admin-concern-clear.php',
                    type: 'POST',
                    success: function(response) {
                        // alert(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
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