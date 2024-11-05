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



if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['loginbtn'])){
        $nickname = $_POST['nickname'];
        $verification = $_POST['verification'];
        $tablenumber = $_POST['tablenumber'];
        
        // Prepared statement to prevent SQL injection
        $sql = "SELECT table_number FROM tables WHERE table_number=? AND verification_code=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("is", $tablenumber, $verification);
        $stmt->execute();
        $result = $stmt->get_result();


         // Prepared statement to retrieve tid based on the selected table_number
         $sql_tid = "SELECT tid, table_number FROM tables WHERE table_number = ?";
         $stmt_tid = $connection->prepare($sql_tid);
         $stmt_tid->bind_param("i", $tablenumber);
         $stmt_tid->execute();
         $result_tid = $stmt_tid->get_result();
 

        // Check if a row is returned, indicating successful verification
        if($result->num_rows > 0){

            $row_tid = $result_tid->fetch_assoc();
            $tid = $row_tid['tid'];

            $_SESSION['table_id'] = $row_tid['tid'];
            $_SESSION['table_number'] = $row_tid['table_number'];


            $insertSql = "INSERT INTO customer (tid,table_number, nickname) VALUES (?,?,?)";
            $insertStmt = $connection->prepare($insertSql);
            $insertStmt->bind_param("iis", $tid, $tablenumber, $nickname);
            $insertStmt->execute();

            $_SESSION['table_name'] = $nickname;
            // Redirect to client-product.php
            header("location: client-product.php");
            exit;
        } else {
            // Verification failed, provide feedback to the user
                     // Set session variable for incorrect login attempt
                $_SESSION['login_error'] = "Incorrect verification code.";
                // Redirect back to the login page
                header("Location: client-login.php");
                exit();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | University Hills</title>
    <link rel="icon" href="Pic/uhicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style type="text/css">
        body{
            background-color: white;
            font-family: "Poppins", sans-serif;
        }
        .wholecontainer{
            height: 100vh;
            border-radius: 0px;
        }
        .con1{

            padding: 0%;
        }
        .biglogo{
            width: 60%;
            margin-left: 18%;
            margin-right: 18%
        }
        .quote{
            font-family: "Poppins", sans-serif;
            font-size: 25pt;
            margin: 0% 0% 25% 15%;
            
        }
        .wineglass{
            padding: 0;
            margin: 0;
        }
        .con11{
            position: relative;
            border-radius: 0px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        
        }
        .con11>.wineglass{
            width: 38%;
            position: absolute;
            bottom: 0px;
            left: 360px;
        }
        .containerblack{
            width: 100%;
            height: 100vh;
            background-color: #141414;
            border-radius: 0px 10px 10px 0px;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5), 
              -5px -5px 10px rgba(255, 255, 255, 0.5);
            padding-top: 16%;
            align-items: center;
            display: flex;
            
        }

        h2{
            margin-bottom: 5%;
        }

        .error-label {
            color: red;
        }
    
    

    </style>
</head>
<body>
    <div class="container-fluid wholecontainer">
        <div class="row">
            
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 con1">
                    <div class="con11">
                        <img src="Pic/Logo.svg" alt="Loading" class="biglogo">
                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 con1">
                    <div class="containerblack">

                
                        <style >
                            .formlogin{
                                background-color: #fff;
                                width: 70%;
                                margin: 5% 14% 14% 14%;
                                padding: 7% 7% 7% 7%;
                                border-radius: 13px;
                            }
                            .formlogin>h2{
                                text-align: center;
                                font-weight: bold;
                            }
                            .formlogin>p{
                                font-size: 14pt;
                                text-align: center;
                            }
                            .formlogin>label{
                                width: 100%;
                                margin-bottom: 2%;
                                margin-top: 5%
                            }

                            .formlogin label .input,.formlogin label select {
                                background-color: #F6F6F6;
                                width: 100%;
                                padding: 20px 05px 05px 10px;
                                outline: 0;
                                border: 1px solid rgba(105, 105, 105, 0.397);
                                border-radius: 10px;
                            }

                            .formlogin label .input {
                                background-color: #F6F6F6;
                                width: 100%;
                                padding: 20px 05px 05px 10px;
                                outline: 0;
                                border: 1px solid rgba(105, 105, 105, 0.397);
                                border-radius: 10px;
                            }
                            
                            .formlogin label {
                                position: relative;
                            }
                            .formlogin label .input + span {
                                color: black;
                                position: absolute;
                                left: 10px;
                                top: 0px;
                                font-size: 0.9em;
                                cursor: text;
                                transition: 0.3s ease;
                            }
                                 /*malaki lang yung text*/
                            .formlogin label .input:placeholder-shown + span {
                                    top: 12.5px;
                                    font-size: 0.9em;
                            }

                            .formlogin label .input:focus + span,
                                .formlogin label .input:valid + span {
                                color: #00bfff;
                                top: 0px;
                                font-size: 0.7em;
                                font-weight: 600;
                            }

                            
                            .formlogin label select + span{
                                color: black;
                                position: absolute;
                                left: 10px;
                                top: 3px;
                                font-size: 0.9em;
                                cursor: text;
                                transition: 0.3s ease;
                            }

                            .formlogin label select:placeholder-shown + span {
                                    top: 12.5px;
                                    font-size: 0.9em;
                            }

                            .formlogin label select:focus + span,
                            .formlogin label select:valid + span
                                 {
                                color: #00bfff;
                                top: 0px;
                                font-size: 0.7em;
                                font-weight: 600;
                                
                            }




                            button{
                                background-color: #141414;
                                color: whitesmoke;
                                margin-left: 28%;
                                width: 40%;
                                height: 36px;
                                border-radius: 7px;

                            }
                            button:hover{
                                background-color: whitesmoke;
                                color: #141414;

                            }

                            .signup{
                                font-family: "poppins";
                                margin: 4% 0% 4% 0%;
                            }

                            @media screen and (max-width: 992px) {
                                .con11>p, .con11>.wineglass{
                                    display: none;
                                }
                                .biglogo{
                                    width: 40%;
                                }
                                .formlogin{
                                    width: 80%;
                                    margin: 10%;
                                    height: 100%;
                                }
                                .containerblack{
                                    padding-top: 4%;
                                    height: auto;
                                    padding-bottom: 2%;
                                }
                            }
                        </style>

                        <form method="POST" class="formlogin">
                            <h2>WELCOME, CUSTOMER!</h2>
                            <p class="lead">Kindly ask for a staff to enter verification. Thank you!</p>

                            <?php
                            if (isset($_SESSION['login_error'])) {
                                echo '<div class="error-label">'.$_SESSION['login_error'].'</div>';
                                unset($_SESSION['login_error']); // Remove error message after displaying it
                            }
                            ?>

                            <label>
                                <input class="input" type="text" placeholder="" required="" name="nickname">
                                <span>nickname</span>
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

                            <label>
                                <input class="input" type="password" placeholder="" required="" name="verification">
                                <span>verification</span>
                            </label>
                            <button type="submit" name="loginbtn" id="loginbtn">Login</button>
                        </form>

                    
                        
                    </div>
                </div>
        </div>
    </div>
    
</body>
</html>