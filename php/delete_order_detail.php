<?php
session_start();

if (isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);

    if (isset($_SESSION['order_details']) && !empty($_SESSION['order_details'])) {
        foreach ($_SESSION['order_details'] as $key => $order_item) {
            if ($order_item['menu_item_id'] == $order_id) {
                // Rollback stock quantities
                if (isset($order_item['stock_deductions'])) {
                    include_once "../includes/connection.php"; // Include DB connection for rollback

                    foreach ($order_item['stock_deductions'] as $stock_id => $deduction) {
                        $rollback_stmt = $conn->prepare("UPDATE stocks SET stock_quantity = stock_quantity + ? WHERE stock_id = ?");
                        $rollback_stmt->bind_param("di", $deduction, $stock_id);
                        $rollback_stmt->execute();
                    }
                }

                unset($_SESSION['order_details'][$key]); // Remove the item from the session
                echo json_encode(array('status' => 'success', 'message' => 'Item removed and stock restored.'));
                exit; 
            }
        }
    }

    echo json_encode(array('status' => 'error', 'message' => 'Item not found.'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request.'));
}
