<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customers</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .card {
      margin: 10px;
      width: 300px;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>
  <div class="container">
    <?php
      session_start();
      // Connect to the database
      $servername = "localhost";
      $username = "root";
      $password = "";
      $database = "university_hills";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $database);

      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      // SQL query to fetch data from the customers table
      $sql = "SELECT cid, tid, table_number, nickname FROM customer ORDER BY table_number";
      $result = $conn->query($sql);

      $current_table_number = null;
      $current_card = "";

      if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
          if ($row["table_number"] !== $current_table_number) {
            // Start a new section for a new table number
            if ($current_table_number !== null) {
              echo '</div>'; // Close previous section
            }
            $current_table_number = $row["table_number"];
            echo '<div class="row">';
            echo '<div class="col-md-12">';
            echo '</div>';
            // Start a new card for the table number
            echo '<div class="col-md-4">';
            echo '<div class="card">';
            echo '<h5 class="card-title">Table Number: ' . $current_table_number . '</h5>';
            $current_card = $current_table_number;
          }
          // If the current row has the same table number as the current card, add the customer details to the card
          if ($row["table_number"] == $current_card) {
            echo '<p class="card-text">Customer ID: ' . $row["cid"] . '</p>';
            echo '<p class="card-text">Nickname: ' . $row["nickname"] . '</p>';
          }
        }
        echo '</div>'; // Close the last card
        echo '</div>'; // Close the last section
      } else {
        echo "0 results";
      }
      $conn->close();
    ?>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
