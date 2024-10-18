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

            // Query to fetch order items with the status 'prepare'
            $sql_items = "
                SELECT mi.item_name, od.quantity 
                FROM order_details od 
                JOIN menu_items mi ON od.menu_item_stock_id = mi.item_id 
                WHERE od.order_id = ? AND od.order_item_status = 'process'";
                
            if ($stmt_items = $conn->prepare($sql_items)) {
                $stmt_items->bind_param("i", $order_id);
                $stmt_items->execute();
                $result_items = $stmt_items->get_result();

                $items = array();
                while ($row = $result_items->fetch_assoc()) {
                    $items[] = $row;
                }

                // Add items to the order array
                $order['items'] = $items;
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
