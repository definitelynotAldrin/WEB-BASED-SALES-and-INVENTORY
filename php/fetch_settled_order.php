<?php
include_once "../includes/connection.php";

$today = date('Y-m-d');

$sql = "SELECT order_id, customer_table, customer_name FROM orders WHERE payment_status = 'paid' AND order_date = '$today'";
$result = $conn->query($sql);

$orders = array();
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);
?>
