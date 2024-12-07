<?php
session_start();

header('Content-Type: application/json');
include_once "../includes/connection.php"; // Ensure your connection.php is correctly configured

// Check if POST data is received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if customer info is provided and not empty
    if (isset($_POST['customer_name']) && isset($_POST['customer_note']) && !empty($_POST['customer_table']) && isset($_POST['username'])) {
        $customerName = $_POST['customer_name'];
        $customerNote = $_POST['customer_note'];
        $customerTable = $_POST['customer_table'];
        $username = $_POST['username'];
        $orderId = isset($_POST['hidden_order_id']) ? $_POST['hidden_order_id'] : null;

        // Check if there is an existing order using the order_id
        if (!empty($orderId)) {
            // Query to check if the order exists in the `orders` table
            $checkOrderSql = "SELECT order_status FROM orders WHERE order_id = ?";
            $checkOrderStmt = $conn->prepare($checkOrderSql);
            $checkOrderStmt->bind_param("i", $orderId);
            $checkOrderStmt->execute();
            $checkOrderResult = $checkOrderStmt->get_result();

            if ($checkOrderResult->num_rows > 0) {
                // Order exists, fetch the current status
                $orderRow = $checkOrderResult->fetch_assoc();
                $currentStatus = $orderRow['order_status'];

                // Check if there are order details in the session
                if (empty($_SESSION['order_details'])) {
                    // No items in the session
                    echo json_encode(['status' => 'error', 'message' => 'No items in order.']);
                    exit;  // Stop further execution
                }

                // Update order status if the current status is 'served'
                $totalAmount = 0;
                foreach ($_SESSION['order_details'] as $order) {
                    $totalAmount += $order['sub_total'];
                }

                $updateOrderStatusSQL = "UPDATE orders SET recent_status = ? WHERE order_id = ?";
                $updateOrderStatusStmt = $conn->prepare($updateOrderStatusSQL);
                $updateOrderStatusStmt->bind_param("si", $currentStatus, $orderId);
                $updateOrderStatusStmt->execute();
                
                // Fetch the current total amount before updating
                $currentTotalSql = "SELECT total_amount FROM orders WHERE order_id = ?";
                $currentTotalStmt = $conn->prepare($currentTotalSql);
                $currentTotalStmt->bind_param("i", $orderId);
                $currentTotalStmt->execute();
                $currentTotalResult = $currentTotalStmt->get_result();
                
                if ($currentTotalResult->num_rows > 0) {
                    $currentTotalRow = $currentTotalResult->fetch_assoc();
                    $currentTotalAmount = $currentTotalRow['total_amount'];
                
                    // Calculate the new total amount
                    $newTotalAmount = $currentTotalAmount + $totalAmount;
                
                    // Update the order
                    $updateOrderSql = "UPDATE orders SET order_status = 'prepare', customer_note = CONCAT(customer_note, '\n', ?), total_amount = ? WHERE order_id = ?";
                    $updateOrderStmt = $conn->prepare($updateOrderSql);
                    $updateOrderStmt->bind_param("sdi", $customerNote, $newTotalAmount, $orderId);
                    $updateOrderStmt->execute();

                    // Update customer's total_amount_spent in customers table for additional order
                    $updateCustomerAmountSql = "UPDATE customers SET total_amount_spent = total_amount_spent + ? WHERE customer_name = ?";
                    $updateCustomerAmountStmt = $conn->prepare($updateCustomerAmountSql);
                    $updateCustomerAmountStmt->bind_param("ds", $totalAmount, $customerName);
                    $updateCustomerAmountStmt->execute();

                } else {
                    // Handle the case where the order ID doesn't exist
                    echo json_encode(['status' => 'error', 'message' => 'Order ID not found.']);
                }
                
                

                // First, add back the stock that was deducted during session
                foreach ($_SESSION['order_details'] as $order) {
                    $menuItemId = $order['menu_item_id'];
                    $quantity = $order['quantity'];

                    // Fetch the required stocks for this menu item
                    $menuStockSql = "SELECT stock_id, quantity_required FROM menu_item_stocks WHERE menu_item_id = ?";
                    $menuStockStmt = $conn->prepare($menuStockSql);
                    $menuStockStmt->bind_param("i", $menuItemId);
                    $menuStockStmt->execute();
                    $menuStockResult = $menuStockStmt->get_result();

                    while ($menuStockRow = $menuStockResult->fetch_assoc()) {
                        $stockId = $menuStockRow['stock_id'];
                        $quantityRequired = $menuStockRow['quantity_required'];

                        // Calculate total quantity previously deducted
                        $totalQuantityRequired = $quantity * $quantityRequired;

                        // Add back the stock that was deducted when the order was added to the session
                        $updateStockSql = "UPDATE stocks SET stock_quantity = stock_quantity + ? WHERE stock_id = ?";
                        $updateStockStmt = $conn->prepare($updateStockSql);
                        $updateStockStmt->bind_param("di", $totalQuantityRequired, $stockId);
                        $updateStockStmt->execute();
                    }
                }

                // Proceed to insert new order details for additional items
                foreach ($_SESSION['order_details'] as $order) {
                    $menuItemId = $order['menu_item_id'];
                    $quantity = $order['quantity'];
                    $menuPrice = $order['menu_price'];
                    $subTotal = $order['sub_total'];

                    // Insert new order details
                    $detailSql = "INSERT INTO order_details (order_id, menu_item_stock_id, quantity, menu_price, sub_total, order_item_status) VALUES (?, ?, ?, ?, ?, 'prepare')";
                    $detailStmt = $conn->prepare($detailSql);
                    $detailStmt->bind_param("iiddd", $orderId, $menuItemId, $quantity, $menuPrice, $subTotal);
                    $detailStmt->execute();

                    // Update the order count in menu_order_count
                    $updateCounterSql = "INSERT INTO menu_order_count (item_id, order_count) VALUES (?, ?) 
                    ON DUPLICATE KEY UPDATE order_count = order_count + ?";
                    $updateCounterStmt = $conn->prepare($updateCounterSql);
                    $updateCounterStmt->bind_param("idd", $menuItemId, $quantity, $quantity);
                    $updateCounterStmt->execute();


                    // Fetch related stock information from menu_item_stocks
                    $menuStockSql = "SELECT stock_id, quantity_required FROM menu_item_stocks WHERE menu_item_id = ?";
                    $menuStockStmt = $conn->prepare($menuStockSql);
                    $menuStockStmt->bind_param("i", $menuItemId);
                    $menuStockStmt->execute();
                    $menuStockResult = $menuStockStmt->get_result();

                    while ($menuStockRow = $menuStockResult->fetch_assoc()) {
                        $stockId = $menuStockRow['stock_id'];
                        $quantityRequired = $menuStockRow['quantity_required'];
                        $totalQuantityRequired = $quantity * $quantityRequired;

                        // Deduct stock quantity from stocks table again
                        $updateStockSql = "UPDATE stocks SET stock_quantity = stock_quantity - ? WHERE stock_id = ?";
                        $updateStockStmt = $conn->prepare($updateStockSql);
                        $updateStockStmt->bind_param("di", $totalQuantityRequired, $stockId);
                        $updateStockStmt->execute();
                    }
                }

                // Clear session order details
                unset($_SESSION['order_details']);
                echo json_encode(['status' => 'success', 'message' => 'Additional order placed successfully.']);
            } else {
                // No order found with the provided order_id
                echo json_encode(['status' => 'error', 'message' => 'Order ID not found.']);
            }
        }else {
            // No order ID provided, proceed with the regular new order logic
            if (isset($_SESSION['order_details']) && !empty($_SESSION['order_details'])) {
                $totalAmount = 0;
                foreach ($_SESSION['order_details'] as $order) {
                    $totalAmount += $order['sub_total'];
                }
        
                // Check if the customer already exists in the `customers` table
                $checkCustomerSql = "SELECT customer_id, total_amount_spent FROM customers WHERE customer_name = ?";
                $checkCustomerStmt = $conn->prepare($checkCustomerSql);
                $checkCustomerStmt->bind_param("s", $customerName);
                $checkCustomerStmt->execute();
                $checkCustomerResult = $checkCustomerStmt->get_result();
        
                if ($checkCustomerResult->num_rows > 0) {
                    // Customer exists, update the total amount spent
                    $customerRow = $checkCustomerResult->fetch_assoc();
                    $customerId = $customerRow['customer_id'];
                    $updatedAmount = $customerRow['total_amount_spent'] + $totalAmount;
        
                    $updateCustomerSql = "UPDATE customers SET total_amount_spent = ? WHERE customer_id = ?";
                    $updateCustomerStmt = $conn->prepare($updateCustomerSql);
                    $updateCustomerStmt->bind_param("di", $updatedAmount, $customerId);
                    $updateCustomerStmt->execute();
                } else {
                    // New customer, insert with initial total amount spent
                    $insertCustomerSql = "INSERT INTO customers (customer_name, total_amount_spent) VALUES (?, ?)";
                    $insertCustomerStmt = $conn->prepare($insertCustomerSql);
                    $insertCustomerStmt->bind_param("sd", $customerName, $totalAmount);
                    $insertCustomerStmt->execute();
                }
        
                // Insert a new order
                $sql = "INSERT INTO orders (username, customer_name, customer_note, customer_table, total_amount, order_status, table_status, payment_status) VALUES (?, ?, ?, ?, ?, 'prepare', 1, 'unpaid')";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssd", $username, $customerName, $customerNote, $customerTable, $totalAmount);
                $stmt->execute();
        
                // Get the newly inserted order ID
                $orderId = $conn->insert_id;
        
                // First, add back the stock that was deducted during session
                foreach ($_SESSION['order_details'] as $order) {
                    $menuItemId = $order['menu_item_id'];
                    $quantity = $order['quantity'];
        
                    // Fetch the required stocks for this menu item
                    $menuStockSql = "SELECT stock_id, quantity_required FROM menu_item_stocks WHERE menu_item_id = ?";
                    $menuStockStmt = $conn->prepare($menuStockSql);
                    $menuStockStmt->bind_param("i", $menuItemId);
                    $menuStockStmt->execute();
                    $menuStockResult = $menuStockStmt->get_result();
        
                    while ($menuStockRow = $menuStockResult->fetch_assoc()) {
                        $stockId = $menuStockRow['stock_id'];
                        $quantityRequired = $menuStockRow['quantity_required'];
        
                        // Calculate total quantity previously deducted
                        $totalQuantityRequired = $quantity * $quantityRequired;
        
                        // Add back the stock that was deducted when the order was added to the session
                        $updateStockSql = "UPDATE stocks SET stock_quantity = stock_quantity + ? WHERE stock_id = ?";
                        $updateStockStmt = $conn->prepare($updateStockSql);
                        $updateStockStmt->bind_param("di", $totalQuantityRequired, $stockId);
                        $updateStockStmt->execute();
                    }
                }
        
                // Insert order details and handle stock deduction
                foreach ($_SESSION['order_details'] as $order) {
                    $menuItemId = $order['menu_item_id'];
                    $quantity = $order['quantity'];
                    $menuPrice = $order['menu_price'];
                    $subTotal = $order['sub_total'];
        
                    $detailSql = "INSERT INTO order_details (order_id, menu_item_stock_id, quantity, menu_price, sub_total, order_item_status) VALUES (?, ?, ?, ?, ?, 'prepare')";
                    $detailStmt = $conn->prepare($detailSql);
                    $detailStmt->bind_param("iidds", $orderId, $menuItemId, $quantity, $menuPrice, $subTotal);
                    $detailStmt->execute();
        
                    // Update the order count in menu_order_count
                    $updateCounterSql = "INSERT INTO menu_order_count (item_id, order_count) VALUES (?, ?) 
                    ON DUPLICATE KEY UPDATE order_count = order_count + ?";
                    $updateCounterStmt = $conn->prepare($updateCounterSql);
                    $updateCounterStmt->bind_param("idd", $menuItemId, $quantity, $quantity);
                    $updateCounterStmt->execute();
        
                    // Fetch related stock information from menu_item_stocks
                    $menuStockSql = "SELECT stock_id, quantity_required FROM menu_item_stocks WHERE menu_item_id = ?";
                    $menuStockStmt = $conn->prepare($menuStockSql);
                    $menuStockStmt->bind_param("i", $menuItemId);
                    $menuStockStmt->execute();
                    $menuStockResult = $menuStockStmt->get_result();
        
                    while ($menuStockRow = $menuStockResult->fetch_assoc()) {
                        $stockId = $menuStockRow['stock_id'];
                        $quantityRequired = $menuStockRow['quantity_required'];
                        $totalQuantityRequired = $quantity * $quantityRequired;
        
                        // Deduct stock quantity from stocks table again
                        $updateStockSql = "UPDATE stocks SET stock_quantity = stock_quantity - ? WHERE stock_id = ?";
                        $updateStockStmt = $conn->prepare($updateStockSql);
                        $updateStockStmt->bind_param("di", $totalQuantityRequired, $stockId);
                        $updateStockStmt->execute();
                    }
                }
        
                // Clear session order details
                unset($_SESSION['order_details']);
                echo json_encode(['status' => 'success', 'message' => 'Order placed successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No items in order']);
            }
        }        
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing or empty customer information.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
