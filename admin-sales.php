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
    <title>Sales | University Hills</title>
    <link rel="icon" href="Pic/uhicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="css/sidebar.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-straight/css/uicons-bold-straight.css'>
    <link rel="icon" href="Pic/logo.svg" type="image/x-icon">
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="chart.min.js"></script>
    <script src="jquery_graph.js"></script>

    <style>
        .main-content{
            height: 100vh;
            overflow-x: hidden;
            padding-left: 5%;
        }
        
        .title{
            margin-bottom: 1%;
        }
        .container-xl{
            background-color: white;
    
        }
        .whitecon {
            background-color: #ffffff; /* Pure white background */
            width: 85%;
            margin: 0 auto; /* Centers the container */
            padding: 2%; /* Adds internal spacing */
            border-radius: 15px; /* Rounded corners for smooth look */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth animation */
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


        /* General Card Styles */
        .card {
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Soft shadow */
            transition: transform 0.3s ease; /* Smooth hover effect */
        }

        .card:hover {
            transform: scale(1.05); /* Slight zoom on hover */
        }

        .card h5 {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase; /* Uppercase for emphasis */
        }

        .card .sales {
            font-size: 2.5rem; /* Larger font for sales figure */
            font-weight: bold;
            margin-top: 10px;
        }

        .card .date {
            font-size: 1rem;
            color: #12171e;
        }

        /* Individual Card Colors */
        .bg-primary {
            background-color: #007bff; /* Blue for Today's Sales */
        }

        .bg-success {
            background-color: #28a745; /* Green for Weekly Sales */
        }

        .bg-warning {
            background-color: #ffc107; /* Yellow for Monthly Sales */
            color: #212529;
        }

        .bg-danger {
            background-color: #dc3545; /* Red for Yearly Sales */
        }

        /* Icon Styles */
        .card i {
            margin-bottom: 10px;
            color: rgba(255, 255, 255, 0.9); /* Slightly lighter icon */
        }

        .text-white {
            color: white; /* White text for better contrast */
        }

        .display-4 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .iconprint {
            display: inline-flex; /* Use inline-flex for better alignment */
            align-items: center; /* Center items vertically */
            font-size: 20pt; /* Icon size */
            color: #12171e; /* Dark color for the icon */
            transition: color 0.3s ease, transform 0.3s ease; /* Smooth transition for hover effects */
            padding: 8px 12px; /* Padding around the icon for better click area */
            border-radius: 5px; /* Slightly round the edges */
            border: 1px solid #12171e; /* Match border color with the icon color */
            background-color: white; /* White background for contrast */
            margin: 5px; /* Margin for spacing */
            margin-left: 91%;
        }

        .iconprint > span {
            font-size: 15pt; /* Text size */
            margin-left: 5px; /* Spacing between icon and text */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .iconprint:hover {
            cursor: pointer;
            color: white; /* Changes text color to white on hover */
            background-color: #12171e; /* Dark background on hover */
            transform: scale(1.1); /* Slight zoom effect for interactivity */
            border-color: white; /* Change border color on hover for visibility */
        }
        .sales{
            color: #28a745;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .card {
                margin-bottom: 20px; /* Add spacing for small screens */
            }
        }

        .row_sales {
            background: linear-gradient(135deg, rgba(18, 23, 30, 0.8), rgba(255, 255, 255, 0.5), rgba(18, 23, 30, 0.8)); /* Semi-dark to semi-light back to semi-dark */
            padding: 2% 1%; /* Balanced top and bottom padding */
            border-radius: 15px; /* Rounded corners for the section */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4); /* Deeper shadow for depth */
            margin-bottom: 20px; /* Spacing at the bottom */
            transition: background 0.3s ease; /* Smooth background transition on hover */
        }

        .row_sales:hover {
            background: linear-gradient(135deg, #1a1f28, #12171e); /* Slightly lighter on hover */
        }

        .today{
            background-color: white;
            height: 150px;
            border-radius: 10px ;
        }
        .date{
            margin-top: 8%;
            text-align: center;
            font-weight: 700;
            
        }
        .title{
            text-align: center;
            margin-top: 1%;
            
        }
        .sales{
            font-size: 25pt;
            text-align: center;
        }
        .col_sales{
            background-color: #12171e;
        }
        .graphss {
            background-color: #f9f9f9; /* Softer background color for better contrast */
            border: 1px solid #e0e0e0; /* Lighter border */
            border-radius: 15px; /* Slightly less rounded for a sharper look */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Softer and more modern shadow */
            padding: 20px; /* Add padding for spacing */
            margin-top: 3%;
            transition: box-shadow 0.3s ease, transform 0.3s ease; /* Smooth transition */
        }

        .graphss:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Slightly stronger shadow on hover */
            transform: translateY(-5px); /* Lift effect on hover */
        }

        .chartjs_product, .chartjs_bar {
            max-width: 100%;
            height: auto; /* Ensure the charts are responsive */
            margin-bottom: 20px; /* Spacing between graphs */
        }


        /*------------------- */
        
    </style>

</head>
<body>
    <?php   
        require 'admin-sidebar.php';
    ?>
    <div class="main-content">
        <div class="container-fluid">
        <h1 class="text-center title">Sales Overview</h1>
            <div class = "whitecon">
            <div class="container-xl">
              
               
                <i class="fa-solid iconprint fa-print" class="btn btn-primary" onclick="printSalesData()"><span>Export</span></i>

                     <div class="row row_sales mt-4">
                        <!-- Today's Sales Card -->
                        <div class="col-sm-12 col-md-6 col-lg-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                            <h5 class="card-title">Today's Sales</h5>
                            <p class="card-text">
                            <?php 
                                $sql_today = "SELECT DATE_FORMAT(date, '%M %d, %Y') AS date, ROUND(SUM(totalprice),2) AS total_sales_today
                                FROM overall_payment
                                WHERE DATE(date) = CURDATE()
                                GROUP BY date;";
                                
                                            
                                $result_today = $connection->query($sql_today);
                                if($result_today->num_rows > 0){
                                    while ($row_today = $result_today->fetch_assoc()) {
                                        ?>
                                        <div class="date"><?php echo $row_today['date']; ?></div>
                                        <div class="sales">₱<?php echo number_format($row_today['total_sales_today'], 2); ?></div>
                                        <input type="hidden" id="print_todaysales" value="<?php echo $row_today['total_sales_today']; ?>">
                                        <?php
                                    }
                                }
                                else{
                                    echo "No sales yet";
                                }
                            ?>

                            <!--Include this in printing button to show products-->
                            <?php 
                                // For printing purposes. Table format showing all the products with quantity and pid 
                                $sql_product_sold_print = "SELECT pid, product_name, SUM(quantity) as qty  
                                FROM product_payment
                                GROUP BY pid
                                ORDER BY product_name;";
                                $result_sold_print = $connection->query($sql_product_sold_print);

                               

                                if ($result_sold_print->num_rows > 0) {
                                    while ($row_product_print = $result_sold_print->fetch_assoc()) {
                                    
                                        $pid = $row_product_print['pid'];
                                        ?>
                                            <input type="hidden" id="print_productspid_<?php echo $pid ?>" value="<?php echo $row_product_print['pid']; ?>">

                                            <input type="hidden" id="print_productsname_<?php echo $pid  ?>" value="<?php echo $row_product_print['product_name']; ?>">

                                            <input type="hidden" id="print_productsqty_<?php echo $pid  ?>" value="<?php echo $row_product_print['qty']; ?>">
                                        <?php
                                        // Display each product's details in a row

                    
                                    }
                                } else {
                                    echo "No sales yet";
                                }
                            ?>

                            <!--end-->
                            </p>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                            <h5 class="card-title">Weekly Sales</h5>
                            <p class="card-text">
                                <?php 
                                        $sql_today = "SELECT DATE_FORMAT(date, '%M %d, %Y') AS date, ROUND(SUM(totalprice),2) AS total_sales_today
                                        FROM overall_payment
                                        WHERE YEARWEEK(date) = YEARWEEK(CURDATE())";
                                        
                                        
                                                    
                                        $result_today = $connection->query($sql_today);
                                        if($result_today->num_rows > 0){
                                            while ($row_today = $result_today->fetch_assoc()) {
                                                ?>
                                                <div class="date"><?php echo $row_today['date']; ?></div>
                                                <div class="sales">₱<?php echo number_format($row_today['total_sales_today'], 2); ?></div>
                                                <input type="hidden" id="print_weaksales" value="<?php echo $row_today['total_sales_today']; ?>">
                                                <?php
                                            }
                                        }
                                        else{
                                            echo "No sales yet";
                                        }
                                    ?>
                                </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="card text-center shadow-sm">
                                <div class="card-body">
                                <h5 class="card-title">Monthly Sales</h5>
                                <p class="card-text">
                                    <?php 
                                            $sql_today = "SELECT MONTHNAME(date) AS date, ROUND(SUM(totalprice),2) AS total_sales_today
                                            FROM overall_payment
                                            WHERE YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())";
                                            
                                                        
                                            $result_today = $connection->query($sql_today);
                                            if($result_today->num_rows > 0){
                                                while ($row_today = $result_today->fetch_assoc()) {
                                                    ?>
                                                    <div class="date"><?php echo $row_today['date']; ?></div>
                                                    <div class="sales">₱<?php echo number_format($row_today['total_sales_today'], 2); ?></div>
                                                    <input type="hidden" id="print_monthsales" value="<?php echo $row_today['total_sales_today']; ?>">
                                                    <?php
                                                }
                                            }
                                            else{
                                                echo "No sales yet";
                                            }
                                        ?>
                                     </p>
                                </div>
                            </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-3">
                                <div class="card text-center shadow-sm">
                                    <div class="card-body">
                                    <h5 class="card-title">Yearly Sales</h5>
                                    <p class="card-text">
                                    <?php 
                                            $sql_today = "SELECT YEAR(date) AS date, ROUND(SUM(totalprice),2) AS total_sales_today
                                            FROM overall_payment
                                            WHERE YEAR(date) = YEAR(CURDATE())
                                            GROUP BY YEAR(date);";
                                            
                                                        
                                            $result_today = $connection->query($sql_today);
                                            if($result_today->num_rows > 0){
                                                while ($row_today = $result_today->fetch_assoc()) {
                                                    ?>
                                                    <div class="date"><?php echo $row_today['date']; ?></div>
                                                    <div class="sales">₱<?php echo number_format($row_today['total_sales_today'], 2); ?></div>
                                                    <input type="hidden" id="print_yearsales" value="<?php echo $row_today['total_sales_today']; ?>">
                                                    <?php
                                                }
                                            }
                                            else{
                                                echo "No sales yet";
                                            }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            </div>
                         </div>
                        <div class="row graphss ">
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 ">
                                <div class="">
                                <?php 
                                // Fetch data from database
                                $sql_product_sold = "SELECT pid, product_name, SUM(quantity) as qty  
                                FROM product_payment
                                GROUP BY pid
                                ORDER BY product_name;";
                                $result_sold = $connection->query($sql_product_sold);
        
                                // Initialize arrays to store data
                                $nameArray = [];
                                $quantityArray = [];
        
                                // Check if data is available
                                if ($result_sold->num_rows > 0) {
                                    // Loop through each row
                                    while ($row_sold = $result_sold->fetch_assoc()) {
                                        // Store date and total price in arrays
                                        $name = $row_sold['product_name'];
                                        if (!empty($name)) {
                                            $nameArray[] = $name;
                                            $quantityArray[] = $row_sold['qty'];

                                            ?>
                                                <input type="hidden" id="print_tid_<?php echo $tid; ?>" value="<?php echo $tid; ?>">
                                                <input type="hidden" id="print_name_<?php echo $tid; ?>" value="<?php echo $name; ?>">
                                                <input type="hidden" id="print_qty_<?php echo $tid; ?>" value="<?php echo $qty; ?>">

                                            <?php
                                            
                                        }
                                    }
                                }
        
                                // Encode arrays to JSON
                                $nameJSON = json_encode($nameArray);
                                $quantityJSON = json_encode($quantityArray);
                            ?>
                            <canvas id="chartjs_bar_product" height="300" class="chartjs_product"></canvas>
                        </div>

                     </div>
    
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 ">
                            
                            <?php 
                                // Fetch data from database
                                $sql_sales = "SELECT MONTHNAME(date) AS date, ROUND(SUM(totalprice), 2) AS totalprice
                                FROM overall_payment
                                GROUP BY MONTH(date)
                                ORDER BY MONTH(date);";
                                $result_sales = $connection->query($sql_sales);
        
                                // Initialize arrays to store data
                                $dateArray = [];
                                $totalpriceArray = [];
        
                                // Check if data is available
                                if ($result_sales->num_rows > 0) {
                                    // Loop through each row
                                    while ($row_sales = $result_sales->fetch_assoc()) {
                                        // Store date and total price in arrays
                                        $date = $row_sales['date'];
                                        if (!empty($date)) {
                                            $dateArray[] = $date;
                                            $totalpriceArray[] = $row_sales['totalprice'];
                                        }
                                    }
                                }
        
                                // Encode arrays to JSON
                                $dateJSON = json_encode($dateArray);
                                $totalpriceJSON = json_encode($totalpriceArray);
                            ?>
                            <canvas id="chartjs_bar" height="300" class="chartjs_bar"></canvas>
                        </div>
                </div>
            </div>
            </div>
  
        </div>
    </div>


</body>
<script>
function printSalesData() {
    // Get sales values from hidden inputs
    const todaySales = document.getElementById('print_todaysales').value;
    const weekSales = document.getElementById('print_weaksales').value;
    const monthSales = document.getElementById('print_monthsales').value;
    const yearSales = document.getElementById('print_yearsales').value;

    // Create a new window for printing
    const printWindow = window.open('', '_blank');

    // Generate the HTML content
    let htmlContent = `
        <html>
        <head>
            <title class='text-center'>Sales Report</title>
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                .sales-summary {
                    margin-bottom: 30px;
                }
                h2 {
                    margin-bottom: 10px;
                }
            </style>
        </head>
        <body>
            <h1>Sales Report</h1>
            
            <div class="sales-summary">
                <h2>Sales Summary</h2>
                <table>
                    <tr>
                        <th>Period</th>
                        <th>Amount</th>
                    </tr>
                    <tr>
                        <td>Today's Sales</td>
                        <td>₱${todaySales}</td>
                    </tr>
                    <tr>
                        <td>Weekly Sales</td>
                        <td>₱${weekSales}</td>
                    </tr>
                    <tr>
                        <td>Monthly Sales</td>
                        <td>₱${monthSales}</td>
                    </tr>
                    <tr>
                        <td>Yearly Sales</td>
                        <td>₱${yearSales}</td>
                    </tr>
                </table>
            </div>

            <h2>Monthly Sales Breakdown</h2>
            <table>
                <tr>
                    <th>Month</th>
                    <th>Total Sales</th>
                </tr>`;

    // PHP code for Monthly Sales Breakdown
    <?php
        $sql_months = "SELECT 
            MONTHNAME(date) AS month,
            ROUND(SUM(totalprice), 2) AS total_sales
        FROM overall_payment
        WHERE YEAR(date) = YEAR(CURDATE())
        GROUP BY MONTH(date), MONTHNAME(date)
        ORDER BY MONTH(date)";
        
        $result_months = $connection->query($sql_months);

        if ($result_months->num_rows > 0) {
            while ($row = $result_months->fetch_assoc()) {
                echo "htmlContent += `<tr>
                    <td>" . htmlspecialchars($row['month']) . "</td>
                    <td>₱" . htmlspecialchars($row['total_sales']) . "</td>
                </tr>`;";
            }
        } else {
            echo "htmlContent += `<tr><td colspan='2'>No sales data available for any month this year</td></tr>`;";
        }
    ?>

    // Close the monthly sales table
    htmlContent += `
            </table>

            <h2>Top Selling Product</h2>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity Sold</th>
                    <th>Price</th>
                </tr>`;

    // PHP code for top product
    <?php
        $sql_top_selling = "SELECT product_name, SUM(quantity) AS total_quantity, PID
                            FROM admin_order
                            GROUP BY product_name
                            ORDER BY total_quantity DESC
                            LIMIT 1;";

        $result_top = $connection->query($sql_top_selling);

        if ($result_top->num_rows > 0) {
            $row_top = $result_top->fetch_assoc();
            $top_name = $row_top['product_name'];
            $top_quantity = $row_top['total_quantity'];
            $PID = $row_top['PID'];

            // Fetch price for top-selling product
            $sql_info = "SELECT DISTINCT product_name, price FROM products WHERE PID = '$PID' LIMIT 1;";
            $result_info = $connection->query($sql_info);

            if ($result_info->num_rows > 0) {
                $row_info = $result_info->fetch_assoc();
                $price = $row_info['price'];

                echo "htmlContent += `<tr>
                    <td>" . htmlspecialchars($top_name) . "</td>
                    <td>" . htmlspecialchars($top_quantity) . "</td>
                    <td>₱" . htmlspecialchars($price) . "</td>
                </tr>`;";
            } else {
                echo "htmlContent += `<tr><td colspan='3'>Top product information not found</td></tr>`;";
            }
        } else {
            echo "htmlContent += `<tr><td colspan='3'>No top-selling products</td></tr>`;";
        }
    ?>

    // Close the top-selling products table
    htmlContent += `
            </table>

            <h2>Low Stocks</h2>
            <table>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Stocks</th>
                </tr>`;

    // PHP code for low stocks
    <?php
        $sql_low = "SELECT * from products where stock <= 15 ORDER BY stock ASC LIMIT 3;";
        $result_low = $connection->query($sql_low);

        if ($result_low->num_rows > 0) {
            $k = 1; // Counter for the row number

            while ($row_low = $result_low->fetch_assoc()) {
                echo "htmlContent += `<tr>
                    <td>" . htmlspecialchars($k) . "</td>
                    <td>" . htmlspecialchars($row_low['product_name']) . "</td>
                    <td>" . htmlspecialchars($row_low['stock']) . "</td>
                </tr>`;";
                $k += 1;
            }
        } else {
            echo "htmlContent += `<tr><td colspan='3'>No low stock items</td></tr>`;";
        }
    ?>

    // Close the low stocks table
    htmlContent += `
            </table>

            <h2>Product Details</h2>
            <table>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Quantity Sold</th>
                </tr>`;

    // PHP code to fetch product details for printing
    <?php 
        $sql_product_sold_print = "SELECT pid, product_name, SUM(quantity) as qty  
        FROM product_payment
        GROUP BY pid
        ORDER BY product_name;";
        $result_sold_print = $connection->query($sql_product_sold_print);

        if ($result_sold_print->num_rows > 0) {
            while ($row_product_print = $result_sold_print->fetch_assoc()) {
                echo "htmlContent += `<tr>
                    <td>" . htmlspecialchars($row_product_print['pid']) . "</td>
                    <td>" . htmlspecialchars($row_product_print['product_name']) . "</td>
                    <td>" . htmlspecialchars($row_product_print['qty']) . "</td>
                </tr>`;";
            }
        } else {
            echo "htmlContent += `<tr><td colspan='3'>No sales yet</td></tr>`;";
        }
    ?>

    // Close the product details table and HTML structure
    htmlContent += `
            </table>
            <div style="margin-top: 20px; text-align: right;">
                <p>Generated on: ${new Date().toLocaleString()}</p>
            </div>
        </body>
        </html>`;

    // Write the content to the new window and print
    printWindow.document.write(htmlContent);
    printWindow.document.close();

    // Wait for content to load before printing
    printWindow.onload = function() {
        printWindow.print();
        // printWindow.close();  // Uncomment this if you want the window to close after printing
    };
}
</script>





<script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function () {
        sidebar.classList.toggle('active');
    };
</script>



<script type="text/javascript">
    var ctx = document.getElementById("chartjs_bar").getContext('2d');


    var backgroundColors = [
    "#5969ff", "#ff407b", "#25d5f2", "#ffc750", "#2ec551",
    "#7040fa", "#ff004e", "#ff66cc", "#33cccc", "#9900cc",
    "#ff6666", "#339933", "#cc3366", "#663399", "#99cc00",
    "#009688", "#8bc34a", "#ff9800", "#673ab7", "#e91e63",
    "#795548", "#00bcd4", "#009688", "#4caf50", "#ff5722",
    "#3f51b5", "#9c27b0", "#2196f3", "#f44336", "#9e9e9e",
    "#607d8b", "#ffc107", "#cddc39", "#673ab7", "#e91e63",
    "#FFA07A", "#20B2AA", "#778899", "#FF4500", "#7CFC00",
    "#6495ED", "#FF00FF", "#008080", "#DC143C", "#6A5ACD",
    "#FF1493", "#FF6347", "#00FFFF", "#7FFFD4", "#ADFF2F",
    "#800000", "#40E0D0", "#FF8C00", "#FFD700", "#008000",
    "#B0C4DE", "#FF69B4", "#F0E68C", "#ADD8E6", "#FFA500",
    "#C71585", "#4682B4", "#B0E0E6", "#FF7F50", "#9932CC",
    "#A52A2A", "#8A2BE2", "#5F9EA0", "#DAA520", "#D2691E",
    "#8B008B", "#32CD32", "#FA8072", "#0000FF", "#00FF00",
    "#FF00FF", "#800080", "#FFDAB9", "#D8BFD8", "#4B0082",
    "#FFFF00", "#00FF7F", "#FF4500", "#87CEEB", "#FFC0CB",
    "#FFA500", "#4682B4", "#B0E0E6", "#9932CC", "#FF7F50",
    "#DAA520", "#D2691E", "#8B008B", "#32CD32", "#FA8072",
    "#0000FF", "#00FF00", "#FF00FF", "#800080", "#FFDAB9"
];

    
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo $dateJSON; ?>,
            datasets: [{
            backgroundColor: 'rgba(89, 105, 255, 0.2)',
            borderColor: '#5969ff',
            borderWidth: 3,
            data: <?php echo $totalpriceJSON; ?>,
            pointRadius: 5,
            pointHoverRadius: 8,
            tension: 0.4,
            pointBackgroundColor: backgroundColors,
            pointBorderColor: 'rgba(0, 0, 0, 0.1)', 
            }],
           
        },
        options: {
            title: {
                display: true,
                text: 'SALES PER MONTH', // Your title here
                fontSize: 26,
                fontColor: '#12171e',
                fontFamily: 'Circular Std Book',
                fontStyle: 'normal',
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#71748d',
                    fontFamily: 'Circular Std Book',
                    fontSize: 14,
                }
            }
        }
    });
</script>



<script type="text/javascript">
    var ctx = document.getElementById("chartjs_bar_product").getContext('2d');



    var backgroundColors = [
    "#5969ff", "#ff407b", "#25d5f2", "#ffc750", "#2ec551",
    "#7040fa", "#ff004e", "#ff66cc", "#33cccc", "#9900cc",
    "#ff6666", "#339933", "#cc3366", "#663399", "#99cc00",
    "#009688", "#8bc34a", "#ff9800", "#673ab7", "#e91e63",
    "#795548", "#00bcd4", "#009688", "#4caf50", "#ff5722",
    "#3f51b5", "#9c27b0", "#2196f3", "#f44336", "#9e9e9e",
    "#607d8b", "#ffc107", "#cddc39", "#673ab7", "#e91e63",
    "#FFA07A", "#20B2AA", "#778899", "#FF4500", "#7CFC00",
    "#6495ED", "#FF00FF", "#008080", "#DC143C", "#6A5ACD",
    "#FF1493", "#FF6347", "#00FFFF", "#7FFFD4", "#ADFF2F",
    "#800000", "#40E0D0", "#FF8C00", "#FFD700", "#008000",
    "#B0C4DE", "#FF69B4", "#F0E68C", "#ADD8E6", "#FFA500",
    "#C71585", "#4682B4", "#B0E0E6", "#FF7F50", "#9932CC",
    "#A52A2A", "#8A2BE2", "#5F9EA0", "#DAA520", "#D2691E",
    "#8B008B", "#32CD32", "#FA8072", "#0000FF", "#00FF00",
    "#FF00FF", "#800080", "#FFDAB9", "#D8BFD8", "#4B0082",
    "#FFFF00", "#00FF7F", "#FF4500", "#87CEEB", "#FFC0CB",
    "#FFA500", "#4682B4", "#B0E0E6", "#9932CC", "#FF7F50",
    "#DAA520", "#D2691E", "#8B008B", "#32CD32", "#FA8072",
    "#0000FF", "#00FF00", "#FF00FF", "#800080", "#FFDAB9"
];
   

    
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo $nameJSON; ?>,
            datasets: [{
                backgroundColor: backgroundColors,
                data: <?php echo $quantityJSON; ?>,
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Unit Sales', // Your title here
                fontSize: 26,
                fontColor: '#12171e',
                fontFamily: 'Circular Std Book',
                fontStyle: 'normal',
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#71748d',
                    fontFamily: 'Circular Std Book',
                    fontSize: 14,
                }
            }
        }
    });
</script>


</html>