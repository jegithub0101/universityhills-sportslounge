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
    <title>Payment Receipt</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Hide print button in the printed version */
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Payment Details</h1>
        <?php
        // Database connection and data fetching
        $result = $connection->query("SELECT payment_trackingno, totalprice, total_user, total_valid, date, time FROM overall_payment ORDER BY payment_trackingno ASC");

        // Displaying the payment data
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card mb-3'>";
                echo "<div class='card-body'>";
                echo "<p>Tracking No: " . htmlspecialchars($row['payment_trackingno']) . "</p>";
                echo "<p>Total Price: $" . htmlspecialchars($row['totalprice']) . "</p>";
                echo "<p>Total User: " . htmlspecialchars($row['total_user']) . "</p>";
                echo "<p>Total Valid: " . htmlspecialchars($row['total_valid']) . "</p>";
                echo "<p>Date: " . htmlspecialchars($row['date']) . "</p>";
                echo "<p>Time: " . htmlspecialchars($row['time']) . "</p>";
                echo "<button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#receiptModal' 
                        data-trackingno='" . htmlspecialchars($row['payment_trackingno']) . "' 
                        data-totalprice='" . htmlspecialchars($row['totalprice']) . "' 
                        data-totaluser='" . htmlspecialchars($row['total_user']) . "' 
                        data-totalvalid='" . htmlspecialchars($row['total_valid']) . "' 
                        data-date='" . htmlspecialchars($row['date']) . "' 
                        data-time='" . htmlspecialchars($row['time']) . "'>Done</button>";
                echo "</div></div>";
            }
        } else {
            echo "<p>No payment records found.</p>";
        }
        $connection->close();
        ?>

        <!-- Modal for Receipt -->
        <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="receiptModalLabel">Receipt</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="receiptContent">
                            <p><strong>Tracking No:</strong> <span id="modal-trackingno"></span></p>
                            <p><strong>Total Price:</strong> $<span id="modal-totalprice"></span></p>
                            <p><strong>Total User:</strong> <span id="modal-totaluser"></span></p>
                            <p><strong>Total Valid:</strong> <span id="modal-totalvalid"></span></p>
                            <p><strong>Date:</strong> <span id="modal-date"></span></p>
                            <p><strong>Time:</strong> <span id="modal-time"></span></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary no-print" id="printReceipt">Print Receipt</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // jQuery to handle modal data population
        $('#receiptModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var trackingno = button.data('trackingno');
            var totalprice = button.data('totalprice');
            var totaluser = button.data('totaluser');
            var totalvalid = button.data('totalvalid');
            var date = button.data('date');
            var time = button.data('time');

            // Update the modal's content.
            var modal = $(this);
            modal.find('#modal-trackingno').text(trackingno);
            modal.find('#modal-totalprice').text(totalprice);
            modal.find('#modal-totaluser').text(totaluser);
            modal.find('#modal-totalvalid').text(totalvalid);
            modal.find('#modal-date').text(date);
            modal.find('#modal-time').text(time);
        });

        // Function to print the receipt
        $('#printReceipt').on('click', function () {
            var printContent = document.getElementById('receiptContent').innerHTML;
            var originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent; // Set body to receipt content
            window.print(); // Open print dialog
            document.body.innerHTML = originalContent; // Restore original content
            location.reload(); // Reload to rebind events
        });
    </script>
</body>
</html>
