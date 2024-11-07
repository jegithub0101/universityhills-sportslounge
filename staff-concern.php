<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
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
    <title>Concerns | University Hills</title>
    <link rel="icon" href="Pic/uhicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="Pic/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/sidebar.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .concern_container {
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            margin: 30px auto;
            width: 90%;
            max-width: 1200px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 20px;
        }

        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff; 
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); 
        }

        table thead th {
            background-color: #343a40; 
            color: #12171e; 
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #495057; 
        }

        table tbody tr {
            background-color: #f8f9fa; 
            transition: background-color 0.3s ease; 
        }

                table tbody tr:hover {
            background-color: #e9ecef; 
        }

        table tbody td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6; 
            font-size: 16px;
            color: #333; 
        }

      
        .btn-primary {
            background-color: #007bff; 
            border-color: #007bff;
            padding: 6px 12px;
            border-radius: 4px;
            color: #fff;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3; 
        }

      
        .clear-btn {
            background-color: #e74c3c; 
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-bottom: 10px;
            float: right;
        }

        .clear-btn:hover {
            background-color: #c0392b; 
        }

        @media (max-width: 768px) {
            table tbody td, table thead th {
                font-size: 14px; 
            }

            h1 {
                font-size: 24px; 
            }

            .concern_container {
                padding: 20px; 
            }
        }

        @media (max-width: 576px) {
            h1 {
                font-size: 20px; 
            }

            .clearbtn {
                float: none; 
                margin-top: 10px;
            }
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

            .table-margin {
                padding-top: 5%;
                margin: 2%;
            }
        }
    </style>
</head>
<body>
    <?php
        require 'staff-sidebar.php';
    ?>

    <div class="concern_container">
        <div class="container">
            <div class="table-margin">
                <h1 class="mt-4">Concerns</h1>

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
                        // Fetch data from the database
                        $sql = "SELECT * FROM concerns";
                        $result = $connection->query($sql);

                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
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

                        $connection->close();
                    ?>
                    </tbody>
                </table>
            </div>
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
                        // Reload the page to reflect changes
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
                        // Reload the page to reflect changes
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