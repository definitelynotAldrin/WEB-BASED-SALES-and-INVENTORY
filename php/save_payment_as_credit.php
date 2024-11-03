<?php
// Include database connection
include_once "../includes/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if cash tendered is provided and not empty
    if (empty($_POST['credit_note'])) {
        echo json_encode(['status' => 'error', 'message' => 'Note is missing or just leave a space by clicking space.']);
        exit;
    }
    
    // Retrieve required POST data
    $orderId = $_POST['order_id'];
    $totalAmount = $_POST['total_amount'];
    $creditNote = $_POST['credit_note'];
    
    // Set default payment status
    $paymentStatus = 'credit';
    $collectiblesStatus = 'Y';
    
    // Insert payment details into the payments table
    $sql = "INSERT INTO payments (order_id, total_amount, payment_status, credit_note, collectibles)
            VALUES (?, ?, ?, ?, ?)";
    
    // Prepare and execute the statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('idsss', $orderId, $totalAmount, $paymentStatus, $creditNote, $collectiblesStatus);
        
        if ($stmt->execute()) {
            // Update the payment_status in the orders table after payment is successful
            $updateSql = "UPDATE orders SET payment_status = 'credit' WHERE order_id = ?";
            if ($updateStmt = $conn->prepare($updateSql)) {
                $updateStmt->bind_param('i', $orderId);
                
                if ($updateStmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Payment saved and order updated.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error updating order status.']);
                }
                
                $updateStmt->close();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to prepare order update query.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error saving payment.']);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed.']);
    }
    
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
