<?php
// Include database connection
include_once "../includes/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'];
    $totalAmount = $_POST['hidden_total_amount'];
    $discountedAmount = isset($_POST['discounted_amount']) ? $_POST['discounted_amount'] : null;
    $cashTendered = $_POST['cash_tendered'];
    $changeDue = $_POST['change_due'];

    // Set default payment status
    $paymentStatus = 'paid';

    // Insert payment details into the payments table
    $sql = "INSERT INTO payments (order_id, total_amount, discounted_amount, cash_tendered, change_due, payment_status)
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare and execute the statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('iddids', $orderId, $totalAmount, $discountedAmount, $cashTendered, $changeDue, $paymentStatus);

        if ($stmt->execute()) {
            // Update the payment_status in the orders table after payment is successful
            $updateSql = "UPDATE orders SET payment_status = 'paid' WHERE order_id = ?";
            if ($updateStmt = $conn->prepare($updateSql)) {
                $updateStmt->bind_param('i', $orderId);
                
                if ($updateStmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Payment saved and order updated.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error updating order status.']);
                }
                
                $updateStmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to prepare order update query.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error saving payment.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Database query failed.']);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
