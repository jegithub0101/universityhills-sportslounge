<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "university_hills";

//Create Connection
$connection = mysqli_connect($servername, $username, $password, $database);

if($connection->connect_error){
    die("Connection failed: " . $connection->connect_error);
}


function didbillout()
{
    return isset($_SESSION['billout'] );
}

// Redirect to login page if not logged in
if (!didbillout()) {
    header("Location: client-login.php");
    exit;
}

$_SESSION['visited'] = true;



// Set the session expiration time to 3 minutes (180 seconds)
$session_expiration = 20; // 3 minutes

// Check if the session variable for last activity time is set
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_expiration)) {
    // If the session has expired, destroy the session
    session_unset();
    session_destroy();
}

// Update the last activity time
$_SESSION['last_activity'] = time();


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
<style>
    .rating {
        color: yellow;
    }

    .leave-review {
        background-color: lightgray;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .customer-review {
        background-color: beige;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

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
                    <textarea class="form-control" id="comment" name="comment" rows="3" ></textarea>
                </div>
                <button type="submit" class="btn btn-primary" onclick="return confirmSubmit()">Submit</button>

            </form>
        </div>
    </div>
    <hr>
    <h2>Customer Reviews</h2>
    <div id="reviews">
        <?php

        
        //check connection
        if($connection->connect_error){
            die("Connection failed: " . $connection->connect_error);
        }
        // Query to fetch reviews
        $sql = "SELECT * FROM feedback";

        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
           // Set timezone to Manila
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
       




        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $name = $_SESSION['table_name'];
            $rating = $_POST["rating"];
            $comment = $_POST["comment"];

            // Set timezone to Manila
            date_default_timezone_set('Asia/Manila');

            // Get current date and time in Manila timezone
            $date = date("Y-m-d"); // Use the correct format for MySQL date
            $time = date("H:i:s"); // Use the correct format for MySQL time

            // Insert into database
            $connection = mysqli_connect($servername, $username, $password, $database);
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            $sql = "INSERT INTO feedback (name, rate, comment, date, time)
            VALUES ('$name', '$rating', '$comment', '$date', '$time')";

            if ($connection->query($sql) === TRUE) {
                echo "<script>alert('Review submitted successfully');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }

             // Redirect back to the same page
        header("Location: client-comment.php");
        exit;
        }
        ?>

<script>
    function capitalizeWords(input) {
        let words = input.value.split(' ');
        for (let i = 0; i < words.length; i++) {
            words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
        }
        input.value = words.join(' ');
    }


    function confirmSubmit() {
        return confirm("Are you sure you want to submit?");
    }
</script>

        
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
        step: 0.1, // Allow decimal ratings
        stars: 5,
        displayOnly: false,
        showClear: false,
        showCaption: false,
        theme: 'krajee-fas',
        filledStar: '<i class="fas fa-star"></i>',
        emptyStar: '<i class="far fa-star"></i>',
        clearButtonTitle: 'Clear',
        clearCaption: 'Clear',
        starCaptions: function (rating) {
            return '';
        },
        starCaptionClasses: function (rating) {
            return '';
        }
    }).on('rating:change', function(event, value, caption) {
        $("#rating").val(value);
        $("#rating-value").text(` (${value})`);
    });
});

function displayReviews() {
    let html = "";
    reviews.forEach(review => {
        let ratingStars = "";
        for (let i = 1; i <= 5; i++) {
            if (i <= review.rating) {
                ratingStars += '<i class="fas fa-star"></i>';
            } else {
                ratingStars += '<i class="far fa-star"></i>';
            }
        }
        let date = new Date(review.date);
        let formattedDate = new Intl.DateTimeFormat('en-US', {
            timeZone: 'Asia/Manila',
            month: 'long',
            day: 'numeric',
            year: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            hour12: true
        }).format(date);
        html += `<div class="card shadow mt-3">
                    <div class="card-body">
                        <h5 class="card-title">${review.name} - ${ratingStars} (${review.rating})</h5>
                        <p class="card-text">${review.comment}</p>
                        <small>${formattedDate}</small>
                    </div>
                </div>`;
    });
    $("#reviews").html(html);
}

// Display initial reviews
displayReviews();

// Submit form
$("#reviewForm").submit(function(e) {
    e.preventDefault();
    let formData = $(this).serializeArray();
    let review = {
        name: formData[0].value,
        rating: formData[1].value,
        comment: formData[2].value,
        date: new Date().toISOString().slice(0, 10)
    };
    reviews.push(review);
    displayReviews();
    if (confirmSubmit()) {
        // Redirect to thankyou.html after 2 seconds
        setTimeout(function() {
            window.location.href = "thankyou.html";
        }, 2000);
    }
    $(this).trigger("reset");
    $("#star-rating").rating('reset');
    $("#rating-value").text('');
});



</script>
</body>
</html>



