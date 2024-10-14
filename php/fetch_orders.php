<?php
include_once "../includes/connection.php"; // Include your connection file
header('Content-Type: application/json');

// Get the current date
$current_date = date('Y-m-d');

// Fetch unpaid orders for the current date
$query = "SELECT * FROM orders WHERE table_status = 1 AND payment_status = 'Unpaid' AND DATE(order_date) = '$current_date'";
$result = mysqli_query($conn, $query);

// Check if any unpaid orders exist
if (mysqli_num_rows($result) > 0) {
    $orders = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = [
            'order_id' => $row['order_id'],
            'customer_name' => $row['customer_name'],
            'customer_table' => $row['customer_table']
        ];
    }

    // Return the data as a JSON response
    echo json_encode([
        'status' => 'success',
        'orders' => $orders
    ]);
} else {
    // No unpaid orders found
    echo json_encode([
        'status' => 'error',
        'message' => 'No unpaid orders found.'
    ]);
}
