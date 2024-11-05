<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";
//Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

?> 

<style>

    .one {
        /* Removing fixed width to allow cards to fill space */
        width: 50%; 
        padding: 15px; /* Optional: Add some padding inside the card */
    }

    @media (max-width: 768px) {
        .one {
            margin-left: 0; /* Ensure no margin on smaller screens */
        }
    }

    @media only screen and (max-width: 1808px) {
        .one {
            max-width: 600px;
            margin-right: 5%;
        }
    }
    @media only screen and (max-width: 1354px) {
        .one {
            margin-left: 20%;
        }
    }
    @media only screen and (max-width: 992px) {
        .one {
            margin-left: 7%;
        }
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
    }
    @media (max-width: 732px) {
        .navbar-brand {
            font-size: 13pt;
        }
    }
    @media only screen and (max-width: 736px) {
        .one {
            margin-left: 0%;
        }
        .main-content {
            padding-left: 0%;
        }
        .requestbill {
            margin-left: 70%;
        }
    }
    @media only screen and (max-width: 648px) {
        .one {
            margin-left: 0%;
            max-width: 300px;
        }
    }
    @media only screen and (max-width: 574px) {
        .one {
            min-width: 450px;
        }
    }
    @media only screen and (max-width: 490px) {
        .one {
            min-width: 380px;
            font-size: 10pt;
        }
    }
    @media only screen and (max-width: 428px) {
        .one {
            width: 100%;
            font-size: 10pt;
        }
    }
</style>

<?php
$table_number = $_SESSION['table_number'];
$table_name = $_SESSION['table_name'];

$sql_cid = "SELECT cid FROM customer WHERE table_number = $table_number and nickname = '$table_name'";
$result_cid = $connection->query($sql_cid);
$row_cid = $result_cid->fetch_assoc();
$cid = $row_cid['cid'];
?>

<div class="row conn">
    <!------------------------------------------------------>
    <div class="col-sm-12 col-md-6 one">
        <h3>MONITORING</h3>
        <div class="cards">
            <div class="containeritem d-flex bd-highlight">
                <div class="prodnameh flex-fill bd-highlight"> NAME </div>
                <div class="pquantityh flex-fill bd-highlight"> QTY </div>
                <div class="ppriceh flex-fill bd-highlight">PRICE</div>
                <div class="pstotalh flex-fill bd-highlight">SUB</div>
                <div class="prodstatush flex-fill bd-highlight">STATUS</div>
            </div>
            <?php
            $sql_monitor = "SELECT DISTINCT tracking_no FROM admin_order WHERE table_number = $table_number AND cid=$cid";
            $result_monitor = $connection->query($sql_monitor);
            if ($result_monitor->num_rows > 0) {
                while ($row = $result_monitor->fetch_assoc()) {
                    $tracking = $row['tracking_no'];

                    $sql_cancelled_preparing = "SELECT * FROM admin_order WHERE cid=$cid AND tracking_no = '$tracking' AND table_number = $table_number";
                    $result_can_pre = $connection->query($sql_cancelled_preparing);
                    $row_can_pre = $result_can_pre->fetch_assoc();

                    if ($row_can_pre['status'] === "Cancelled" || $row_can_pre['status'] === "Preparing" || $row_can_pre['status'] == "pending") {
                        ?>
                        <div class="containerorder">
                            <?php
                            $sql_monitor_item = "SELECT * FROM admin_order WHERE cid=$cid AND tracking_no = '$tracking' AND table_number = $table_number";
                            $result_monitor_item = $connection->query($sql_monitor_item);
                            if ($result_monitor_item->num_rows > 0) {
                                while ($row_item = $result_monitor_item->fetch_assoc()) {
                                    ?>
                                    <div class="containeritem d-flex bd-highlight">
                                        <div class="prodname flex-fill bd-highlight"> <?php echo $row_item['product_name']; ?> </div>
                                        <div class="pquantity flex-fill bd-highlight"><?php echo $row_item['quantity']; ?></div>
                                        <div class="pprice flex-fill bd-highlight"><?php echo $row_item['price']; ?></div>
                                        <?php
                                        $subtotal = $row_item['quantity'] * $row_item['price'];
                                        ?>
                                        <div class="pstotal flex-fill bd-highlight"><?php echo $subtotal; ?></div>
                                        <div class="prodstatus flex-fill bd-highlight"><?php echo $row_item['status']; ?></div>
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
            ?>
        </div>
    </div>
    <!------------------------------------------------------>
    <div class="col-sm-12 col-md-6 one">
        <h3 class="title">ORDERS OF TABLE <?php echo $table_number ?></h3>
        <div class="cards">
            <?php $total_amount = 0; ?>
            <?php
            $sql_monitor_cid = "SELECT DISTINCT cid FROM admin_order WHERE table_number = $table_number AND status = 'Done'";
            $result_monitor_cid = $connection->query($sql_monitor_cid);

            if ($result_monitor_cid->num_rows > 0) {
                while ($row_cid = $result_monitor_cid->fetch_assoc()) {
                    $cid_user = $row_cid['cid'];

                    $sql_monitor_name = "SELECT nickname FROM customer WHERE cid=$cid_user";
                    $result_monitor_name = $connection->query($sql_monitor_name);
                    $row_monitor_name = $result_monitor_name->fetch_assoc();
                    ?>
                    <div class="name lead"><?php echo $row_monitor_name['nickname']; ?></div>

                    <div class="containeritem d-flex bd-highlight">
                        <div class="prodnameh flex-fill bd-highlight"> NAME </div>
                        <div class="pquantityh flex-fill bd-highlight"> QTY </div>
                        <div class="ppriceh flex-fill bd-highlight">PRICE</div>
                        <div class="pstotalh flex-fill bd-highlight">SUBTOTAL</div>
                        <div class="prodstatush flex-fill bd-highlight">STATUS</div>
                    </div>

                    <?php
                    $sql_monitor = "SELECT DISTINCT tracking_no FROM admin_order WHERE table_number = $table_number AND cid=$cid_user";
                    $result_monitor = $connection->query($sql_monitor);
                    if ($result_monitor->num_rows > 0) {
                        while ($row = $result_monitor->fetch_assoc()) {
                            $tracking = $row['tracking_no'];

                            $sql_cancelled_preparing = "SELECT * FROM admin_order WHERE cid=$cid_user AND tracking_no = '$tracking' AND table_number = $table_number";
                            $result_can_pre = $connection->query($sql_cancelled_preparing);
                            $row_can_pre = $result_can_pre->fetch_assoc();

                            if ($row_can_pre['status'] === "Done") {
                                ?>
                                <div class="containerorder">
                                    <?php
                                    $sql_monitor_item = "SELECT * FROM admin_order WHERE cid=$cid_user AND tracking_no = '$tracking' AND table_number = $table_number AND status = 'DONE'";
                                    $result_monitor_item = $connection->query($sql_monitor_item);
                                    if ($result_monitor_item->num_rows > 0) {
                                        while ($row_item = $result_monitor_item->fetch_assoc()) {
                                            $subtotal = $row_item['quantity'] * $row_item['price'];
                                            $total_amount += $subtotal; // Add the subtotal to the total amount
                                            ?>
                                            <div class="containeritem d-flex bd-highlight">
                                                <div class="prodname flex-fill bd-highlight"> <?php echo $row_item['product_name']; ?> </div>
                                                <div class="pquantity flex-fill bd-highlight"><?php echo $row_item['quantity']; ?></div>
                                                <div class="pprice flex-fill bd-highlight"><?php echo $row_item['price']; ?></div>
                                                <div class="pstotal flex-fill bd-highlight"><?php echo $subtotal; ?></div>
                                                <div class="prodstatus flex-fill bd-highlight"><?php echo $row_item['status']; ?></div>
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
                }
            } else {
                echo "No Orders Yet!";
            }
            ?>
            <div class="total flex-fill bd-highlight">
                <strong>Total Amount: <?php echo $total_amount; ?></strong>
            </div>
        </div>
    </div>
    <!------------------------------------------------------>
</div>
