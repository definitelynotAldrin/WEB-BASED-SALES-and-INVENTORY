<?php
include_once "../includes/connection.php";

if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];

    // Fetch order details from 'orders', 'order_details', and 'payments'
    $sql = "SELECT 
            o.customer_name, 
            o.customer_table,
            o.total_amount, 
            o.payment_status, -- Add this line
            od.quantity, 
            od.sub_total, 
            mi.item_name,
            p.cash_tendered, 
            p.change_due,
            p.credit_note,
            p.total_amount AS payment_total,
            p.discounted_amount
        FROM orders o
        JOIN order_details od ON o.order_id = od.order_id
        JOIN menu_items mi ON od.menu_item_stock_id = mi.item_id
        JOIN payments p ON o.order_id = p.order_id
        WHERE o.order_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $orderDetails = [];
        $firstRow = $result->fetch_assoc();
        
        // Store order data from the first row
        $orderData = [
            'customer_name' => $firstRow['customer_name'],
            'table_number' => $firstRow['customer_table'],
            'total_amount' => $firstRow['total_amount'],
            'payment_status' => $firstRow['payment_status'], // Include payment status
            'cash_tendered' => $firstRow['cash_tendered'],
            'change_due' => $firstRow['change_due'],
            'discounted_amount' => $firstRow['discounted_amount'],
            'credit_note' => $firstRow['credit_note']
        ];

        // Fetch all order details in a loop
        do {
            $orderDetails[] = [
                'item_name' => $firstRow['item_name'],
                'quantity' => $firstRow['quantity'],
                'sub_total' => $firstRow['sub_total']
            ];
        } while ($firstRow = $result->fetch_assoc());

        // Respond with JSON
        echo json_encode([
            'success' => true,
            'customer_name' => $orderData['customer_name'],
            'table_number' => $orderData['table_number'],
            'total_amount' => $orderData['total_amount'],
            'payment_status' => $orderData['payment_status'], // Include payment status
            'cash_tendered' => $orderData['cash_tendered'],
            'change_due' => $orderData['change_due'],
            'discounted_amount' => $orderData['discounted_amount'],
            'credit_note' => $orderData['credit_note'],
            'order_details' => $orderDetails
        ]);      
    } else {
        echo json_encode(['success' => false, 'message' => 'No order found']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
