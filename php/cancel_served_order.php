<?php
header('Content-Type: application/json');
include_once "../includes/connection.php";

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Begin a transaction to ensure both updates happen together
    $conn->begin_transaction();

    try {
        // Update the order status to 'process' in the orders table
        $sql_update_order = "UPDATE orders SET order_status = 'process' WHERE order_id = ?";
        $stmt_update_order = $conn->prepare($sql_update_order);
        $stmt_update_order->bind_param("i", $order_id);
        $stmt_update_order->execute();

        // Check if the update was successful
        if ($stmt_update_order->affected_rows > 0) {
            // Update the order_item_status to 'process' in the order_details table
            $sql_update_order_details = "UPDATE order_details SET order_item_status = 'process' WHERE order_item_status = 'served' AND order_id = ?";
            $stmt_update_order_details = $conn->prepare($sql_update_order_details);
            $stmt_update_order_details->bind_param("i", $order_id);
            $stmt_update_order_details->execute();

            // If both updates are successful, commit the transaction
            $conn->commit();

            // Return success response
            echo json_encode(['success' => true]);
        } else {
            throw new Exception('Order update failed');
        }
    } catch (Exception $e) {
        // Roll back the transaction in case of error
        $conn->rollback();

        // Return error response
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Order ID not provided']);
}
?>
