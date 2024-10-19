<?php
session_start();

include_once "../includes/connection.php"; // Database connection

if (isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);
    
    // Step 1: Retrieve the order items and associated stocks for the given order ID
    $stmt = $conn->prepare("
        SELECT oi.menu_item_id, oi.quantity, ms.stock_id, ms.quantity_required
        FROM order_items oi
        JOIN menu_item_stocks ms ON oi.menu_item_id = ms.menu_item_id
        WHERE oi.order_id = ?
    ");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $order_items = $result->fetch_all(MYSQLI_ASSOC);

    if (empty($order_items)) {
        echo json_encode(array('status' => 'error', 'message' => 'Order not found.'));
        exit;
    }

    // Step 2: Begin a transaction to ensure everything happens atomically
    $conn->begin_transaction();

    try {
        // Step 3: Loop through the order items and restore the corresponding stock quantities
        foreach ($order_items as $item) {
            $stock_id = $item['stock_id'];
            $quantity_to_restore = $item['quantity'] * $item['quantity_required'];  // Total stock to restore

            // Update stock quantity in the stocks table
            $update_stock_stmt = $conn->prepare("UPDATE stocks SET stock_quantity = stock_quantity + ? WHERE stock_id = ?");
            $update_stock_stmt->bind_param("di", $quantity_to_restore, $stock_id);
            $update_stock_stmt->execute();
        }

        // // Step 4: Mark the order as canceled in the orders table
        // $update_order_stmt = $conn->prepare("UPDATE orders SET order_status = 'canceled' WHERE order_id = ?");
        // $update_order_stmt->bind_param("i", $order_id);
        // $update_order_stmt->execute();

        // // Step 5: Commit the transaction
        // $conn->commit();

        echo json_encode(array('status' => 'success', 'message' => 'Order canceled and stock restored.'));
    } catch (Exception $e) {
        // Step 6: If something goes wrong, roll back the transaction
        $conn->rollback();
        echo json_encode(array('status' => 'error', 'message' => 'Failed to cancel order: ' . $e->getMessage()));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request.'));
}
