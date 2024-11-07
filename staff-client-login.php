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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You | University Hills</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .containerblack {
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 600px;
            width: 90%;
        }

        h2 {
            font-weight: 600;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .formlogin {
            display: flex;
            flex-direction: column;
        }

        label {
            position: relative;
            margin-bottom: 20px;
        }

        input.input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input.input:focus, select:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff; 
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3; 
        }

        /* Responsive */
        @media (max-width: 768px) {
            h2 {
                font-size: 20px; 
            }

            input.input, select, button {
                font-size: 14px; 
            }
        }

        @media (max-width: 576px) {
            h2 {
                font-size: 18px; 
            }

            button {
                padding: 8px; 
            }
        }
    </style>
</head>
<body>

<div class="row">
    <div class="col-12 mx-auto">
        <div class="containerblack">
            <form method="POST" class="formlogin">
                <h2>Thank you For Assisting</h2>

                <label>
                    <input class="input" type="text" placeholder="" required="" name="nickname">
                    <span>Name</span>
                </label>

                <label>
                    <select id="tablenumber" name="tablenumber" class="" required="">
                        <option value="" disabled selected>Table Number</option>
                        <?php
                        $sql = "SELECT table_number FROM tables";
                        $result = $connection->query($sql);
                        if (!$result) {
                            die("Invalid query: " . $connection->connect_error);
                        }

                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='$row[table_number]'>$row[table_number]</option>";
                        }
                        ?>
                    </select>
                    <span class="tablenumber">Table Number</span>
                </label>

                <button type="submit" name="loginbtn" id="loginbtn">Enter</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>