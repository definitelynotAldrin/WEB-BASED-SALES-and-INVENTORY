<?php
include_once "../includes/connection.php";

if (isset($_GET['order_id'])) {
    $orderID = $_GET['order_id'];

    // Updated SQL query to group items by item_name and order_item_status
    $sql = "SELECT 
        o.customer_name, 
        o.order_date, 
        o.order_time, 
        o.customer_note, 
        o.total_amount, 
        o.order_status, 
        SUM(od.quantity) AS quantity,  -- Sum quantity for grouped items
        SUM(od.sub_total) AS sub_total,  -- Sum sub_total for grouped items
        od.order_item_status, 
        mi.item_name 
    FROM 
        orders o 
    JOIN 
        order_details od ON o.order_id = od.order_id 
    JOIN 
        menu_items mi ON od.menu_item_stock_id = mi.item_id 
    WHERE 
        o.order_id = ?
    GROUP BY 
        mi.item_name, od.order_item_status";  // Group by item name and order item status

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the first row for static order details
        $firstRow = $result->fetch_assoc();

        // Convert order_time to 12-hour format with AM/PM
        $formattedTime = date('h:i A', strtotime($firstRow['order_time']));

        // Store static order data once (only from the first row)
        $orderData = [
            'customer_name' => $firstRow['customer_name'],
            'order_date' => $firstRow['order_date'],
            'order_time' => $formattedTime,  // Use formatted time here
            'customer_note' => $firstRow['customer_note'],
            'total_amount' => $firstRow['total_amount'],
            'order_status' => $firstRow['order_status']
        ];

        // Store all grouped order details in an array
        $orderDetails = [];

        // Loop through all grouped order details and store in the array
        do {
            $orderDetails[] = [
                'item_name' => $firstRow['item_name'],  // From menu_items table
                'quantity' => $firstRow['quantity'],
                'sub_total' => $firstRow['sub_total'],
                'order_item_status' => $firstRow['order_item_status']
            ];
        } while ($firstRow = $result->fetch_assoc());

        // Send response back to the frontend
        echo json_encode([
            'success' => true,
            'customer_name' => $orderData['customer_name'],
            'order_date' => $orderData['order_date'],
            'order_time' => $orderData['order_time'],  // Send the formatted time
            'customer_note' => $orderData['customer_note'],
            'total_amount' => $orderData['total_amount'],
            'order_status' => $orderData['order_status'],
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
