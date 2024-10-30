<?php

include_once "../includes/connection.php";

date_default_timezone_set('Asia/Manila');
// Get today's date
$today = date('Y-m-d');

// Query to get today's orders and their table status
$sql = "SELECT order_id, customer_table, table_status, customer_name FROM orders WHERE DATE(order_date) = '$today'";
$result = $conn->query($sql);

$orders = array();
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

// Return data as JSON
echo json_encode($orders);

