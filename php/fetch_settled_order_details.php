<?php
include_once "../includes/connection.php";

if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];

    // Fetch order details from 'orders' and 'order_details'
    $sql = "SELECT 
                o.customer_name, 
                o.customer_table,
                o.total_amount, 
                od.quantity, 
                od.sub_total, 
                mi.item_name
            FROM orders o
            JOIN order_details od ON o.order_id = od.order_id
            JOIN menu_items mi ON od.menu_item_stock_id = mi.item_id
            WHERE o.order_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $orderDetails = [];
        $firstRow = $result->fetch_assoc();
        
        $orderData = [
            'customer_name' => $firstRow['customer_name'],
            'table_number' => $firstRow['customer_table'],
            'total_amount' => $firstRow['total_amount'],
        ];

        // Fetch all order details
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
?>
