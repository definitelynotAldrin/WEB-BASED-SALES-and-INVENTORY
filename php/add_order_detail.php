<?php
session_start(); // Start session

// Check if required POST data is received
if (isset($_POST['menu_id']) && isset($_POST['quantity']) && isset($_POST['menu_price']) && isset($_POST['menu_category'])) {
    // Sanitize input values
    $menu_id = intval($_POST['menu_id']);
    $menu_name = $_POST['menu_name'];
    $quantity = floatval($_POST['quantity']);
    $menu_price = floatval($_POST['menu_price']);
    $menu_category = $_POST['menu_category'];
    $sub_total = $quantity * $menu_price;

    // Check if the category is 'Beverage' or 'Dessert' and ensure quantity is an integer
    if (($menu_category === 'Beverage' || $menu_category === 'Dessert') && floor($quantity) != $quantity) {
        echo json_encode(array('status' => 'error', 'message' => 'Quantity for beverages and desserts must be a whole number.'));
        exit; // Stop further processing
    }

    // Create an array for the order details if it doesn't exist
    if (!isset($_SESSION['order_details'])) {
        $_SESSION['order_details'] = array();
    }

    // Initialize a flag to check if the item exists
    $item_exists = false;

    // Loop through the order details to check if the item already exists
    foreach ($_SESSION['order_details'] as &$order_item) {
        if ($order_item['menu_item_id'] == $menu_id) {
            // If the item exists, update the quantity and subtotal
            $order_item['quantity'] += $quantity;
            $order_item['sub_total'] = $order_item['quantity'] * $menu_price;
            $item_exists = true; // Mark as found
            break;
        }
    }

    // If the item doesn't exist, add it as a new item in the session
    if (!$item_exists) {
        $_SESSION['order_details'][] = array(
            'menu_item_id' => $menu_id,
            'menu_name' => $menu_name,
            'quantity' => $quantity,
            'menu_price' => $menu_price,
            'sub_total' => $sub_total
        );
    }

    // Return success response
    echo json_encode(array('status' => 'success', 'message' => 'Item added/updated in order summary.'));
} else {
    // Handle error when required data is missing
    echo json_encode(array('status' => 'error', 'message' => 'Invalid data. Please try again.'));
}
?>
