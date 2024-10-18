<?php
header('Content-Type: application/json');
include_once "../includes/connection.php";

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Check if the order exists
    $sql_check_order = "SELECT * FROM orders WHERE order_id = ?";
    $stmt_check_order = $conn->prepare($sql_check_order);
    $stmt_check_order->bind_param("i", $order_id);
    $stmt_check_order->execute();
    $result_check_order = $stmt_check_order->get_result();

    if ($result_check_order->num_rows > 0) {
        // Fetch the items in the order and group by menu_item_stock_id
        $sql_items = "
            SELECT mis.menu_item_id, mis.stock_id, SUM(mis.quantity_required) AS total_quantity_required
FROM menu_item_stocks mis
JOIN menu_items m ON mis.menu_item_id = m.item_id
WHERE m.item_id = ?
GROUP BY mis.menu_item_id, mis.stock_id;
";
        
        $stmt_items = $conn->prepare($sql_items);
        $stmt_items->bind_param("i", $order_id);
        $stmt_items->execute();
        $result_items = $stmt_items->get_result();

        if ($result_items->num_rows > 0) {
            // Create an array to hold the stock updates
            $stock_updates = [];

            // Loop through the order items to adjust stocks
            while ($row = $result_items->fetch_assoc()) {
                $menu_item_stock_id = $row['menu_item_stock_id'];
                $ordered_quantity = $row['total_quantity']; // Use total_quantity from aggregation
                $current_stock = $row['stock'];

                // Increase the stock by the ordered quantity
                $new_stock = $current_stock + $ordered_quantity;

                // Store the new stock for updating later
                $stock_updates[] = [
                    'menu_item_stock_id' => $menu_item_stock_id,
                    'new_stock' => $new_stock,
                ];
            }

            // Update stocks for each item in the order
            foreach ($stock_updates as $update) {
                $sql_update_stock = "UPDATE menu_item_stocks SET stock = ? WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update_stock);
                $stmt_update->bind_param("ii", $update['new_stock'], $update['menu_item_stock_id']);
                $stmt_update->execute();
            }

            // Now delete the order from the order_details and orders tables
            $sql_delete_order_details = "DELETE FROM order_details WHERE order_id = ?";
            $stmt_delete_details = $conn->prepare($sql_delete_order_details);
            $stmt_delete_details->bind_param("i", $order_id);
            $stmt_delete_details->execute();

            $sql_delete_order = "DELETE FROM orders WHERE order_id = ?";
            $stmt_delete_order = $conn->prepare($sql_delete_order);
            $stmt_delete_order->bind_param("i", $order_id);
            $stmt_delete_order->execute();

            // Return success response
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'No items found for this order.']);
        }
    } else {
        echo json_encode(['error' => 'Order not found.']);
    }
} else {
    echo json_encode(['error' => 'Order ID not provided.']);
}
?>
