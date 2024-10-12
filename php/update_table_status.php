<?php

header('Content-Type: application/json');
include_once "../includes/connection.php";

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $table_id = intval($_POST['table_id']);
    $status = intval($_POST['status']);

    // Update the table status in the database using both order_id and table_id
    $sql = "UPDATE orders SET table_status = ? WHERE order_id = ? AND customer_table = ? AND DATE(order_date) = CURDATE()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii', $status, $order_id, $table_id);
    $stmt->execute();

    // Return success response
    echo json_encode(['status' => 'success']);
} else {
    // Return error if request method is invalid
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

