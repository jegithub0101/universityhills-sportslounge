<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

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
    session_unset();
    session_destroy();
    header("Location: staff-login.php");
    exit();
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['loginbtn'])) {
        $nickname = $_POST['nickname'];
        $tablenumber = $_POST['tablenumber'];
        $tid = $_POST['tid'];

        // Prepared statement to check if the customer exists
        $sql_tid = "SELECT cid FROM customer WHERE table_number = ? AND nickname = ?";
        $stmt_tid = $connection->prepare($sql_tid);
        $stmt_tid->bind_param("is", $tablenumber, $nickname);
        $stmt_tid->execute();
        $result_tid = $stmt_tid->get_result();

        // Check if a row is returned, indicating successful verification
        if ($result_tid->num_rows > 0) {
            $_SESSION['tid'] = $tablenumber;
            $_SESSION['table_number'] = $tablenumber;
            $_SESSION['table_name'] = $nickname;
            header("location: client-product.php");
            exit;
        } else {
            $_SESSION['tid'] = $tablenumber;
            $_SESSION['table_number'] = $tablenumber;
            $_SESSION['table_name'] = $nickname;

            $active = 'trues'; // or 1 for true

            $insertSql = "INSERT INTO customer (tid, table_number, nickname, active) VALUES (?,?,?,?)";
            $insertStmt = $connection->prepare($insertSql);
            $insertStmt->bind_param("iiss",$tablenumber, $tablenumber, $nickname,$active);
            $insertStmt->execute();
            
            header("location: client-product.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assist | University Hills</title>
    <link rel="icon" href="Pic/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/sidebar.css">

    <style>
        .main-content{
            height: 100vh;
            overflow-x: hidden;
            background-image: url("Pic/backg.svg");
            background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center; 
            
           
        }
        .x{
            padding-top: 0;
        }
        body{
            font-family: "Poppins", sans-serif;
        }

        .containerblack{
            width: 100%;
           
        
        }
        .titleassist{
            color: white;
        }
        h2{
            margin-bottom: 5%;
        }
        .formlogin{
            background-color: #fff;
            width: 90%;
            margin: 14% 0% 0% 14%;
            padding: 7% 7% 7% 7%;
            border-radius: 13px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            
            background: rgba(18, 23, 30, 0.4); /* Dark color with transparency */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37); /* Deep shadow for depth */
            backdrop-filter: blur(10px); /* Frosted glass effect */
            -webkit-backdrop-filter: blur(10px); /* For Safari support */
            border: 1px solid rgba(255, 255, 255, 0.18); /* Light border to enhance the glass look */
            max-width: 800px;
            margin: 0 auto; /* Center the form */
            margin-top: 10%;
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
            border: 1px solid black;
            border-radius: 10px;
        }

        .formlogin label .input {
            background-color: #F6F6F6;
            width: 100%;
            padding: 20px 05px 05px 10px;
            outline: 0;
            border: 1px solid black;
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




        #loginbtn, #clearButton{
            background-color: whitesmoke;
            color: #141414;
            margin-left: 12%;
            width: 30%;
            height: 36px;
            border-radius: 7px;
            border: gray solid 2px;

        }
        #loginbtn:hover, #clearButton:hover{
            background-color: white;
            

        }

        .navbar{
            display:none;
        }

        @media only screen and (max-width: 992px) {
            .sidebar{
                display: none;
            }

            .main-content{
            top:50px;
            left:0px;
            width: 100%;
            }

            .navbar{
                display: block;
                background-color: #12171e;
            }
            .navbar-toggler{
                height: 30px;
                padding-top: 0px;
            }
            .navbar-toggler-icon{
                font-size: 8pt;
                margin-top: 0px;
            }

        }

   
    

        
    </style>


</head>
<body>
    <?php
        require 'staff-sidebar.php';
    ?>
  
<div class="main-content">
    <div class="container-fluid">
        <div class="container">
            <form method="POST" class="formlogin">
                
                <h2 class="titleassist"><i class="fa-solid fa-face-smile"></i> Assist a customer <i class="fa-solid fa-bowl-food"></i> <i class="fa-solid fa-bottle-droplet"></i></i></h2>
                
                <label>
    <select id="tablenumber" name="tablenumber" required>
        <option value="" disabled selected>number</option>
        <?php
        $sql = "SELECT tid, table_number FROM tables";
        $result = $connection->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['table_number']}' data-tid='{$row['tid']}'>{$row['table_number']}</option>"; 
        }
        ?>
    </select>
    <span>Table Number</span>
    </label>

    <label>
        <select id="tableclients" name="tableclients" disabled>
            <option value="" disabled selected>Customer/s</option>
        </select>
        <span>Customers</span>
    </label>

    <label>
        <input class="input" type="text" placeholder="" required name="nickname" >
        <span>Name</span>
    </label>  

                <!-- Hidden input for the tid -->
                <input type="hidden" name="tid" id="tid">

                <button type="submit" name="loginbtn" id="loginbtn">Enter</button>
                <button type="button" id="clearButton" class="clearbtn">Clear</button>
            </form>
        </div>
    </div>
</div>



<script>
    document.getElementById('tablenumber').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const tableNumber = this.value;
    const tid = selectedOption.getAttribute('data-tid'); // Get the tid from the selected option

    // Set the hidden input value
    document.getElementById('tid').value = tid;

    // Enable customer dropdown and nickname input
    document.getElementById('tableclients').disabled = false;
    

    // Fetch customer nicknames based on selected table number
    fetch(`get_customers.php?table_number=${tableNumber}`)
        .then(response => response.json())
        .then(data => {
            const tableClientsSelect = document.getElementById('tableclients');
            tableClientsSelect.innerHTML = '<option value="" disabled selected>Customer/s</option>'; // Reset options

            data.forEach(customer => {
                const option = document.createElement('option');
                option.value = customer.nickname;
                option.textContent = customer.nickname;
                tableClientsSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching customer data:', error));
});
        document.getElementById('tableclients').addEventListener('change', function() {
        const selectedNickname = this.value;
        document.querySelector('input[name="nickname"]').value = selectedNickname; // Set nickname input
        
    });
    
</script>
</body>

<script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function () {
        sidebar.classList.toggle('active');
    };
</script>


<script>
    document.getElementById('clearButton').addEventListener('click', function() {
    // Reset the table number dropdown
    document.getElementById('tablenumber').selectedIndex = 0;

    // Disable the customer dropdown and nickname input
    document.getElementById('tableclients').disabled = true;

    // Reset the customer dropdown options
    const tableClientsSelect = document.getElementById('tableclients');
    tableClientsSelect.innerHTML = '<option value="" disabled selected>Customer/s</option>';

    // Clear the nickname input
    document.querySelector('input[name="nickname"]').value = '';
});

</script>

</html>