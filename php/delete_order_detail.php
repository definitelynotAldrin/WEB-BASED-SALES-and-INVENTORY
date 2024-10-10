<?php
session_start();

// Check if order ID is provided
if (isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);

    // Loop through the order details to find and remove the item
    if (isset($_SESSION['order_details']) && !empty($_SESSION['order_details'])) {
        foreach ($_SESSION['order_details'] as $key => $order_item) {
            if ($order_item['menu_item_id'] == $order_id) {
                unset($_SESSION['order_details'][$key]); // Remove the item from the session array
                echo json_encode(array('status' => 'success', 'message' => 'Item removed from order summary.'));
                exit; // Exit after successful deletion
            }
        }
    }

    // If item was not found
    echo json_encode(array('status' => 'error', 'message' => 'Item not found.'));
} else {
    // Handle case when order ID is not provided
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request.'));
}
?>
