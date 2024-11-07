<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

// Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

if($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}

// Function to check if the user has already billed out
function didbillout()
{
    return isset($_SESSION['billout']);
}

// Redirect to login page if the user has not billed out
if (!didbillout()) {
    header("Location: client-login.php");
    exit;
}

$_SESSION['visited'] = true;

// Set the session expiration time to 3 minutes (180 seconds)
$session_expiration = 20; // In seconds

// Check if the session variable for last activity time is set
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_expiration)) {
    // If the session has expired, destroy the session
    session_unset();
    session_destroy();
}

// Update the last activity time
$_SESSION['last_activity'] = time();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_SESSION['table_name'];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];

    // Set timezone to Manila
    date_default_timezone_set('Asia/Manila');

    // Get current date and time in Manila timezone
    $date = date("Y-m-d");
    $time = date("H:i:s");

    // Insert into database
    $sql = "INSERT INTO feedback (name, rate, comment, date, time)
            VALUES ('$name', '$rating', '$comment', '$date', '$time')";

    if ($connection->query($sql) === TRUE) {
        echo "<script>alert('Review submitted successfully');</script>";
        
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }

    // Redirect back to the same page to prevent form resubmission
    header("Location: thankyou.php");
    exit; // Make sure to call exit after the redirect to stop further script execution
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback | University Hills</title>
    <link rel="icon" href="Pic/uhicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.6/css/star-rating.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *{
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #E5E4E2; /* Light gray background */
            font-family: 'Poppins', sans-serif;
        }
        .rating {
            color: #FFD700; /* Gold color for stars */
        }
        .leave-review, .customer-review {
            background-color: #ffffff; /* White background for cards */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            background-color: #fafafa; /* Alternating card background */
        }
        .customer-review:nth-child(even) .card-body {
            background-color: #f7f7f7; /* Alternate card color */
        }
        h2 {
            font-weight: bold; /* Bold for headings */
        }
        .customer-review .card-title {
            font-weight: bold; /* Bold for customer names */
        }
        small {
            font-size: 0.8em; /* Smaller font size for date/time */
            color: rgba(0, 0, 0, 0.6); /* Lighter transparency */
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow leave-review">
        <div class="card-body">
            <h2 class="card-title">Leave a Review!</h2>
            <form id="reviewForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <input type="hidden" id="rating" name="rating" required>
                    <input id="star-rating" class="rating-loading">
                    <span id="rating-value"></span>
                </div>

                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" onclick="return confirmSubmit()">Submit</button>
            </form>
        </div>
    </div>

    <hr>

    <h2>Customer Reviews</h2>
    <div id="reviews">
        <?php
        // Query to fetch reviews
        $sql = "SELECT * FROM feedback ORDER BY date DESC, time DESC"; // Latest comment on top
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            // Set timezone to Manila
            date_default_timezone_set('Asia/Manila');
            while($row = $result->fetch_assoc()) {
                // Convert date to desired format
                $formatted_date = date("F j, Y", strtotime($row["date"]));
                $formatted_time = date("g:i A", strtotime($row["time"]));

                echo "<div class='card mt-3 customer-review'>
                        <div class='card-body'>
                            <h5 class='card-title'>" . $row["name"] . " - " . str_repeat("<i class='fas fa-star text-warning'></i>", $row["rate"]) . " (" . $row["rate"] . ")</h5>
                            <p class='card-text'>" . $row["comment"] . "</p>
                            <small>" . $formatted_date . " at " . $formatted_time . "</small>
                        </div>
                      </div>";
            }
        } else {
            echo "No reviews yet.";
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.6/js/star-rating.min.js"></script>
<script>
$(document).ready(function() {
    $("#star-rating").rating({
        min: 0,
        max: 5,
        step: 0.1,
        stars: 5,
        showClear: false,
        showCaption: false,
        theme: 'krajee-fas',
        filledStar: '<i class="fas fa-star"></i>',
        emptyStar: '<i class="far fa-star"></i>',
    }).on('rating:change', function(event, value, caption) {
        $("#rating").val(value);
        $("#rating-value").text(` (${value})`);
    });
});

function confirmSubmit() {
    return confirm("Are you sure you want to submit?");
}
</script>
</body>
</html>
