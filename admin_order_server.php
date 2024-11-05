<?php
session_start();

// Database configuration
$config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'university_hills'
];

// Create connection using try-catch for better error handling
try {
    $connection = new mysqli($config['host'], $config['username'], $config['password'], $config['database']);
    if ($connection->connect_error) {
        throw new Exception("Connection failed: " . $connection->connect_error);
    }
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

// Function to fetch order details
function getOrderDetails($connection, $cid, $tracking) {
    $sql = "SELECT * FROM admin_order WHERE cid = ? AND tracking_no = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("is", $cid, $tracking);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to fetch order instructions
function getOrderInstructions($connection, $tracking) {
    $sql = "SELECT instruction FROM product_instruction WHERE tracking_no = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $tracking);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to get order status counts
function getOrderStatusCounts($connection, $cid, $tracking) {
    $counts = [];
    
    // Get total orders
    $sql = "SELECT COUNT(*) as count FROM admin_order WHERE cid = ? AND tracking_no = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("is", $cid, $tracking);
    $stmt->execute();
    $counts['total'] = $stmt->get_result()->fetch_assoc()['count'];
    
    // Get cancelled orders
    $sql = "SELECT COUNT(*) as count FROM admin_order WHERE cid = ? AND tracking_no = ? AND status = 'Cancelled'";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("is", $cid, $tracking);
    $stmt->execute();
    $counts['cancelled'] = $stmt->get_result()->fetch_assoc()['count'];
    
    // Get preparing orders
    $sql = "SELECT COUNT(*) as count FROM admin_order WHERE cid = ? AND tracking_no = ? AND status = 'Preparing'";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("is", $cid, $tracking);
    $stmt->execute();
    $counts['preparing'] = $stmt->get_result()->fetch_assoc()['count'];
    
    return $counts;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --success-color: #22c55e;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --background-light: #f3f4f6;
            --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            background-color: var(--background-light);
            color: var(--text-dark);
            line-height: 1.5;
        }

        .orders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            padding: 1.5rem;
            max-width: 1600px;
            margin: 0 auto;
        }

        .order-card {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease;
        }

        .order-card:hover {
            transform: translateY(-2px);
        }

        .order-header {
            background-color:#12171e;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-number {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: opacity 0.2s ease;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-accept {
            background: var(--success-color);
            color: white;
        }

        .btn-delete {
            background: var(--danger-color);
            color: white;
        }

        .order-content {
            padding: 1rem;
        }

        .order-items {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .items-header {
            background: #f8fafc;
            padding: 0.75rem 1rem;
            font-weight: 600;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
        }

        .item-row {
            padding: 0.75rem 1rem;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
            border-top: 1px solid #e5e7eb;
        }

        .instructions {
            margin-top: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 0.5rem;
        }

        .instructions-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .btn-done {
            width: 100%;
            margin-top: 1rem;
            padding: 0.75rem;
            background-color: #22c55e;
            color: white;
            border-radius: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
        }
        .btn-done:hover{
            background-color: #92E2B0;
        }

        .btn-done:disabled {
            background: var(--text-light);
            cursor: not-allowed;
        }

        .hide {
            display: none;
        }

        @media (max-width: 640px) {
            .orders-grid {
                grid-template-columns: 1fr;
                padding: 1rem;
            }
        }

        


    </style>
</head>
<body>
<div class="orders-grid">
        <?php
        // Fetch active orders
        $sql = "SELECT DISTINCT table_number, tracking_no, cid FROM admin_order WHERE status NOT IN ('Done', 'Request', 'Cancelled')";
        $result = $connection->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cid = $row["cid"];
                $tracking = $row['tracking_no'];
                $table_num = $row['table_number'];

                // Get order status counts
                $counts = getOrderStatusCounts($connection, $cid, $tracking);

                // Skip if all orders are cancelled
                if ($counts['total'] === $counts['cancelled']) {
                    continue;
                }

                // Determine if buttons should be hidden or disabled
                $hideButtons = $counts['preparing'] === $counts['total'] ? "hide" : "";
                $disableCompleteButton = $counts['preparing'] > 0 ? "" : "disabled";  // Disable the complete button if not preparing
                ?>
                <div class="order-card">
                    <div class="order-header">
                        <span class="table-number">Table <?php echo htmlspecialchars($table_num); ?></span>
                        <div class="action-buttons">
                            <button class="btn btn-accept <?php echo $hideButtons; ?>" 
                                    onclick="confirmAccept('<?php echo $cid; ?>', '<?php echo $tracking; ?>', this)">
                                <i class="fas fa-check"></i> Accept
                            </button>
                            <button class="btn btn-delete <?php echo $hideButtons; ?>" 
                                    onclick="confirmDelete('<?php echo $cid; ?>', '<?php echo $tracking; ?>', this)">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </div>
                    </div>

                    <div class="order-content">
                        <div class="order-items">
                            <div class="items-header">
                                <span>Item</span>
                                <span>Qty</span>
                            </div>
                            <?php
                            $orderDetails = getOrderDetails($connection, $cid, $tracking);
                            while ($item = $orderDetails->fetch_assoc()) {
                                ?>
                                <div class="item-row">
                                    <span><?php echo htmlspecialchars($item['product_name']); ?></span>
                                    <span><?php echo htmlspecialchars($item['quantity']); ?></span>
                                </div>
                                <?php
                            }
                            ?>
                        </div>

                        <?php
                        $instructions = getOrderInstructions($connection, $tracking);
                        if ($instructions && $instructions->num_rows > 0) {
                            ?>
                            <div class="instructions">
                                <div class="instructions-title">Special Instructions</div>
                                <?php
                                while ($instruction = $instructions->fetch_assoc()) {
                                    echo htmlspecialchars($instruction['instruction']);
                                }
                                ?>
                            </div>
                        <?php } ?>
                    </div>

                    <button class="btn btn-done" 
                            data-accepted="false" 
                            <?php echo $disableCompleteButton; ?> 
                            onclick="confirmDone('<?php echo $cid; ?>', '<?php echo $tracking; ?>', this)">
                        Complete Order
                    </button>
                </div>
                <?php
            }
        } else {
            echo "<p class='emptyword'></p>";
            echo " <img class='emptypic' src='Pic/emptyorder.svg' alt=''>";
        }
        ?>
    </div>
</div>

<script>
    function confirmAccept(cid, tracking, button) {
        if (confirm('Accept this order?')) {
            // Perform the necessary actions (like updating the database)
            console.log('Order accepted:', cid, tracking);

            // Find the closest order card to enable the 'Complete Order' button
            const card = button.closest('.order-card');
            const completeButton = card.querySelector('.btn-done');
            
            // Enable the 'Complete Order' button and remove the disabled attribute
            completeButton.disabled = false;
            completeButton.removeAttribute('disabled');
            completeButton.setAttribute('data-accepted', 'true');

            // Optional: Check if it's visually updating in the console
            console.log('Complete button enabled:', completeButton);
        }
    }


    function confirmDelete(cid, tracking, button) {
        if (confirm('Reject this order?')) {
            // Add your reject order logic here
            console.log('Order rejected:', cid, tracking);
        }
    }

    function confirmDone(cid, tracking, button) {
        const accepted = button.getAttribute('data-accepted');
        if (accepted === 'true' && confirm('Mark order as complete?')) {
            // Add your complete order logic here
            console.log('Order completed:', cid, tracking);
        }
    }
</script>
</body>
</html>