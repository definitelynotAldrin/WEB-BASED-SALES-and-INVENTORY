<?php
include_once "../includes/connection.php";

$today = date('Y-m-d');

$sql = "SELECT order_id, customer_table, table_status, customer_name FROM orders WHERE order_date = '$today' AND order_status = 'prepare'";
$result = $conn->query($sql);

$orders = array();
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);
?>
