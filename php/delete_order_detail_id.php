<?php
// Include database connection
include_once "../includes/connection.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required IDs are provided
    if (isset($_POST['order_detail_id']) && isset($_POST['order_id'])) {
        $orderDetailId = $_POST['order_detail_id'];
        $orderId = $_POST['order_id'];
        
        // Step 1: Check the count of order details for the given order_id
        $sqlCountDetails = "SELECT COUNT(*) FROM order_details WHERE order_id = ?";
        $stmt = $conn->prepare($sqlCountDetails);
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $stmt->bind_result($detailCount);
        $stmt->fetch();
        $stmt->close();
        
        // If there's only one order detail, forbid deletion
        if ($detailCount <= 1) {
            echo json_encode(['success' => false, 'message' => 'Cannot delete the last item in the order.']);
            exit;
        }

        // Start a transaction to ensure data integrity
        $conn->begin_transaction();
        
        try {
            // Step 2: Get the subtotal of the order detail to be deleted
            $sqlGetSubtotal = "SELECT sub_total FROM order_details WHERE order_detail_id = ?";
            $stmt = $conn->prepare($sqlGetSubtotal);
            $stmt->bind_param('i', $orderDetailId);
            $stmt->execute();
            $stmt->bind_result($subTotal);
            $stmt->fetch();
            $stmt->close();
            
            // Check if subtotal was retrieved
            if (!isset($subTotal)) {
                throw new Exception("Order detail not found.");
            }
            
            // Step 3: Deduct the subtotal from the total amount in the orders table
            $sqlUpdateOrder = "UPDATE orders SET total_amount = total_amount - ? WHERE order_id = ?";
            $stmt = $conn->prepare($sqlUpdateOrder);
            $stmt->bind_param('di', $subTotal, $orderId);
            $stmt->execute();
            
            if ($stmt->affected_rows <= 0) {
                throw new Exception("Failed to update order total.");
            }
            $stmt->close();

            // Step 4: Delete the order detail
            $sqlDeleteDetail = "DELETE FROM order_details WHERE order_detail_id = ?";
            $stmt = $conn->prepare($sqlDeleteDetail);
            $stmt->bind_param('i', $orderDetailId);
            $stmt->execute();

            if ($stmt->affected_rows <= 0) {
                throw new Exception("Failed to delete order detail.");
            }
            $stmt->close();
            
            // Commit the transaction
            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'Order detail deleted and order total updated.']);
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Required order ID or order detail ID missing.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

// Close the database connection
$conn->close();
?>
