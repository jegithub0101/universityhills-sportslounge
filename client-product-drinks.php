
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
        height: 400px;
        overflow:hidden;
        
        box-shadow: 5px 10px #898484;
        min-width: 250px;
        max-width: 252px;
        position: relative;

        border-radius: 10px ;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

        margin-top: 20px;
        margin-bottom: 1%;
      }
      .orderBtn{
        width: 100%;
        margin-top: 0%;
        
        font-weight: 500;
        margin-bottom: 0%;
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
    
      }
      .prodimg{
        width: 100%;
        height: 250px;
      }
      .details{
        margin-top: 10px;
      }
      .infodetail{
        width: 100%;
        height: 90px;
        overflow-y: auto;
        
        background-color: white;
        color: #12171e;
       
      }
      .white{
        background-color: #1F487E;
        color: black;
        padding: 2%;

      }
      /* if added to cart*/
      .gray{
        background-color: rgb(40, 167, 69);
        color: #fff;
        padding: 2%;
        pointer-events: none;
      }
      
      .namedetail, .categorydetail ,.stockdetail,.pricedetail{
        
        color: #12171e;
      }

      .namedetail {
        font-size: 18px;
            font-weight: bold;
            padding: 10px 15px 0px;
      }

      .pricedetail{
        padding: 0 15px 0px; /* Add some space below the price */
            font-size: 16px;
            color: #636262;
            font-weight: bold; /* Make price stand out */
      }

      .infodetail{
        padding: 10px 15px;
            font-size: 14px;
            color: #636262;
            height: 75px; /* Set a fixed height for the description area */
            overflow-y: auto; /* Add scroll if content exceeds height */
            flex-grow: 1; /* Allow the text area to expand */
           }
      .orderBtn{
        /* background-color: #1F487E; */
        color: #fff;
        transition: background-color 0.3s;
        border: none;
        height: 10%;
      }

      .orderBtn:hover{
        background-color: #1D3461;
        color: #fff;
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
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

                
            }
        }
        @media only screen and (max-width: 940px) {
            .showprodbox{
                min-width: 300px;
                max-width: 300px;
                margin-left: 50px; 
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

                
                
            }
        }
        @media only screen and (max-width: 840px) {
            .showprodbox{
                min-width: 300px;
                max-width: 300px;
                margin-left: 25px ;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

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
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

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
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

            }
          .crop-img{
            max-width: 100%; 
            max-height: 230px;
            overflow: hidden;
            border-radius: 10px;
            margin-top: 8%;

          }
          .prodimg{
            max-width: 100%;
            max-height: 150px;
          }
          
        }
        @media only screen and (max-width: 621px) {
          .showprodbox{
                min-width: 176px;
                max-width: 176px;
                margin-left: 0px ;
                max-height: 350px;
                
                font-size: 10pt;
                border-radius: 10px ;
                box-shadow: none;
                padding: 0px;
                padding-bottom: 0%;
                margin-top: 20px;
                margin-bottom: 1%;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

            }
            .crop-img,.prodimg{
              border-radius: 0px;
              border: none;
              margin-top: 0%;
            }

            .orderBtn{
              width: 100%;
              height: 10%;
              margin-top: 0%;
              font-weight: 500;
              border: none;
              margin-bottom: 0%;
              position: absolute;
              bottom: 0px;

            }
        
        }
        @media only screen and (max-width: 380px){
          .showprodbox{
                min-width: 156px;
                max-width: 156px;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

            }
        }
        @media only screen and (max-width: 320px){
          .showprodbox{
                min-width: 136px;
                max-width: 136px;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

            }
        }


</style>




<?php
// Fetch products from the database
$sql = "SELECT * FROM products where category='Drinks' AND stock > 0";
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
                
                <div class='namedetail'><?php echo $row['product_name']; ?></div>
                <div class='pricedetail'>₱<?php echo $row['price']; ?></div>
                <div class='infodetail'><strong>Description:</strong> <?php echo $row['information']; ?></div>
                <!-- <div class='infodetail'>
                    <p>
                        <?php
                        // Truncate the information to 7-8 words
                        $words = explode(' ', $row['information']);
                        $truncated_info = implode(' ', array_slice($words, 0, 7)) . '...';
                        echo $truncated_info;
                        ?>
                        <span class="read-more-link" onclick="openModal('<?php echo addslashes($row['information']); ?>')">Read more</span>
                    </p>
                </div> -->
                
            </div>
          


          <!-- AJAX-based form -->
            <form id="foodform_<?php echo $pid; ?>" class="foodform">
                <input type='hidden' name='pid' value='<?php echo $row['PID']; ?>'>
                <input type='hidden' name='pname' value='<?php echo $row['product_name']; ?>'>
                <input type='hidden' name='category' value='<?php echo $row['category']; ?>'>
                <input type='hidden' name='pstock' value='<?php echo $row['stock']; ?>'>
                <input type='hidden' name='pprice' value='<?php echo $row['price']; ?>'>
                <button type='button' class='<?php echo $bgcolor; ?> orderBtn' 
                      name="orderBtn" 
                      onclick="addToCart(<?php echo $pid; ?>)" 
                      <?php echo $disabled; ?>>
                  <?php echo $added; ?>
              </button>
            </form>
            <div id="response_<?php echo $pid; ?>" class="response"></div>
        </div>
    <?php } ?>
<?php } ?>



<!-- Include jQuery for AJAX -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function addToCart(pid) {
    // Get the form data
    var formData = $('#foodform_' + pid).serialize();

    // Perform AJAX request
    $.ajax({
        type: 'POST',
        url: 'handle_add_to_cart.php',  // This is the file handling the cart addition
        data: formData,
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status === "success") {
                // Update button text and disable it
                $('#foodform_' + pid + ' .orderBtn').html('Added').prop('disabled', true).css('background-color', 'gray');
                $('#response_' + pid).html('<span style="color:green;">' + res.message + '</span>');
            } else {
                $('#response_' + pid).html('<span style="color:red;">' + res.message + '</span>');
            }
        },
        error: function() {
            $('#response_' + pid).html('<span style="color:red;">An error occurred.</span>');
        }
    });
}
</script>



