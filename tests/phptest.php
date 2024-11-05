<?php
// Connect to your database
include_once "../includes/connection.php";

// Step 1: Calculate the total sales amount from the payments table
$sql_total_sales = "SELECT SUM(total_amount) AS total_sales FROM payments WHERE payment_status = 'paid'";
$result_total_sales = $conn->query($sql_total_sales);
$total_sales = $result_total_sales->fetch_assoc()['total_sales'];

// Step 2: Count the total number of transactions
$sql_total_transactions = "SELECT COUNT(order_id) AS total_transactions FROM payments WHERE payment_status = 'paid'";
$result_total_transactions = $conn->query($sql_total_transactions);
$total_transactions = $result_total_transactions->fetch_assoc()['total_transactions'];

// Step 3: Calculate the average sales per transaction
if ($total_transactions > 0) {
    $average_sales = $total_sales / $total_transactions;
} else {
    $average_sales = 0; // Prevent division by zero
}

// Display the average sales per transaction
echo "Average Sales per Transaction: ₱" . number_format($average_sales, 2);

?>