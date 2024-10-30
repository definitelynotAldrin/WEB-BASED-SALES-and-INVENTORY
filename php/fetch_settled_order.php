<?php
include_once "../includes/connection.php";


date_default_timezone_set('Asia/Manila');
$today = date('Y-m-d');

$sql = "SELECT order_id, customer_table, customer_name, payment_status FROM orders WHERE (payment_status = 'paid' OR payment_status = 'credit') AND order_date = '$today'";
$result = $conn->query($sql);

$orders = array();
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);
?>
