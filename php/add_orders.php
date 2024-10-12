<?php
session_start();

header('Content-Type: application/json');
include_once "../includes/connection.php"; // Ensure your connection.php is correctly configured

// Check if POST data is received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if customer info is provided and not empty
    if (!empty($_POST['customer_name']) && isset($_POST['customer_note']) && !empty($_POST['customer_table'])) {
        $customerName = $_POST['customer_name'];
        $customerNote = $_POST['customer_note'];
        $customerTable = $_POST['customer_table'];
        
        // Check if order details exist in the session
        if (isset($_SESSION['order_details']) && !empty($_SESSION['order_details'])) {
            $totalAmount = 0;

            // Calculate total amount
            foreach ($_SESSION['order_details'] as $order) {
                $totalAmount += $order['sub_total'];
            }

            // Insert order into orders table
            $sql = "INSERT INTO orders (customer_name, customer_note, customer_table, total_amount, order_status, table_status) VALUES (?, ?, ?, ?, 'prepare', 1)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssd", $customerName, $customerNote, $customerTable, $totalAmount);
            $stmt->execute();

            // Get the last inserted order ID
            $orderId = $conn->insert_id;

            // Insert order details into order_details table
            foreach ($_SESSION['order_details'] as $order) {
                $menuItemId = $order['menu_item_id'];
                $quantity = $order['quantity'];
                $menuPrice = $order['menu_price'];
                $subTotal = $order['sub_total'];

                $detailSql = "INSERT INTO order_details (order_id, menu_item_stock_id, quantity, menu_price, sub_total) VALUES (?, ?, ?, ?, ?)";
                $detailStmt = $conn->prepare($detailSql);
                $detailStmt->bind_param("iidds", $orderId, $menuItemId, $quantity, $menuPrice, $subTotal);
                $detailStmt->execute();

                // After inserting order details, fetch required stocks and deduct quantity from stocks
                $menuStockSql = "SELECT stock_id, quantity_required FROM menu_item_stocks WHERE menu_item_id = ?";
                $menuStockStmt = $conn->prepare($menuStockSql);
                $menuStockStmt->bind_param("i", $menuItemId);
                $menuStockStmt->execute();
                $menuStockResult = $menuStockStmt->get_result();

                while ($menuStockRow = $menuStockResult->fetch_assoc()) {
                    $stockId = $menuStockRow['stock_id'];
                    $quantityRequired = $menuStockRow['quantity_required'];

                    // Calculate total quantity needed (menu quantity * quantity_required)
                    $totalQuantityRequired = $quantity * $quantityRequired;

                    // Deduct stock quantity from stocks table
                    $updateStockSql = "UPDATE stocks SET stock_quantity = stock_quantity - ? WHERE stock_id = ?";
                    $updateStockStmt = $conn->prepare($updateStockSql);
                    $updateStockStmt->bind_param("di", $totalQuantityRequired, $stockId);
                    $updateStockStmt->execute();
                }
            }

            // Clear the session order details after successful insertion
            unset($_SESSION['order_details']);

            // Return success response
            echo json_encode(['status' => 'success', 'message' => 'Order placed successfully.']);
        } else {
            // No order details in session
            echo json_encode(['status' => 'error', 'message' => 'No items in the order.']);
        }
    } else {
        // Missing or empty customer info
        echo json_encode(['status' => 'error', 'message' => 'Customer information is missing or empty.']);
    }
} else {
    // Not a POST request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
