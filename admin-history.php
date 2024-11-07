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
    <title>History | University Hills</title>
    <link rel="icon" href="Pic/uhicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-straight/css/uicons-bold-straight.css'>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="icon" href="Pic/logo.svg" type="image/x-icon">
    <style>
        

        .main-content{
            height: 100vh;
            overflow-x: hidden;
        }

    </style>
        

    <style>
        /* Add custom styles here */
        body {
            background-color: #f8f9fa; /* Set background color */
        }
        .container {
            max-width: 800px; /* Set maximum width for content */
        }
    </style>

    <style>

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

        .button-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .left-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }

        button {
            width: 160px;  /* Common width */
            height: 45px;  /* Common height */
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            line-height: 45px;  /* Vertically align text */
        }

        button:hover {
            background-color: #3e8e41;
        }

        #sortDate {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 160px; /* Match button width */
            height: 45px; /* Match button height */
            max-width: 100%;
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #333;
            background-color: #fff; 
            text-align: center;
            box-sizing: border-box; /* Ensure proper padding/spacing */
        }

        #payment-table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #payment-table th, #payment-table td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            font-family: Arial, sans-serif;
        }

        #payment-table th {
            background-color: #f0f0f0;
        }

        #payment-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #clearTableBtn {
            background-color: #dc3545;
            color: #fff;
            margin-left: 5px; /* Add space to the left */
        }

        /* Responsive Design for Tablets and Small Screens */
        @media only screen and (max-width: 768px) {
            .container {
                margin: 15px auto;
                max-width: 100%;
            }

            #payment-table {
                font-size: 14px;
            }

            #sortDate {
                width: 100%;
                margin: 10px 0;
            }
        }

        /* Responsive Design for Mobile Phones */
        @media only screen and (max-width: 480px) {
            .button-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .left-buttons {
                width: 100%;  /* Full width for better alignment */
                margin-bottom: 10px;
                font-family: Arial, sans-serif;
                font-size: 16px;
            }

            button {
                width: 100%;  /* Full width for buttons */
                margin-top: 10px;
                height: 45px;  /* Common height */
            }

            #sortDate {
                width: 100%;  /* Full width for the date input */
                margin-top: 10px;
                height: 45px;  /* Common height */
                font-family: Arial, sans-serif;
            }

            #payment-table {
                font-size: 12px;
            }

            #clearTableBtn {
                width: 100%;  /* Full width for the Clear button */
                margin-top: 10px;
                height: 45px;  /* Common height */
            }
            }

            .name {
                font-family: Arial, sans-serif;
                font-size: 35px;
                text-align: center;  /* Horizontally center the text */
                margin-bottom: 10px; /* Add space below the header */
                margin-top: 12px;

            }


    </style>

</head>
<body>

    <?php   
        require 'admin-sidebar.php';
    ?>

<div class="main-content">
    <h1 class="name">Admin History</h1>
    <div class="container mt-4">
        <div class="button-container">
            <div class="left-buttons">
                <label for="sortDate">Sort by Date:</label>
                <input type="date" id="sortDate" name="sortDate">
                <button class="btn btn-primary" id="sortBtn">Sort</button>
                <button class="btn btn-success" id="showAllBtn">Show All</button>
            </div>
            <button class="btn btn-danger" id="clearTableBtn">Clear All</button>
        </div>
        <table id="payment-table">
            <thead>
                <tr>
                    <th>Payment Tracking No</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody id="tableBody">
            <!-- Records will be displayed here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Fetch records using AJAX
    $(document).ready(function(){
        fetchRecords(); // Initial fetch

        // Clear table button click event
        $('#clearTableBtn').click(function(){
            if(confirm('Are you sure you want to clear the table?')){
                // Call clear_records.php to delete records
                $.ajax({
                    url: 'clear_records.php',
                    type: 'POST',
                    success: function(response){
                        // Clear table after successful deletion
                        $('#tableBody').empty();
                        alert(response); // Show success message
                    },
                    error: function(xhr, status, error){
                        console.error(xhr.responseText);
                        alert('Error deleting records'); // Show error message
                    }
                });
            }
        });

        // Function to fetch records
        function fetchRecords() {
            $.ajax({
                url: 'fetch_records.php', // PHP script to fetch records from database
                type: 'GET',
                dataType: 'json',
                success: function(response){
                    if(response && response.length > 0) {
                        // Populate table with fetched records
                        $.each(response, function(index, record) {
                            $('#tableBody').append(
                                '<tr>' +
                                '<td>' + record.payment_trackingno + '</td>' +
                                '<td>' + record.pid + '</td>' +
                                '<td>' + record.product_name + '</td>' +
                                '<td>' + record.quantity + '</td>' +
                                '<td>' + record.date + '</td>' +
                                '<td>' + record.time + '</td>' +
                                '</tr>'
                            );
                        });
                    } else {
                        $('#tableBody').html('<tr><td colspan="6">No records found</td></tr>');
                    }
                },
                error: function(xhr, status, error){
                    console.error(xhr.responseText);
                    $('#tableBody').html('<tr><td colspan="6">Error fetching records</td></tr>');
                }
            });
        }

        // Add event listener to the sort button
        $('#sortBtn').click(function(){
            // Retrieve the selected date
            var sortDate = $('#sortDate').val();

            // Check if a date is selected
            if (!sortDate) {
                alert("Please select a date to sort.");
                return; // Exit the function if no date is selected
            }

            // Send AJAX request to fetch sorted records
            $.ajax({
                url: 'fetch_records.php', // Modify URL as needed
                type: 'GET',
                data: { sortDate: sortDate }, // Pass selected date as parameter
                dataType: 'json',
                success: function(response){
                    // Clear existing table rows
                    $('#tableBody').empty();

                    // Populate table with sorted records
                    if (response && response.length > 0) {
                        $.each(response, function(index, record) {
                            $('#tableBody').append(
                                '<tr>' +
                                '<td>' + record.payment_trackingno + '</td>' +
                                '<td>' + record.pid + '</td>' +
                                '<td>' + record.product_name + '</td>' +
                                '<td>' + record.quantity + '</td>' +
                                '<td>' + record.date + '</td>' +
                                '<td>' + record.time + '</td>' +
                                '</tr>'
                            );
                        });
                    } else {
                        $('#tableBody').html('<tr><td colspan="6">No records found for the selected date.</td></tr>');
                    }
                },
                error: function(xhr, status, error){
                    console.error(xhr.responseText);
                    $('#tableBody').html('<tr><td colspan="6">Error fetching sorted records</td></tr>');
                }
            });
        });
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
    // Add event listener to the show all button
$('#showAllBtn').click(function(){
    // Send AJAX request to fetch all records
    $.ajax({
        url: 'fetch_records.php',
        type: 'GET',
        dataType: 'json',
        success: function(response){
            // Clear existing table rows
            $('#tableBody').empty();

            // Populate table with all records
            $.each(response, function(index, record) {
                $('#tableBody').append(
                    '<tr>' +
                    '<td>' + record.payment_trackingno + '</td>' +
                    '<td>' + record.pid + '</td>' +
                    '<td>' + record.product_name + '</td>' +
                    '<td>' + record.quantity + '</td>' +
                    '<td>' + record.date + '</td>' +
                    '<td>' + record.time + '</td>' +
                    '</tr>'
                );
            });
        },
        error: function(xhr, status, error){
            console.error(xhr.responseText);
            $('#tableBody').html('<tr><td colspan="5">Error fetching records</td></tr>');
        }
    });
});

</script>
</html>