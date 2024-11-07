                
<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "university_hills";

    //Create Connection
    $connection = mysqli_connect($servername, $username, $password, $database);

    // Create Connection
    $connection = mysqli_connect($servername, $username, $password, $database);

    // Check connection
    if($connection->connect_error){
        die("Connection failed: " . $connection->connect_error);
    }

        // Query the data from the tables
    $sql = "SELECT tid, table_number, verification_code FROM tables";
    $result = $connection->query($sql);
?>  
                
                
                
                
                
 
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark text-center"> 
                    <tr>
                        <th scope="col">Table Number</th>
                        <th scope="col">Verification Code</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center fw-bold ">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="<?php echo $row['tid'] % 2 == 0 ? 'bg-light' : 'bg-white'; ?>">
                                <td><?php echo $row["table_number"]; ?></td>
                                <td id="verification-<?php echo $row["table_number"]; ?>">
                                    <?php echo $row["verification_code"]; ?>
                                </td>
                                <td>
                                    <button class="btn btn-success" onclick="generateCode('<?php echo $row['tid']; ?>', '<?php echo $row['table_number']; ?>', this)">Change</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No Data Available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

   <script>
    function generateCode(tid, tableNumber, button) { 
        var verificationElement = $('#verification-' + tableNumber);
        
        $.ajax({
            url: 'generate-code.php', // Point to your new PHP file
            type: 'POST',
            data: {
                tid: tid
            },
            success: function(response) {
                // Assuming the response is the new verification code
                verificationElement.text(response);
                alert('change verificaiton code of table ' + tableNumber);
            },
            error: function(xhr, status, error) {
                console.error(xhr);
                alert('Error generating code. Please try again.');
            }
        });
    }
    </script>
