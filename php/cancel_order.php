<?php
include_once "../includes/connection.php";

if (isset($_POST['order_id'])) {
    $orderID = $_POST['order_id'];

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // 1. Fetch all order details for the given order_id
        $sql = "SELECT od.quantity, mis.menu_item_id, mis.stock_id, mis.quantity_required 
                FROM order_details od 
                JOIN menu_item_stocks mis ON od.menu_item_stock_id = mis.menu_item_id
                WHERE od.order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $orderID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Array to hold stock adjustments
            $stockAdjustments = [];

            // 2. Loop through order details and handle stock adjustments
            while ($row = $result->fetch_assoc()) {
                $menuItemID = $row['menu_item_id']; // Use menu_item_id instead of menu_item_stock_id
                $stockID = $row['stock_id']; // The stock item to be updated
                $quantityOrdered = $row['quantity']; // Quantity ordered
                $quantityRequired = $row['quantity_required']; // Quantity required per item in the recipe

                // Calculate the total quantity to return to stock
                $totalQuantityToReturn = $quantityOrdered * $quantityRequired;

                // Store stock adjustments (group by stock_id)
                if (isset($stockAdjustments[$stockID])) {
                    $stockAdjustments[$stockID] += $totalQuantityToReturn;
                } else {
                    $stockAdjustments[$stockID] = $totalQuantityToReturn;
                }
            }

            // 3. Update the stock quantities in the stocks table
            foreach ($stockAdjustments as $stockID => $quantityToAdd) {
                $updateStockSQL = "UPDATE stocks SET stock_quantity = stock_quantity + ? WHERE stock_id = ?";
                $updateStockStmt = $conn->prepare($updateStockSQL);
                $updateStockStmt->bind_param("ii", $quantityToAdd, $stockID);
                $updateStockStmt->execute();
            }

            // 4. Delete the order from orders and order_details tables
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
