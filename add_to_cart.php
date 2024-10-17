<?php
// Start the session
session_start();

// Check if the product ID and quantity are set
if(isset($_POST['pid']) && isset($_POST['quantity'])) {
    // Retrieve the product ID and quantity
    $pid = $_POST['pid'];
    $quantity = $_POST['quantity'];

    // Check if the product ID is valid
    if(is_numeric($pid) && $pid > 0 && is_numeric($quantity) && $quantity > 0) {
        // Check if the product already exists in the cart
        if(isset($_SESSION['cart'][$pid])) {
            // Update the quantity of the existing product
            $_SESSION['cart'][$pid]['quantity'] += $quantity;
        } else {
            // Add the product to the cart session variable
            $_SESSION['cart'][$pid] = array('pid' => $pid, 'quantity' => $quantity);
        }
        
        // Redirect back to the previous page or to a specific page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Invalid product ID or quantity, redirect back to the previous page with an error message
        $_SESSION['error_message'] = "Invalid product ID or quantity.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    // Product ID or quantity not set, redirect back to the previous page with an error message
    $_SESSION['error_message'] = "Product ID or quantity not set.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
