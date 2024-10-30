<?php
header('Content-Type: application/json');
include_once "../includes/connection.php";

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Prepare an array to store order data
    $order = array();

    // Query to fetch order details (customer information)
    $sql = "SELECT customer_name, customer_note FROM orders WHERE order_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $order = $result->fetch_assoc();

            // Initialize an array for items with the 'prepare' status
            $order['items'] = [];

            // Query to fetch order items with the 'prepare' status
            $sql_items = "
                SELECT mi.item_name, od.quantity, od.order_item_status 
                FROM order_details od 
                JOIN menu_items mi ON od.menu_item_stock_id = mi.item_id 
                WHERE od.order_id = ? AND od.order_item_status = 'prepare'";

            if ($stmt_items = $conn->prepare($sql_items)) {
                $stmt_items->bind_param("i", $order_id);
                $stmt_items->execute();
                $result_items = $stmt_items->get_result();

                // Temporary array to store item counts by name and status
                $itemCounts = [];

                while ($row = $result_items->fetch_assoc()) {
                    $itemName = $row['item_name'];

                    // If item and status combination already exists, increase quantity
                    if (isset($itemCounts[$itemName])) {
                        $itemCounts[$itemName]['quantity'] += $row['quantity'];
                    } else {
                        // Otherwise, initialize entry for this item and status
                        $itemCounts[$itemName] = [
                            'item_name' => $itemName,
                            'quantity' => $row['quantity'],
                            'order_item_status' => $row['order_item_status']
                        ];
                    }
                }

                // Add grouped items to the order array
                $order['items'] = array_values($itemCounts);
            }
        } else {
            echo json_encode(['error' => 'Order not found']);
            exit;
        }
    } else {
        echo json_encode(['error' => 'Query preparation failed']);
        exit;
    }

    // Return data as JSON
    echo json_encode($order);
} else {
    echo json_encode(['error' => 'Order ID not provided']);
}
?>
