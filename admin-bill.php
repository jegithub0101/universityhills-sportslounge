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
    <title>Bills | University Hills</title>
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
            position: relative;
            background-color: #eee;
            min-height: 100vh;
            top:0;
            left:80px;
            transition: all 0.5s ease;
            width: calc(100% - 80px);
            padding: 1rem;
            height: 100vh;
        }
       
        
        .main-content{
            height: 100vh;
            overflow-x: hidden;
            
            padding-right: 1%;

        }
        h3{
            text-align: center;
        }
        .conn{
            margin-left: 3%;
        }

        .cards{
            background-color: white;
            height: 650px;
            border: 1px solid gray;
            
            overflow-y: auto;
            overflow-x: hidden ;
            margin-left: 10px;
            position: relative;
            padding: 4%;
           
            
           
        }

        .containerorder{
            margin-bottom: 4px;
            height: auto;
            border-bottom: 1px solid #1F1F1F;
            
        }
        .containeritem{
            height: auto;
            width: 100%;
            margin-bottom: 1%;
            
           
        }

        .prodnameh, .prodstatush, .pquantityh, .ppriceh ,.pstotalh{
            font-weight: 700;
        }
        .name{
            color: gray;
            font-weight: 500;
            background-color: #D8D8D8;
            border: 1px solid #D8D8D8;
            position: relative;
            padding-top: 2%;
            padding-left: 2%;
            padding-right: 3%;
            
        }
        .name> p{
            float: left;
            
        }
        
        /* .prodname{
            width: 100%;
       
            float: left;
            height: 100%;
            border-right: 1px solid #1F1F1F;
            background-color: pink;

        } */
        /* .prodstatus{
            height: 100%;
            text-align: center;
            background-color: yellow;
            width: 10%;
            float: right;
        } */
        /* .white{
            background-color: #1F1F1F;
            position: absolute;
            bottom: 0px;
            width: 100;

        } */
        .requestbill{
            border: none;
            margin-bottom: 2%;
            margin-left: 87%;
        }
        
        /* .pprice{
            width: 10%;
            float: left;
        } */ 
        .flex-fill{
            width: 25%;
        }
        .tableno{
            background-color: #4D4D4D;
            text-align: center;
            color: white;
            font-size: 25pt;
            width: 98.2%;
            margin-left: 1.8%;
            border-top-left-radius: 8px ;
            border-top-right-radius: 8px;
        }
        .totalamt{
            background-color: #4D4D4D;
            text-align: center;
            color: white;
            font-size: 20pt;
            width: 98.2%;
            margin-left: 1.8%;
            border-bottom-left-radius: 8px ;
            border-bottom-right-radius: 8px;
        }

        .useramt{
            color: red;
            margin-bottom: 50px;
            font-size: 15pt;
            text-align: left;
        }
  
        .useramt > input{
            outline: none;
            border: none;

        }
        .pooltotal{
            font-size: 15pt;
            font-weight: 600;
        }
        .billtable{
            margin-bottom: 50px;
        }
        .btnpay{
            background-color: #12171e;
            outline: none;
            border: none;
            font-size: 15pt;
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

    </style>

</head>
<body>
    
    <?php   
        require 'admin-sidebar.php';
    ?>
        
    <div class="main-content">
        <div class="container-fluid">
            <h1>Bills</h1>
            <div class="row">
            <?php
            $sql_bill_table = "SELECT DISTINCT table_number FROM admin_order WHERE status = 'Request' order by billout_by";
            $result_bill_table = $connection->query($sql_bill_table);
            if ($result_bill_table->num_rows > 0) {
                
                // Loop through each tracking number
                while ($row_bill_table = $result_bill_table->fetch_assoc()) {
                    $bill_table =  $row_bill_table['table_number']; // table number
                    $k = 0;
                    $_SESSION['distinct_cid_count'] = $k;
                    
                ?>
                <div class="col-sm-12 col-md-10 col-lg-4 col-xl-4 billtable">
                    <div class="tableno "><?php echo $bill_table; ?></div>
                    <div class="cards">
                    <?php
                        //getting the cid from admin_order/customer id
                        $sql_monitor_cid = "SELECT DISTINCT cid FROM admin_order WHERE table_number = $bill_table AND status = 'Request'";
                        $result_monitor_cid = $connection->query($sql_monitor_cid);

                    

                        if ($result_monitor_cid->num_rows > 0) {
                            ?>
                            <form method="POST">
                                <?php
                                // Loop through cid
                            while ($row_cid = $result_monitor_cid->fetch_assoc()) {
                                $cid_user = $row_cid['cid'];

                                // getting the nickname of the customer using cid
                                $sql_monitor_name = "SELECT nickname FROM customer WHERE cid=$cid_user";
                                $result_monitor_name = $connection->query($sql_monitor_name);
                                $row_monitor_name = $result_monitor_name->fetch_assoc();

                                 $k += 1;
                                 $_SESSION['distinct_cid_count'] = $k;

                                //echo $cid_user;
                                ?>
                                <div class="name lead d-flex" data-user-id="<?php echo $user['cid']; ?>">
                                    <div class="me-auto">
                                        <p >
                                            <span><?php echo $row_monitor_name['nickname']; ?></span>
                                            <input type="hidden" id="name_<?php echo $bill_table. $k  ?>" name="name_<?php echo $bill_table. $k  ?>"  value="<?php echo $row_monitor_name['nickname']; ?>">
                                        </p>
                                    </div>
                                    <div class="chbox">
                                        <!--it is the checkbox if the pwd discount is applied-->
                                        <input type="checkbox"  onclick="updateValidIdCount('<?php echo $bill_table; ?>')" class="validid" id="validid_<?php echo $bill_table. $k  ?>" name="validid_<?php echo $bill_table. $k  ?>" data-user-id="<?php echo $user['cid']; ?>" value="validid">
                                        <label for="validid_<?php echo $bill_table. $k  ?>">  valid id</label><br>
                                        <input type="hidden" class="isvalid_<?php echo $bill_table. $k  ?>" value="">
                                    </div>
                                </div>

                                <!--this is the orders of each person within that table-->
                                <div class="containeritem d-flex bd-highlight">
                                    <div class="prodnameh flex-fill bd-highlight"> Name </div>
                                    <div class="pquantityh flex-fill bd-highlight"> QTY </div>
                                    <div class="ppriceh flex-fill bd-highlight">Price</div>
                                    <div class="pstotalh flex-fill bd-highlight">Subtotal</div>
                                </div>

                                <?php

                                $total_user = 0;

                                $sql_monitor = "SELECT DISTINCT tracking_no FROM admin_order WHERE table_number = $bill_table AND cid=$cid_user";
                                $result_monitor = $connection->query($sql_monitor);
                                if ($result_monitor->num_rows > 0) {
                                    
                                    // Loop through each tracking number
                                    while ($row = $result_monitor->fetch_assoc()) {
                                        $tracking = $row['tracking_no'];

                                        //count of tracking order
                                        $sql_cancelled_preparing = "SELECT * FROM admin_order WHERE cid=$cid_user AND tracking_no = '$tracking' AND table_number = $bill_table";
                                        $result_can_pre = $connection->query($sql_cancelled_preparing);
                                        $row_can_pre = $result_can_pre->fetch_assoc();

                                        if($row_can_pre['status'] === "Request"){
                                            ?>
                                                <div class="containerorder"><?php //echo $tracking; ?>
                                                    <?php
                                                    $sql_monitor_item = "SELECT * FROM admin_order WHERE cid=$cid_user AND tracking_no = '$tracking' AND table_number = $bill_table AND status = 'Request'";
                                                    $result_monitor_item = $connection->query($sql_monitor_item);
                                                    if ($result_monitor_item->num_rows > 0) {
                                                        // Loop through each item
                                                        while ($row_item = $result_monitor_item->fetch_assoc()) {
                                                           

                                                            $usersubtotal = $row_item['quantity'] * $row_item['price'];
                                                            $total_user += $usersubtotal; // Add the subtotal to the user total amount
                                                            
                                                        ?>
                                                            <div class="containeritem d-flex bd-highlight">
                                                                <div class="prodname flex-fill bd-highlight"> 
                                                                    <?php echo $row_item['product_name']; ?>
                                                                    <input type="hidden" id="pname_<?php echo $bill_table. $k  ?>" name="pname_<?php echo $bill_table. $k  ?>"  value="<?php echo $row_item['product_name']; ?>"> 
                                                                </div>
                                                                <div class="pquantity flex-fill bd-highlight">
                                                                    <?php echo $row_item['quantity']; ?>
                                                                    <input type="hidden" id="pquantity_<?php echo $bill_table. $k  ?>" name="pquantity_<?php echo $bill_table. $k  ?>"  value="<?php echo $row_item['quantity']; ?>">
                                                                </div>
                                                                <div class="pprice flex-fill bd-highlight">
                                                                    <?php echo $row_item['price']; ?>
                                                                    <input type="hidden" id="pprice_<?php echo $bill_table. $k  ?>" name="pprice_<?php echo $bill_table. $k  ?>"  value="<?php echo $row_item['price']; ?>"> 
                                                                </div>
                                                                <?php
                                                                    $subtotal = $row_item['quantity'] * $row_item['price'];
                                                                ?>
                                                                <div class="pstotal flex-fill bd-highlight">
                                                                    <?php echo $subtotal; ?>
                                                                    <input type="hidden" id="psubtotal_<?php echo $bill_table. $k  ?>" name="psubtotal_<?php echo $bill_table. $k  ?>"  value="<?php echo $subtotal; ?>"> 
                                                                </div>
                                                                <!--<div class="prodstatus flex-fill bd-highlight">-->
                                                                   
                                                                    <input type="hidden" id="pstatus_<?php echo $bill_table. $k  ?>" name="pstatus_<?php echo $bill_table. $k  ?>"  value="<?php echo $row_item['status']; ?>">
                                                                <!--</div>-->
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                
                                            <?php
                                        }

                                    
                                    }
                                }
                                else{
                                    echo "NO ORDERS AT THE MOMENT";
                                }
                                ?>
                                 <!--this is the amount per customer-->
                                    <h3 class="useramt"> 
                                        Amount: <span> <?php //echo $total_user; ?> </span>
                                        <input type="text" readonly id="usertotal_<?php echo $bill_table. $k  ?>" name="usertotal_<?php echo $bill_table. $k  ?>"  value="<?php echo $total_user; ?>">
                                    </h3>
                                <?php
                                
                            } 
                            ?>
                             <!--<input type="text" id="increment_<echo $bill_table . $k ?>" name="" value="<echo $bill_table. $k; ?>"-->
                            <?php
                                $sql_bill_pool = "SELECT COUNT(*) as table_payment FROM pool_accepted WHERE table_number = $bill_table";
                                $result_bill_pool = $connection->query($sql_bill_pool);
                                if ($result_bill_pool->num_rows > 0) {
                                    
                                    $row_bill_pool = $result_bill_pool->fetch_assoc();
                                    $bill_pool =  $row_bill_pool['table_payment'];
                                    $total_pool = 150 * $bill_pool;

                                    $poolprice = 150;
                                    echo "<p class='pooltotal'>Table Pool: ". $poolprice."x".$bill_pool."=".$total_pool . "</p>";
                                    ?>
                                    <input  type="hidden" id="num_user_<?php echo $bill_table ?>" name="num_user_<?php echo $bill_table ?>" value="<?php echo $k; ?>">
                                        <input type="hidden" id="pool_<?php echo $bill_table ?>" value="<?php echo $total_pool ?>">
                                    <?php
                                }
                                        
                            ?>
                                
                        </form>

                            <?php
                        
                        }
                        
                        else{
                            echo "NO ORDERS AT THE MOMENT";
                        }
                        
                    ?>
                    </div>
      
                    <!--it is the total overll_amount of all the customers within that table-->
                    <div class="totalamt">
                        <p id="overalltotal_<?php echo $bill_table;  ?>" name = "overalltotal_<?php echo $bill_table; ?>">Total Amount: </p><!--Overall total amout per table-->
                        <input type="hidden" name="inputoveralltotal_<?php echo $bill_table;  ?>" id="inputoveralltotal_<?php echo $bill_table;  ?>"> 
                        <input type="hidden" name="countvalidid_<?php echo $bill_table;  ?>" id="countvalidid_<?php echo $bill_table;  ?>" value="0">
                    <!-- Update the buttons with IDs -->
                    <button class="btn btn-primary w-100 btnpay" id="doneButton" name="btnpay">Done</button>
                    <button class="btn btn-secondary w-100" id="printButton" onclick="printBill('<?php echo $bill_table; ?>')">Print Bill</button>
                </div>
<?php
    }
}
else{
    echo "<p class='emptyword'></p>";
    echo " <img class='emptypic' src='Pic/emptybill.svg' alt=''>";
}
?>
</div>
</div>
</div>
</body>

<!-- JavaScript part -->
<script>
    // Function to preview and print the bill
    function printBill(tableNumber) {
        // Hide the "Done" and "Print" buttons during print
        document.getElementById('doneButton').style.display = 'none';
        document.getElementById('printButton').style.display = 'none';

        // Get the updated total amount from the DOM
        let overallTotal = document.getElementById('overalltotal_' + tableNumber).textContent;

        // Get the content of the bill table (it may have updated amounts or other dynamic content)
        let printContent = document.querySelector('.billtable').innerHTML;

        // Remove unwanted parts from the print content
        printContent = printContent.replace(/<div>valid id<\/div>/, ''); // Remove valid ID
        printContent = printContent.replace(/<div>\d+<\/div>/, ''); // Remove the line with the table number (e.g., "2")

        // Open a new window for printing
        let printWindow = window.open('', '', 'width=800,height=600');
        
        // Get current date and time in Manila/PH timezone and format it
        let options = { timeZone: 'Asia/Manila', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
        let date = new Intl.DateTimeFormat('en-US', options).format(new Date());
        

        printWindow.document.write('<html><head><title>Print Bill</title>');
        printWindow.document.write(`
           <style>
    body { 
        font-family: 'Courier New', monospace; 
        font-size: 12px; /* Reduced font size to fit better on smaller receipts */
    }
    
    .receipt {
        padding: 10px; /* Reduce padding to maximize content space */
        max-width: 100%; /* Fit to thermal receipt paper width */
        margin: auto;
        border: none; /* Remove border for clean thermal printing */
        box-shadow: none; /* Remove shadow for printing */
    }

    .receipt-header, .receipt-footer {
        text-align: center;
        margin-bottom: 10px; /* Reduced margin for compactness */
    }

    .receipt-header h2 {
        margin: 0;
        font-size: 14px; /* Reduced font size for headers */
    }

    .receipt-header p, .receipt-footer p {
        margin: 3px 0; /* Reduce vertical spacing */
    }

    .bill-items {
        margin-bottom: 5px;
        border-bottom: 1px dashed black;
        padding-bottom: 5px;
    }

    .bill-items th, .bill-items td {
        padding: 2px; /* Reduced padding for more space */
        text-align: left;
        font-size: 12px; /* Keep font size consistent */
    }

    /* Adjusting total display for small receipt */
    .total {
        text-align: left;
        font-weight: bold;
        margin-top: 5px; /* Reduced margin */
    }

    .totalamt {
        font-weight: bold;
        text-align: right;
    }

    /* Hide elements not needed for receipt */
    .tableno, .useramt, .chbox {
        display: none;
    }

    /* Ensure flexbox layout for items is compact */
    .containeritem {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        font-size: 12px;
    }

    .prodnameh, .prodstatush, .pquantityh, .ppriceh, .pstotalh {
        font-weight: bold;
        text-align: left;
        flex: 1;
        padding-right: 5px; /* Reduced padding for compactness */
    }

    .prodname, .prodstatus, .pquantity, .pprice, .pstotal {
        text-align: left;
        flex: 1;
        padding-right: 5px;
    }

    /* Adjust footer for thermal printing */
    .receipt-footer {
        margin-top: 10px;
        font-size: 11px; /* Slightly smaller footer text */
    }
</style>


        `);
        printWindow.document.write('</head><body>');
        printWindow.document.write(`
            <div class="receipt">
                <div class="receipt-header">
                    <h2>UNIVERSITY HILLS <br>SPORTS LOUNGE</h2>
                    <p>2nd Floor, Unicenter Building<br>100 Samson Rd., Corner Caimito St.
                    <br>University Hills, Caloocan City</p>
                     <p>-----------------------------------<p>
                    <p>${date}</p> <!-- Date and time -->
                    <p>-----------------------------------<p>
                </div>
                <div class="tableNum">Table No: ${tableNumber}</div>
                ${printContent}
                
                <div class="receipt-footer">
                     <p>-----------------------------------<p>
                    <p>Thank you for dining with us!<br>This serves as your official receipt.</p>
                </div>
            </div>
        `);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();

        // Show the "Done" and "Print" buttons again after printing
        document.getElementById('doneButton').style.display = 'block';
        document.getElementById('printButton').style.display = 'block';
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
    document.addEventListener("DOMContentLoaded", function () {
        // Add event listeners to all valid ID checkboxes within each table
        let tables = document.querySelectorAll('.cards');
        tables.forEach(function (table) {
            let validIdCheckboxes = table.querySelectorAll('.validid');
            validIdCheckboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    // Get the corresponding user's total amount and original total
                    let userId = checkbox.id.split('_')[1];
                    let totalElement = table.querySelector('#usertotal_' + userId);
                    let originalTotal = parseFloat(totalElement.getAttribute('data-original-total'));
                    let total = parseFloat(totalElement.value);

                    // Apply discount if the checkbox is checked
                    let discount = checkbox.checked ? 0.8 : 1; // 20% discount if checked
                    let discountedTotal = total * discount;

                    // Update the displayed total for the user
                    if (checkbox.checked) {
                        // Store original total if checkbox is checked
                        totalElement.setAttribute('data-original-total', total);
                        totalElement.value = discountedTotal.toFixed(2);
                        calculateOverallTotal(table);
                    } else {
                        // Restore original total if checkbox is unchecked
                        totalElement.value = originalTotal.toFixed(2);
                        calculateOverallTotal(table);
                    }
                    totalElement.nextElementSibling.textContent = 'Amount: ' + totalElement.value;

                    // Recalculate the overall total amount for the table
                    calculateOverallTotal(table);
                });
            });

            // Calculate the initial overall total amount for the table
            calculateOverallTotal(table);
        });
    });

    function calculateOverallTotal(table) {
        let userTotals = table.querySelectorAll('input[id^="usertotal_"]');
        let overallTotal = 0;
        let poolPrice = parseFloat(table.querySelector('#pool_' + table.parentNode.querySelector('.tableno').textContent)?.value || 0);

        userTotals.forEach(function (userTotal) {
            overallTotal += parseFloat(userTotal.value);
        });

        overallTotal += poolPrice;

        let overallTotalDisplay = table.parentNode.querySelector('#overalltotal_' + table.parentNode.querySelector('.tableno').textContent);
        let inputOverallTotalDisplay = table.parentNode.querySelector('#inputoveralltotal_' + table.parentNode.querySelector('.tableno').textContent);

        overallTotalDisplay.textContent = 'Total Amount: ' + overallTotal.toFixed(2);
        inputOverallTotalDisplay.value = overallTotal.toFixed(2);
    }
</script>


<script>
// Get all checkboxes with the class 'validid'
const validIdCheckboxes = document.querySelectorAll('.validid');

// Add an event listener to each checkbox
validIdCheckboxes.forEach(checkbox => {
  checkbox.addEventListener('change', function() {
    // Get the corresponding 'isvalid_' input field
    const isValidInput = document.querySelector(`.isvalid_${checkbox.id.replace('validid_', '')}`);

    // Update the value of the 'isvalid_' input field
    isValidInput.value = this.checked ? 'with valid id' : '';
  });
});
</script>


<script>
// Get all "Pay" buttons
const payButtons = document.querySelectorAll('.btnpay');

// Add a click event listener to each button
payButtons.forEach(button => {
    button.addEventListener('click', function() {
        const tableNumber = button.parentNode.parentNode.querySelector('.tableno').textContent;
        const overallTotal = button.parentNode.querySelector('#inputoveralltotal_' + tableNumber).value;
        var inputValue = document.getElementById("countvalidid_"+ tableNumber).value;

        // Gather product details
        const products = button.parentNode.querySelectorAll('.containeritem');

        let data = 'table_number=' + encodeURIComponent(tableNumber) + '&overall_total=' + encodeURIComponent(overallTotal) + '&pix=' + inputValue;

        // Call the new function to send the payment data
        sendPaymentDataWithConfirmation(data);
    });
});

function sendPaymentDataWithConfirmation(data) {
    sendPaymentData(data);
}

function sendPaymentData(data) {
    // Create an XMLHttpRequest object
    const xhr = new XMLHttpRequest();

    // Confirm with the user before sending the request
    if (confirm("Are you sure you want to proceed?")) {
        // Set up the request
        xhr.open('POST', 'process_payment.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Send the request
        xhr.send(data);
        window.location.reload();
    }
}

</script>

<script>
    // Function to handle checkbox click event
    function updateValidIdCount(tableNumber) {
        // Get all checkboxes for the specified table
        var checkboxes = document.querySelectorAll('input[name^="validid_' + tableNumber + '"]');
        var validIdCount = 0;

        // Loop through each checkbox
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                validIdCount++;
            }
        });

        // Update the count of valid IDs for the table
        document.getElementById('countvalidid_' + tableNumber).value = validIdCount;
    }
</script>

<script>
    // Function to send payment data with confirmation
    function sendPaymentDataWithConfirmation(data) {
        // Confirm with the user before sending the request
        if (confirm("Are you sure you want to proceed?")) {
            // Send the payment data
            sendPaymentData(data);
        }
    }

    // Function to send payment data
    function sendPaymentData(data) {
        // Create an XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Set up the request
        xhr.open('POST', 'process_payment.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Send the request
        xhr.send(data);

        // Reload the page after sending the payment data
        location.reload();
    }
</script>






</html>