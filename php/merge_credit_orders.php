<?php
include_once "../includes/connection.php";
date_default_timezone_set('Asia/Manila');

if (isset($_POST['order_ids']) && is_array($_POST['order_ids'])) {
    $orderIds = $_POST['order_ids'];

    // Prepare SQL to get details of selected orders
    $placeholders = implode(',', array_fill(0, count($orderIds), '?'));
    $sql = "SELECT o.customer_name, o.order_date, o.order_time, o.customer_note, od.quantity, 
                   od.sub_total, od.order_item_status, mi.item_name 
            FROM orders o
            JOIN order_details od ON o.order_id = od.order_id
            JOIN menu_items mi ON od.menu_item_stock_id = mi.item_id
            WHERE o.order_id IN ($placeholders) AND o.payment_status = 'credit'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat('i', count($orderIds)), ...$orderIds);
    $stmt->execute();
    $result = $stmt->get_result();

    $mergedDetails = [];
    $totalAmount = 0;
    $customerNotes = []; // Array to collect customer notes

    $firstRow = $result->fetch_assoc();
    
    // Store static order data
    $orderData = [
        'customer_name' => $firstRow['customer_name'],
        'order_date' => $firstRow['order_date'],
        'order_time' => date('h:i A', strtotime($firstRow['order_time'])),
        'payment_status' => 'credit'
    ];

    do {
        // Collect customer notes if not empty
        if (!empty($firstRow['customer_note'])) {
            $customerNotes[] = $firstRow['customer_note'];
        }

        $itemKey = $firstRow['item_name'] . '_' . $firstRow['order_item_status'];
        if (!isset($mergedDetails[$itemKey])) {
            $mergedDetails[$itemKey] = [
                'item_name' => $firstRow['item_name'],
                'quantity' => $firstRow['quantity'],
                'sub_total' => $firstRow['sub_total'],
                'order_item_status' => $firstRow['order_item_status']
            ];
        } else {
            $mergedDetails[$itemKey]['quantity'] += $firstRow['quantity'];
            $mergedDetails[$itemKey]['sub_total'] += $firstRow['sub_total'];
        }
        $totalAmount += $firstRow['sub_total'];
    } while ($firstRow = $result->fetch_assoc());

    // Merge customer notes into a single string, separated by commas or newlines if preferred
    $mergedCustomerNote = implode("\n", $customerNotes);

    // Prepare response with merged data
    echo json_encode([
        'success' => true,
        'customer_name' => $orderData['customer_name'],
        'order_date' => $orderData['order_date'],
        'order_time' => $orderData['order_time'],
        'customer_note' => $mergedCustomerNote,
        'total_amount' => $totalAmount,
        'payment_status' => $orderData['payment_status'],
        'order_details' => array_values($mergedDetails)
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'No orders selected for merging.']);
}

$conn->close();
?>
