<?php
// Database connection
include_once "../includes/connection.php";
date_default_timezone_set('Asia/Manila');

$timeframe = isset($_GET['timeframe']) ? $_GET['timeframe'] : 'overall';
$totalCollectibles = 0.00;

if ($timeframe == 'overall') {
    $sql = "SELECT SUM(total_amount) AS total_collectibles FROM payments WHERE payment_status = 'credit'";
} elseif ($timeframe == 'monthly') {
    $sql = "SELECT SUM(total_amount) AS total_collectibles FROM payments WHERE payment_status = 'credit' AND MONTH(payment_date) = MONTH(CURRENT_DATE()) AND YEAR(payment_date) = YEAR(CURRENT_DATE())";
} elseif ($timeframe == 'weekly') {
    $sql = "SELECT SUM(total_amount) AS total_collectibles FROM payments WHERE payment_status = 'credit' AND YEARWEEK(payment_date, 1) = YEARWEEK(CURRENT_DATE(), 1)";
}

// Execute the query
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $totalCollectibles = $row['total_collectibles'] ? number_format($row['total_collectibles'], 2) : '0.00'; // Format the total sales
}

// Return the result as JSON
echo json_encode(['total_collectibles' => $totalCollectibles]);
?>
