<?php
session_start();

include_once "../includes/connection.php";

// Set the response header to JSON
header('Content-Type: application/json');

// Prepare an empty response array
$response = array();

try {
    // Check if order details exist in the session
    if (isset($_SESSION['order_details']) && !empty($_SESSION['order_details'])) {
        // Capture other necessary order information from POST data
        $customerName = $_POST['customer_name'];
        $customerNote = $_POST['customer_note']; // Optional note from the customer
        $customerTable = $_POST['customer_table']; // Table number
        $totalAmount = 0;

        // Calculate total amount from session order details
        foreach ($_SESSION['order_details'] as $order) {
            $totalAmount += $order['sub_total']; // Assuming sub_total is already calculated
        }

        // Prepare to insert into the orders table
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_note, customer_table, total_amount, order_status) VALUES (?, ?, ?, ?, 'prepare')");
        $stmt->execute([$customerName, $customerNote, $customerTable, $totalAmount]);

        // Get the last inserted order ID
        $orderId = $pdo->lastInsertId();

        // Insert order details into the order_details table
        foreach ($_SESSION['order_details'] as $order) {
            $menuItemId = $order['menu_item_id']; // Assuming this is the ID of the menu item
            $quantity = $order['quantity'];
            $menuPrice = $order['menu_price'];
            $subTotal = $order['sub_total'];

            $detailStmt = $pdo->prepare("INSERT INTO order_details (order_id, menu_item_stock_id, quantity, menu_price, sub_total) VALUES (?, ?, ?, ?, ?)");
            $detailStmt->execute([$orderId, $menuItemId, $quantity, $menuPrice, $subTotal]);
        }

        // Clear the session order details after successful insertion
        unset($_SESSION['order_details']);

        // Set the success response
        $response['status'] = 'success';
        $response['message'] = 'Order placed successfully.';
    } else {
        // Handle case where there are no order details
        $response['status'] = 'error';
        $response['message'] = 'No items in the order.';
    }
} catch (Exception $e) {
    // Catch any exceptions (e.g., database errors) and set an error response
    $response['status'] = 'error';
    $response['message'] = 'Failed to place order: ' . $e->getMessage();
}

// Return the response as JSON
echo json_encode($response);
?>
