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


// Retrieve feedback data
$query = "SELECT * FROM feedback";
$result = mysqli_query($connection, $query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks | University Hills</title>
    <link rel="icon" href="Pic/uhicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-straight/css/uicons-bold-straight.css'>

    <link rel="icon" href="Pic/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/sidebar.css">


    <style>
        .main-content{
            height: 100vh;
            overflow-x: hidden;
            padding-left: 5%;
        }

        .mesa{
        
        width: 100%;
        margin-bottom: 1rem;
        background-color: white;
        border-collapse: collapse;
        }

                /* For table-bordered */
    .table-bordered {
        border-radius: 5px; /* Rounded corners */
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6; /* Standard border between cells */
        padding: 12px; /* More padding for better readability */
    }

    /* For table-striped */
    .table-wipe tbody tr:nth-of-type(odd) {
        background-color: #f2f2f2; /* Light gray background for odd rows */
    }

    /* Custom hover effect for table rows */
    .table-wipe tbody tr:hover {
        background-color: #e9ecef; /* Light gray hover effect */
        cursor: pointer;
    }

    /* Header styling */
    .table-bordered thead th {
        /* Dark background for headers */
        /* White text in headers */
        text-align: center; /* Centered header text */
        font-weight: bold;
    }

    /* Optional: Change the font style */
    .table-bordered {
        font-size: 14px; /* Font size */
    }

            .main-content{
                position: relative;
                background-color: #eee;
            
                top:0;
                left:80px;
                transition: all 0.5s ease;
                width: calc(100% - 80px);
                padding: 1rem;
            }
           
           

                .main-content{
                    position: relative;
                    background-color: #eee;
                    min-height: 100vh;
                    top:0;
                    left:80px;
                    transition: all 0.5s ease;
                    width: calc(100% - 80px);
                    padding: 1rem;
                }
                .navbar{
                    display:none
                }


                @media only screen and (max-width: 992px) {
                    .main-content{
                    top:50px;
                    left:0px;
                    width: 100%;
                    }

                    }

                        .table thead th,
                        .table tbody td {
                    background-color: beige;
                    }
                    
            </style>

</head>
<body>

    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
    }

    .container-fluid {
        max-width: 1500px;
        margin: 30px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    h1 {
        font-family: Arial, sans-serif;
        font-size: 35px;
        text-align: center;  
        margin-bottom: 20px;
        margin-top: 10px;
    }

    .row.mb-3 {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .input-group {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
    }

    .input-group input {
        padding: 10px;
        width: calc(100% - 150px); /* Adjust width to leave room for button */
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-right: 10px;
        font-family: Arial, sans-serif;
    }

    .input-group button {
        width: 140px;
        height: 45px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        text-align: center;
        font-family: Arial, sans-serif;
    }

    .input-group button:hover {
        background-color: #3e8e41;
    }

    .text-end {
        display: flex;
        gap: 10px;
        align-items: center;
        font-family: Arial, sans-serif;
        justify-content: flex-end; /* Align buttons to the right */
    }

    .text-end button {
        background-color: black; /* Set the refresh button color to black */
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-family: Arial, sans-serif;
    }

    .text-end button:hover {
        background-color: #333; /* Darker shade for hover effect */
    }

    .dropdown-menu {
        padding: 10px;
        font-family: Arial, sans-serif;
    }

    table.mesa {
        width: 100%;
        table-layout: fixed; /* Ensures fixed column widths */
        border-collapse: collapse;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        font-size: 16px;
        font-family: Arial, sans-serif;
    }

    table.mesa th, table.mesa td {
        padding: 15px;
        text-align: center;
        border: 1px solid #ddd;
    }

    table.mesa th {
        background-color: #f0f0f0;
    }

    table.mesa tr:nth-child(even) {
        background-color: #f9f9f9;
        font-size: 16px;
        font-family: Arial, sans-serif;
    }

    /* Adjust column widths here */
    table.mesa th:nth-child(1),
    table.mesa td:nth-child(1) {
        width: 10%; /* Adjust column width for Customer Name */
        font-size: 16px;
        font-family: Arial, sans-serif;
    }

    table.mesa th:nth-child(2),
    table.mesa td:nth-child(2) {
        width: 10%; /* Adjust column width for Rate */
        font-size: 16px;
        font-family: Arial, sans-serif;
    }

    table.mesa th:nth-child(3),
    table.mesa td:nth-child(3) {
        width: 35%; /* Adjust column width for Comment */
        font-size: 16px;
        font-family: Arial, sans-serif;
        
    }

    table.mesa th:nth-child(4),
    table.mesa td:nth-child(4) {
        width: 10%; /* Adjust column width for Date */
        font-size: 16px;
        font-family: Arial, sans-serif;
    }

    table.mesa th:nth-child(5),
    table.mesa td:nth-child(5) {
        width: 10%; /* Adjust column width for Time */
        font-size: 16px;
        font-family: Arial, sans-serif;
    }

    #noResults {
        text-align: center;
        margin-top: 20px;
        font-size: 16px;
        font-family: Arial, sans-serif;
    }

    #noResults img {
        max-width: 200px;
        margin-bottom: 20px;
    }

    #noResults p {
        font-size: 18px;
        color: #555;
        font-size: 16px;
        font-family: Arial, sans-serif;
    }

    /* Responsive Design for Tablets and Small Screens */
    @media only screen and (max-width: 768px) {
        .container-fluid {
            margin: 15px auto;
            max-width: 100%;
        }

        table.mesa {
            font-size: 14px;
        }

        .input-group {
            flex-direction: column;
            width: 100%;
        }

        .input-group input {
            width: 100%;
            margin-bottom: 10px;
        }

        .input-group button, .text-end button {
            width: 100%;
            margin-top: 10px;
            
        }
    }

    /* Responsive Design for Mobile Phones */
    @media only screen and (max-width: 480px) {
        .row.mb-3 {
            flex-direction: column;
            align-items: flex-start;
        }

        .input-group input, .input-group button {
            width: 100%;
            margin-top: 10px;
        }

        .text-end {
            flex-direction: column;
            width: 100%;
            margin-top: 10px;
        }

        .text-end button {
            width: 100%;
        }

        table.mesa {
            font-size: 12px;
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
    <?php   
        require 'admin-sidebar.php';
    ?>

<div class="main-content">
        <h1 class="name">Customer Feedbacks</h1>
        <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control dark" placeholder="Search..." onkeypress="handleKeyPress(event)">
                    <button type="button" onclick="searchFeedback()"><i class="fas fa-search"></i> Search</button>
                </div>
            </div>

            <div class="col-md-6 text-end">
                <button type="button" onclick="showAll()"><i class="fas fa-sync-alt"></i> </button>
                <button class="dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">Filter Feedback</button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="#" onclick="showAll()">Show All</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterFeedback(5)">⭐⭐⭐⭐⭐</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterFeedback(4)">⭐⭐⭐⭐</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterFeedback(3)">⭐⭐⭐</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterFeedback(2)">⭐⭐</a></li>
                    <li><a class="dropdown-item" href="#" onclick="filterFeedback(1)">⭐</a></li>
                </ul>
            </div>
        </div>

        <table id="feedbackTable" class="mesa table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Rate</th>
                    <th scope="col">Comment</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM feedback";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['name']}</td>";
                        $rate = $row['rate'];
                        $ratingRange = '';
                        if ($rate >= 0.1 && $rate <= 1.4) {
                            $ratingRange = 'Poor';
                        } else if ($rate >= 1.5 && $rate <= 2.4) {
                            $ratingRange = 'Unsatisfactory';
                        } else if ($rate >= 2.5 && $rate <= 3.4) {
                            $ratingRange = 'Satisfactory';
                        } else if ($rate >= 3.5 && $rate <= 4.4) {
                            $ratingRange = 'Very Satisfactory';
                        } else if ($rate >= 4.5 && $rate <= 5.0) {
                            $ratingRange = 'Outstanding';
                        }
                        echo "<td>{$ratingRange}</td>";
                        echo "<td>{$row['comment']}</td>";
                        echo "<td>{$row['date']}</td>";
                        echo "<td>{$row['time']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No feedback found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div id="noResults" style="display: none; text-align: center;">
            <img src="Pic/empty.svg" alt="Not Found" style="max-width: 100%;">
            <p>No results found</p>
        </div>
    </div>
</div>

<script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function () {
        sidebar.classList.toggle('active');
    };

    function showAll() {
    document.getElementById('searchInput').value = '';
    window.location.reload();
}

    function searchFeedback() {
        let searchQuery = document.getElementById('searchInput').value.toLowerCase();
        let table = document.getElementById('feedbackTable');
        let noResultsDiv = document.getElementById('noResults');

        let rows = table.getElementsByTagName('tr');
        let found = false;

        for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
            let cols = rows[i].getElementsByTagName('td');
            let match = false;

            for (let j = 0; j < cols.length; j++) {
                let text = cols[j].innerText.toLowerCase();
                if (text.includes(searchQuery)) {
                    match = true;
                    break;
                }
            }

            if (match) {
                rows[i].style.display = '';
                found = true;
            } else {
                rows[i].style.display = 'none';
            }
        }

        if (found) {
            table.style.display = '';
            noResultsDiv.style.display = 'none';
        } else {
            table.style.display = 'none';
            noResultsDiv.style.display = '';
        }
    }

    function clearSearch() {
        document.getElementById('searchInput').value = '';
        document.getElementById('feedbackTable').style.display = '';
        document.getElementById('noResults').style.display = 'none';
        
    }
    function handleKeyPress(event) {
        if (event.keyCode === 13) { // Check if Enter key was pressed
            searchFeedback(); // Call search function
        }
    }
    
    function filterFeedback(rating) {
        let table = document.getElementById('feedbackTable');
        let rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
            let cols = rows[i].getElementsByTagName('td');
            let rowRating = parseFloat(cols[1].innerText); // Assuming the rate is in the second column (index 1)

            // Determine the rating range based on the selected rating
            let ratingRange = '';
            if (rating >= 0.1 && rating <= 1.4) {
                ratingRange = 'Poor';
            } else if (rating >= 1.5 && rating <= 2.4) {
                ratingRange = 'Unsatisfactory';
            } else if (rating >= 2.5 && rating <= 3.4) {
                ratingRange = 'Satisfactory';
            } else if (rating >= 3.5 && rating <= 4.4) {
                ratingRange = 'Very Satisfactory';
            } else if (rating >= 4.5 && rating <= 5.0) {
                ratingRange = 'Outstanding';
            }

            // Show/hide rows based on the selected rating range
            if (ratingRange === cols[1].innerText) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }

</script>

</html>