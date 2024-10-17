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
        .cards{
            max-width:350px;
            min-width:350px;
            
            
        }
        @media only screen and (max-width: 992px) {
        .cards{
            margin-right:1%
            margin-left:1%;
            max-width:300px;
            min-width:300px;
        }
        }
        @media only screen and (max-width: 771px) {
        .cards{
            margin:.5%;
            max-width:250px;
            min-width:250px;
        }
        }
        @media only screen and (max-width: 605px) {
        .cards{
            
            max-width:220px;
            min-width:220px;
        }
        .det{
            font-size:11pt
        }
        .ptitle{
            font-size:11pt;
        }
        }

        @media only screen and (max-width: 540px) {
        .cards{
            margin:0%;
            max-width:200px;
            min-width:200px;
        }
        }

        @media only screen and (max-width: 500px) {
        .cards{
            max-width:300px;
            min-width:300px;
            margin-left:10%;
        }
        }
        @media only screen and (max-width: 430px) {
        .cards{
           
            margin-left:3%;
        }
        }
        @media only screen and (max-width: 400px) {
        .cards{
            margin-left:0%;
        }
        }
        /* @media only screen and (max-width: 605px) {
        .cards{
            margin:.5%;
            max-width:250px;
            min-width:250px;
        }
        .det{
            font-size:11pt
        }
        } */


        .description{
            width: 100%;
            border-top: 1px solid black;
            margin-top:25px;
            color:black;
        }
                                      

</style>

<div class="">
                <?php
                $sql = "SELECT distinct table_number,tracking_no,cid from admin_order where status !='Done' and status !='Request'";
                $result = $connection->query($sql);

                if ($result->num_rows > 0) {
                    // Loop through each customer ID
                    while ($row = $result->fetch_assoc()) {
                        $cid = $row["cid"];
                        $tracking = $row['tracking_no'];
                        $table_num = $row['table_number'];


                        //count the called status of that tracking order
                        $sql_cancelled = "SELECT COUNT(*) AS cancelled_count FROM admin_order WHERE cid=$cid and tracking_no = '$tracking' and status = 'Cancelled'";
                        $result_cancelled = $connection->query($sql_cancelled);
                        $row_cancelled = $result_cancelled->fetch_assoc();
                        
                        //count of tracking order
                        $sql_count = "SELECT COUNT(*) AS count_track FROM admin_order WHERE cid=$cid and tracking_no = '$tracking'";
                        $result_track = $connection->query($sql_count);
                        $row_track = $result_track->fetch_assoc();


                        //count of preparing status
                        $sql_preparing = "SELECT COUNT(*) AS prepared_count FROM admin_order WHERE cid=$cid and tracking_no = '$tracking' and status = 'Preparing'";
                        $result_preparing = $connection->query($sql_preparing);
                        $row_preparing = $result_preparing->fetch_assoc();
                        
                        $hide = "";
                        if($row_preparing['prepared_count'] === $row_track['count_track']){
                            $hide = "hide";
                        }
                        
                        //---------------------------------------------
                        // If the count of status cancelled is not equal to tracking order, then print it.
                    if ($row_track['count_track'] !== $row_cancelled['cancelled_count']) {
                        ?>
                        <div class="col-sm-5 col-md-3 col-lg-3 col-xl-3 cards">
                            <div class="card">
                                <div class="card-body" data-tracking="<?php echo $tracking; ?>">
                                <button class="btn btn-outline-success btnaccept <?php echo $hide ?>" id="actionaccept" onclick="confirmAccept('<?php echo $cid; ?>', '<?php echo $tracking; ?>', this)"><i class="fa-solid fa-check"></i></button>
                                            <button class="btn btn-outline-danger btndelete <?php echo $hide ?>" id="actiondelete" onclick="confirmDelete('<?php echo $cid; ?>', '<?php echo $tracking; ?>', this)"><i class="fa-solid fa-x"></i></button>
                                    <h5 class="card-title"><?php echo "Table: " . $table_num; ?></h5>
                                    <?php
            
                                    // Query to get product names for the current customer ID
                                    $sql_pname = "SELECT * FROM admin_order WHERE cid=$cid and tracking_no = '$tracking'";
                                    $result_pname = $connection->query($sql_pname);
            
                                    // Check if there are any product names for the current customer ID
                                    if ($result_pname !== false && $result_pname->num_rows > 0) {
                                        ?>
                                         <div class=" d-flex bd-highlight">
                                            <div class="ptitle prodnameh flex-fill bd-highlight"> Name </div>
                                            <div class="ptitle pquantityh flex-fill bd-highlight"> Qty </div>
                                        </div>
                                        <?php
                                        // Loop through each product name
                                        while ($row_pname = $result_pname->fetch_assoc()) {
                
                                            ?>
                                         <div class="d-flex bd-highlight det">
                                            <div class="pquantity flex-fill bd-highlight">
                                                <?php echo $row_pname['product_name']; ?>
                                            </div>
                                            <div class="pquantity flex-fill bd-highlight">
                                               <?php echo $row_pname['quantity']; ?>
                                            </div>
                                         </div>

                                    <?php
                                        }
                                    } else {
                                        echo "No products found for customer ID: $cid, it might be cancelled due to lack of stock";
                                    }

                                          
                                        $sql_description = "SELECT * FROM product_instruction WHERE tracking_no = '$tracking'";
                                        $result_descript = $connection->query($sql_description);
                                        if ($result_descript) {
                                            if ($result_descript->num_rows > 0) {
                                                ?>
                                                
                                                <div class="description">
                                                    <?php
                                                    echo "<p>INSTRUCTION</p>";
                                                    while ($row = $result_descript->fetch_assoc()) {
                                                        echo $row['instruction']; 
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                            } 
                                        } else {
                                            echo "Error executing query: " . $connection->error;
                                        }
                       

                                    if($row_preparing['prepared_count'] !== $row_track['count_track']){
                                    ?>
                                        <button class="donebtn btn btn-primary" id="donebtn" name="donebtn" onclick="confirmDone('<?php echo $cid; ?>', '<?php echo $tracking; ?>', this)">DONE</button>
                                    <?php
                                    }else{
                                    ?>
                                       <button class="donebtn1 btn btn-primary" id="donebtn" name="donebtn" onclick="confirmDone('<?php echo $cid; ?>', '<?php echo $tracking; ?>', this)">DONE</button>
                                    <?php
                                    }
                                    ?>
                                
                                </div>
                            </div>
                        </div>
            <?php
                    }
                }
            } else {
                echo "No customer IDs found in the database.";
            }
            ?>
            </div>