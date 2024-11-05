
<?php
session_start();
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

function isLoggedIn()
{
    return isset($_SESSION['table_number'] );
}

// Redirect to login page if not logged in
if (!isLoggedIn()) {
    header("Location: client-login.php");
    exit;
}



?>

<style>
    .showprodbox{
        background-color: white;
        color: white;
        margin-top: 40px;
        float: left;
        margin-right: 1%;
        height: 500px;
        overflow:hidden;
        
        box-shadow: 5px 10px #898484;
        min-width: 250px;
        max-width: 252px;
        position: relative;

        border-radius: 5px ;
        border: 1px solid #12171e;
        box-shadow: none;

        margin-top: 20px;
        margin-bottom: 1%;
      }
      .orderBtn{
        width: 100%;
        margin-top: 0%;
        
        font-weight: 500;
        margin-bottom: 0%;
        border-top: 1px solid #12171e;
        position: absolute;
        bottom: 0px;
        border-radius: 0px;

        }
        .details span{
          font-weight: 500;
          color: brown;
        }
       

      .crop-img{
        max-width: 100%; 
        max-height: 230px;
        overflow: hidden;
      
        
        margin-top: 0%;
        border-bottom: 1px solid #12171e;
      }
      .prodimg{
        width: 100%;
        height: 250px;
      }
      .details{
        margin-top: 10px;
      }
      .infodetail{
        width: 97%;
        height: 90px;
        overflow-y: auto;
        
        background-color: white;
        color: #12171e;
       
      }
      .white{
        background-color: white;
        color: black;
        padding: 2%;

      }
      .gray{
        background-color: #12171e;
        color: gray;
        padding: 2%;
      }
      
      .namedetail, .categorydetail ,.stockdetail,.pricedetail{
        color: #12171e;
      }
      .orderBtn{

        border: none;

        border-top: 1px solid #12171e;
      }
      .colempty{
       margin-top: 14%;
       margin-left: 25%; 
      }
      
      @media only screen and (max-width: 1300px) {
            .colempty{
          margin-top: 14%;
          margin-left: 10%; 
      }
        } 

      @media only screen and (max-width: 1044px) {
            .showprodbox{
                min-width: 250px;
                max-width: 250px;
                margin-left: 30px;
                
            }
        }
        @media only screen and (max-width: 940px) {
            .showprodbox{
                min-width: 300px;
                max-width: 300px;
                margin-left: 50px 
                
                
            }
        }
        @media only screen and (max-width: 840px) {
            .showprodbox{
                min-width: 300px;
                max-width: 300px;
                margin-left: 25px ;
            }
            .colempty img{
                width: 90%;
            }
        }
        @media only screen and (max-width: 740px) {
            .showprodbox{
                min-width: 250px;
                max-width: 255px;
                margin-left: 25px ;
            }
            .details{
              margin-left: 5px;
            }
        }
        @media only screen and (max-width: 700px) {
          .showprodbox{
                min-width: 170px;
                max-width: 170px;
                margin-left: 10px ;
                max-height: 375px;
                font-size: 10pt;
            }
          .crop-img{
            max-width: 100%; 
            max-height: 230px;
            overflow: hidden;
            border-radius: 10px;
            border: 1px solid #12171e; 
            margin-top: 8%;

          }
          .prodimg{
            max-width: 100%;
            max-height: 150px;
          }
          .infodetail{
           
            height: 70px;
            
          
            }
        }
        @media only screen and (max-width: 621px) {
          .showprodbox{
                min-width: 176px;
                max-width: 176px;
                margin-left: 0px ;
                max-height: 350px;
                
                font-size: 10pt;
                border-radius: 5px ;
                border: 1px solid #12171e;
                box-shadow: none;
                padding: 0px;
                padding-bottom: 0%;
                margin-top: 20px;
                margin-bottom: 1%;
            }
            .crop-img,.prodimg{
              border-radius: 0px;
              border: none;
              margin-top: 0%;
            }
            .crop-img{
              border-bottom: 1px solid #12171e;
            }
            .orderBtn{
              width: 100%;
              margin-top: 0%;
              font-weight: 500;
              border: none;
              margin-bottom: 0%;
              border-top: 1px solid #12171e;
              position: absolute;
              bottom: 0px;

            }
            span{
              font-weight: 500;
              color: brown;
            }
            
           
        
        }
        @media only screen and (max-width: 380px){
          .showprodbox{
                min-width: 156px;
                max-width: 156px;
            }
        }
        @media only screen and (max-width: 320px){
          .showprodbox{
                min-width: 136px;
                max-width: 136px;
            }
        }


</style>


<?php
// Fetch products from the database
$sql = "SELECT * FROM products where category!='Drinks' AND category!='Foods' AND stock > 0";
$result = $connection->query($sql);

?>

<?php
if ($result->num_rows === 0) {
    echo "
        <div class='col-xl-12 colempty'>
            <img class='empty' src='Pic/empty.svg' alt=''>
        </div>";
} else {
    while ($row = $result->fetch_assoc()) {

      $table_number =  $_SESSION['table_number'];
      $table_name = $_SESSION['table_name'];

        $sql_cid = "SELECT cid FROM customer WHERE table_number = $table_number and nickname = '$table_name'";
        $result_cid = $connection->query($sql_cid);
        $row_cid = $result_cid->fetch_assoc();
        $cid = $row_cid['cid'];

        //--------------------------------------------------------------------

        $pid = $row['PID'];
        $disabled = "";
        $added = "";

          // Check if the product exists in the customer's cart
        $sql_check_cart = "SELECT * FROM customer_cart WHERE cid = $cid AND pid = $pid";
        $reult_check_cart = $connection->query($sql_check_cart);

        // If the product exists in the cart, disable the button
          if ($reult_check_cart->num_rows > 0) {
            $disabled = "disabled";
            $added = "Added";
            $bgcolor = "gray";
        } 
        else{
          $added = "Add";
          $bgcolor = "white";
        }


        ?>
        
        <div class='showprodbox col-sm-12 col-md-5 col-lg-4 col-xl-2'>
            <div class='crop-img'>
                <img src='data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>' alt='' class='prodimg'>
            </div>
            <div class='details'>
                
                <div class='namedetail'><span>Name:</span> <?php echo $row['product_name']; ?></div>
                <div class='categorydetail'><span>Category:</span> <?php echo $row['category']; ?></div>
                <div class='stockdetail'><span>Stocks:</span> <?php echo $row['stock']; ?></div>
                <div class='pricedetail'><span>Price: </span> <?php echo $row['price']; ?></div>
                <div class='infodetail'><span>Information:</span> <?php echo $row['information']; ?></div>
                
            </div>
          


            <form form id="foodform" method="POST" action="client-product.php">
                <input type='hidden' name='pid' id="pid" value='<?php echo $row['PID']; ?>'>
                <input type='hidden' name='pname' id="pname" value='<?php echo $row['product_name']; ?>'>
                <input type='hidden' name='category' value='<?php echo $row['category']; ?>'>
                <input type='hidden' name='pstock' id="pstock" value='<?php echo $row['stock']; ?>'>
                <input type='hidden' name='pprice' id="pprice" value='<?php echo $row['price']; ?>'>
                <input type='hidden' name='pinformation' value='<?php echo $row['information']; ?>'>
                <!--while showing the product, check also if that product is already existing in the customer_cart. if yes, then the button must be disabled.-->

                <button type='submit' class=' <?php echo $bgcolor; ?> orderBtn' name="orderBtn" form="foodform" onclick="populateorder('<?php echo $row['PID']; ?>', '<?php echo $row['product_name']; ?>', '<?php echo $row['price']; ?>','<?php echo $row['stock'] ?>')" <?php echo $disabled; ?>> <?php echo $added  ?></button>

              </form>
            <div class='response'></div>
        </div>
    <?php } ?>
<?php } ?>

 <div>
  <!--tinggal ko yung ajax. pakibalik dex
 </div>-->

 <script>
   function populateorder(productId, productName, price,stock) {
                // Populate values in the modal form
                document.getElementById('pid').value = productId;
                document.getElementById('pname').value = productName;
                document.getElementById('pprice').value = price;
                document.getElementById('pstock').value = stock;
        }
 </script>



