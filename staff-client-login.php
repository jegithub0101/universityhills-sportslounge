<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}


?>



<div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10 con1">
            <div class="containerblack">

                <form method="POST" class="formlogin">
                    <h2>Thank you For Assisting</h2>
                    

                    <label>
                        <input class="input" type="text" placeholder="" required="" name="nickname">
                        <span>name</span>
                    </label>

                    <label class="">
                        <select id="tablenumber" name="tablenumber" class="" required="">
                            <option value="" disabled selected>Table Number</option>
                            <?php
                                $sql = "SELECT table_number FROM tables";

                                $result = $connection->query($sql);
                                if(!$result){
                                    die("Invalid query: ". $connection->connect_error);
                                }

                                while($row = $result->fetch_assoc()){
                                    
                                    echo"
                                    <option value='$row[table_number]'>$row[table_number]</option>
                                    ";
                                }
                            ?>
                        </select>
                        <span class="tablenumber">Table Number</span>
                        </label>

                    <button type="submit" name="loginbtn" id="loginbtn">Enter</button>
                </form>
            </div>
        </div>
 