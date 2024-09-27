<?php
// Connect to your database
include 'db_connect.php'; // Adjust this to your actual connection file

// Read the raw data from the AJAX request
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['customerName'], $data['customerNote'], $data['totalAmount'], $data['orderDetails'])) {
    // Extract the data from the request
    $customerName = $data['customerName'];
    $customerNote = $data['customerNote'];
    $totalAmount = $data['totalAmount'];
    $orderDetails = $data['orderDetails'];

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Insert into the orders table
        $query = "INSERT INTO orders (customer_name, customer_note, total_amount) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssd", $customerName, $customerNote, $totalAmount);
        $stmt->execute();
        
        // Get the generated order_id
        $orderId = $stmt->insert_id;

        // Insert each item into the order_details table
        $detailQuery = "INSERT INTO order_details (order_id, item_name, quantity, subtotal) VALUES (?, ?, ?, ?)";
        $detailStmt = $conn->prepare($detailQuery);

        foreach ($orderDetails as $orderItem) {
            $itemName = $orderItem['itemName'];
            $quantity = $orderItem['quantity'];
            $subtotal = $orderItem['subtotal'];

            $detailStmt->bind_param("isid", $orderId, $itemName, $quantity, $subtotal);
            $detailStmt->execute();
        }

        // Commit the transaction
        $conn->commit();
        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo json_encode(["success" => false, "message" => "Failed to save order"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
