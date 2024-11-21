<?php
include_once "../includes/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the order_ids array is provided
    if (empty($_POST['order_ids']) || !is_array($_POST['order_ids'])) {
        echo json_encode(['status' => 'error', 'message' => 'No orders selected.']);
        exit;
    }
    
    $orderIds = $_POST['order_ids'];
    $cashTendered = $_POST['cash_tendered'];
    $changeDue = $_POST['change_due'];
    $paymentStatus = $_POST['payment_status'];
    $groupId = $_POST['group_id'];

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Check if the cash tendered is sufficient for the total amount of the selected orders
        $totalAmount = 0;
        $sqlGetTotalAmount = "SELECT SUM(total_amount) AS total_amount FROM orders WHERE order_id IN (" . implode(',', $orderIds) . ")";
        $result = $conn->query($sqlGetTotalAmount);

        if ($result && $row = $result->fetch_assoc()) {
            $totalAmount = $row['total_amount'];
        }

        // If cash tendered is less than total amount, return error
        if ($cashTendered < $totalAmount) {
            echo json_encode(['status' => 'error', 'message' => 'Cash tendered is insufficient for the total amount.']);
            $conn->rollback();
            exit;
        }

        // Update payment records in the payments table for each selected order
        $sqlUpdatePayment = "UPDATE payments SET cash_tendered = ?, change_due = ?, payment_status = ?, paid_as_group = ? WHERE order_id = ?";
        $stmtUpdatePayment = $conn->prepare($sqlUpdatePayment);
        
        foreach ($orderIds as $orderId) {
            $stmtUpdatePayment->bind_param('ddssi', $cashTendered, $changeDue, $paymentStatus, $groupId, $orderId);
            if (!$stmtUpdatePayment->execute()) {
                throw new Exception("Failed to update payment record for order ID: " . $orderId);
            }

            // Update each order's status to "paid" in the orders table
            $updateOrderSql = "UPDATE orders SET payment_status = ? WHERE order_id = ?";
            $stmtUpdateOrder = $conn->prepare($updateOrderSql);
            $stmtUpdateOrder->bind_param('si', $paymentStatus, $orderId);
            if (!$stmtUpdateOrder->execute()) {
                throw new Exception("Failed to update order status for order ID: " . $orderId);
            }
        }

        // Commit transaction
        $conn->commit();

        echo json_encode(['status' => 'success', 'message' => 'Payments updated and orders marked as paid.']);
    } catch (Exception $e) {
        // Roll back transaction if an error occurs
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    } finally {
        // Close statements
        $stmtUpdatePayment->close();
        if (isset($stmtUpdateOrder)) $stmtUpdateOrder->close();
    }
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
