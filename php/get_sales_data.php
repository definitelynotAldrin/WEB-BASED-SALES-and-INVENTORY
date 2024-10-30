<?php
// Database connection
include_once "../includes/connection.php";

$timeframe = isset($_GET['timeframe']) ? $_GET['timeframe'] : 'overall';
$totalSales = 0.00;

if ($timeframe == 'overall') {
    $sql = "SELECT SUM(total_amount) AS total_sales FROM orders WHERE payment_status = 'paid'";
} elseif ($timeframe == 'monthly') {
    $sql = "SELECT SUM(total_amount) AS total_sales FROM orders WHERE payment_status = 'paid' AND MONTH(order_date) = MONTH(CURRENT_DATE()) AND YEAR(order_date) = YEAR(CURRENT_DATE())";
} elseif ($timeframe == 'weekly') {
    $sql = "SELECT SUM(total_amount) AS total_sales FROM orders WHERE payment_status = 'paid' AND YEARWEEK(order_date, 1) = YEARWEEK(CURRENT_DATE(), 1)";
}

// Execute the query
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $totalSales = $row['total_sales'] ? number_format($row['total_sales'], 2) : '0.00'; // Format the total sales
}

// Return the result as JSON
echo json_encode(['total_sales' => $totalSales]);
?>
