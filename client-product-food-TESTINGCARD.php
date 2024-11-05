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

function isLoggedIn() {
    return isset($_SESSION['table_number']);
}

// Redirect to login page if not logged in
if (!isLoggedIn()) {
    header("Location: client-login.php");
    exit;
}

// Fetch products from the database
$sql = "SELECT * FROM products WHERE category='Foods' AND stock > 0";
$result = $connection->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Example</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        /* Helper Styles */
        body {
            font-family: Varela Round, sans-serif;
            background: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
        }

        /* Card Styles */
        .container {
            margin-top: 50px;
        }

        .card-bottom-margin {
          margin-bottom: 15px;
        }

        .card-sl {
            display: flex; /* Make the card a flex container */
            flex-direction: column; /* Stack children vertically */
            border-radius: 8px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            background: #fff;
            margin-bottom: 20px;
            height: 100%; /* Allow the card to grow to full height */
        }


        .card-image img {
            max-height: 200px;
            width: 100%;
            border-radius: 8px 8px 0px 0;
            object-fit: cover;
        }

        .card-heading {
            font-size: 18px;
            font-weight: bold;
            padding: 10px 15px 0px;
        }

        .card-price {
            padding: 0 15px 0px; /* Add some space below the price */
            font-size: 16px;
            color: #636262;
            font-weight: bold; /* Make price stand out */
        }

        .card-text {
            padding: 10px 15px;
            font-size: 14px;
            color: #636262;
            height: 60px; /* Set a fixed height for the description area */
            overflow-y: auto; /* Add scroll if content exceeds height */
            flex-grow: 1; /* Allow the text area to expand */
        }

        .card-button {
            display: flex;
            justify-content: center;
            align-items: center; /* Center the text vertically */
            padding: 10px 0;
            width: 100%;
            background-color: #1F487E;
            color: #fff;
            border: none; /* Remove border for button appearance */
            border-radius: 0 0 8px 8px;
            cursor: pointer; /* Change cursor to pointer */
            text-align: center; /* Center the text horizontally */
            transition: background-color 0.3s; /* Smooth background transition */
            font-size: 16px; /* Optional: Adjust font size */
        }

        .card-button:hover {
            background-color: #1D3461;
            color: #fff;
        }

        .card-button.disabled {
            background-color: #ccc; /* Change color when disabled */
            cursor: not-allowed; /* Change cursor to not-allowed */
        }

        /* Reduce margin on mobile */
        @media (max-width: 576px) {
            .col-6 {
                padding: 5px; /* Adjust padding to reduce space between columns */
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    $image = 'data:image/jpeg;base64,' . base64_encode($row['image']);
                    $productName = htmlspecialchars($row['product_name']);
                    $price = htmlspecialchars($row['price']);
                    $description = htmlspecialchars($row['information']);
            ?>
                    <div class="col-6 col-md-4 col-lg-3 col-xl-3 card-bottom-margin">
                        <div class="card-sl">
                            <div class="card-image">
                                <img src="<?php echo $image; ?>" alt="<?php echo $productName; ?>" />
                            </div>
                            <div class="card-heading">
                                <?php echo $productName; ?>
                            </div>
                            <div class="card-price">
                                ₱<?php echo number_format($price, 2); ?>
                            </div>
                            <div class="card-text">
                                <strong>Description: </strong><?php echo $description; ?>
                            </div>
                            <button class="card-button">Add</button>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No products available.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
