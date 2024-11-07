<?php
include_once "../includes/connection.php";

if (isset($_POST['order_id'])) {
    $orderID = $_POST['order_id'];

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Step 1: Fetch the order's total amount and customer information
        $getOrderSql = "SELECT total_amount, customer_name FROM orders WHERE order_id = ?";
        $getOrderStmt = $conn->prepare($getOrderSql);
        $getOrderStmt->bind_param("i", $orderID);
        $getOrderStmt->execute();
        $orderResult = $getOrderStmt->get_result();

        if ($orderResult->num_rows > 0) {
            $orderRow = $orderResult->fetch_assoc();
            $totalAmount = $orderRow['total_amount'];
            $customerName = $orderRow['customer_name'];

            // Step 2: Check if the customer exists in the customers table
            $checkCustomerSql = "SELECT customer_id, total_amount_spent FROM customers WHERE customer_name = ?";
            $checkCustomerStmt = $conn->prepare($checkCustomerSql);
            $checkCustomerStmt->bind_param("s", $customerName);
            $checkCustomerStmt->execute();
            $checkCustomerResult = $checkCustomerStmt->get_result();

            if ($checkCustomerResult->num_rows > 0) {
                $customerRow = $checkCustomerResult->fetch_assoc();
                $customerId = $customerRow['customer_id'];
                $updatedAmount = $customerRow['total_amount_spent'] - $totalAmount;

                // Ensure total_amount_spent doesn't drop below zero
                $updatedAmount = max(0, $updatedAmount);

                // Step 3: Update customer's total_amount_spent
                $updateCustomerSql = "UPDATE customers SET total_amount_spent = ? WHERE customer_id = ?";
                $updateCustomerStmt = $conn->prepare($updateCustomerSql);
                $updateCustomerStmt->bind_param("di", $updatedAmount, $customerId);
                $updateCustomerStmt->execute();
            }

            // Step 4: Perform stock adjustments for the canceled order
            $sql = "SELECT od.quantity, mis.menu_item_id, mis.stock_id, mis.quantity_required 
                    FROM order_details od 
                    JOIN menu_item_stocks mis ON od.menu_item_stock_id = mis.menu_item_id
                    WHERE od.order_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $orderID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Array to hold stock adjustments and order count adjustments
                $stockAdjustments = [];
                $orderCountAdjustments = [];

                // 2. Loop through order details and handle stock adjustments
                while ($row = $result->fetch_assoc()) {
                    $menuItemID = $row['menu_item_id'];
                    $stockID = $row['stock_id'];
                    $quantityOrdered = $row['quantity'];
                    $quantityRequired = $row['quantity_required'];

                    // Calculate the total quantity to return to stock
                    $totalQuantityToReturn = $quantityOrdered * $quantityRequired;

                    // Store stock adjustments (group by stock_id)
                    if (isset($stockAdjustments[$stockID])) {
                        $stockAdjustments[$stockID] += $totalQuantityToReturn;
                    } else {
                        $stockAdjustments[$stockID] = $totalQuantityToReturn;
                    }

                    // Store order count adjustments (decrement quantity for menu items)
                    if (isset($orderCountAdjustments[$menuItemID])) {
                        $orderCountAdjustments[$menuItemID] += $quantityOrdered;
                    } else {
                        $orderCountAdjustments[$menuItemID] = $quantityOrdered;
                    }
                }

                // 3. Update the stock quantities in the stocks table
                foreach ($stockAdjustments as $stockID => $quantityToAdd) {
                    $updateStockSQL = "UPDATE stocks SET stock_quantity = stock_quantity + ? WHERE stock_id = ?";
                    $updateStockStmt = $conn->prepare($updateStockSQL);
                    $updateStockStmt->bind_param("ii", $quantityToAdd, $stockID);
                    $updateStockStmt->execute();
                }

                // Step 5: Decrement the menu_order_count for each item in the canceled order
                foreach ($orderCountAdjustments as $menuItemID => $quantityToDecrement) {
                    $updateCounterSql = "INSERT INTO menu_order_count (item_id, order_count) VALUES (?, ?)
                                         ON DUPLICATE KEY UPDATE order_count = GREATEST(0, order_count - ?)";
                    $updateCounterStmt = $conn->prepare($updateCounterSql);
                    $updateCounterStmt->bind_param("iii", $menuItemID, $quantityToDecrement, $quantityToDecrement);
                    $updateCounterStmt->execute();
                }

                // 6. Delete the order from orders and order_details tables
                $deleteOrderSQL = "DELETE FROM orders WHERE order_id = ?";
                $deleteOrderStmt = $conn->prepare($deleteOrderSQL);
                $deleteOrderStmt->bind_param("i", $orderID);
                $deleteOrderStmt->execute();

                $deleteOrderDetailsSQL = "DELETE FROM order_details WHERE order_id = ?";
                $deleteOrderDetailsStmt = $conn->prepare($deleteOrderDetailsSQL);
                $deleteOrderDetailsStmt->bind_param("i", $orderID);
                $deleteOrderDetailsStmt->execute();

                // Commit the transaction
                $conn->commit();

                // Send success response
                echo json_encode(['success' => true]);
            } else {
                throw new Exception('No order details found for the given order ID.');
            }
        } else {
            throw new Exception('Order not found.');
        }
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
