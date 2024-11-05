<?php
// Connect to your database
include_once "../includes/connection.php";
date_default_timezone_set('Asia/Manila');

// Get start and end dates from URL parameters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;




// Default condition (if no date is provided, display all)
$date_condition = "";
if ($start_date) {
    $date_condition = "AND p.payment_date >= '$start_date'";
    if ($end_date) {
        $date_condition .= " AND p.payment_date <= '$end_date'";
    }
}

// Step 1: Calculate the total sales amount from the payments table
$sql_total_sales = "SELECT SUM(total_amount) AS total_sales FROM payments p WHERE payment_status = 'paid' $date_condition";
$result_total_sales = $conn->query($sql_total_sales);
$total_sales = $result_total_sales->fetch_assoc()['total_sales'] ?? 0;

// Step 2: Count the total number of transactions
$sql_total_transactions = "SELECT COUNT(order_id) AS total_transactions FROM payments p WHERE payment_status = 'paid' $date_condition";
$result_total_transactions = $conn->query($sql_total_transactions);
$total_transactions = $result_total_transactions->fetch_assoc()['total_transactions'] ?? 0;

// Step 3: Calculate the average sales per transaction
$average_sales = $total_transactions > 0 ? $total_sales / $total_transactions : 0;


// Query to fetch order details along with items and customer info
$sql_order_details = "
    SELECT o.order_id, o.order_date, o.customer_name, p.payment_status, p.total_amount, 
           m.item_name, od.quantity, m.item_category
    FROM orders o
    JOIN order_details od ON o.order_id = od.order_id
    JOIN menu_items m ON od.menu_item_stock_id = m.item_id
    JOIN payments p ON o.order_id = p.order_id
    WHERE (p.payment_status = 'paid' or p.payment_status = 'credit') $date_condition
    ORDER BY o.order_date
";
$result_order_details = $conn->query($sql_order_details);

// Store orders in an associative array grouped by order_id to aggregate items for each order
$orders = [];
while ($row = $result_order_details->fetch_assoc()) {
    $order_id = $row['order_id'];
    $quantity = ($row['item_category'] === 'Main Course') ? number_format($row['quantity'], 1) : intval($row['quantity']);
    $item = "{$row['item_name']} ({$quantity})";
    
    if (!isset($orders[$order_id])) {
        $orders[$order_id] = [
            'order_date' => $row['order_date'],
            'customer_name' => $row['customer_name'],
            'items' => [$item],
            'total_amount' => $row['total_amount'],
            'payment_status' => $row['payment_status'],
        ];
    } else {
        $orders[$order_id]['items'][] = $item;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #333; padding: 8px; text-align: center; text-transform: capitalize; }
        .summary, .details, .trends, .top-products, .employee-performance { margin-bottom: 20px; }
        .return-button{
            text-decoration: none;
            color: #333;
        }
        @media print {
            /* Print-specific styles */
            body { margin: 0; }
            .print-button, .return-button{ display: none; }

        }
    </style>
</head>
<body onload="window.print(); window.onafterprint = function() { window.close(); }">
    <a href="../public/sales_report.php" class="return-button">Hey</a>
    <h1 class="header-title">Orders Sales Report</h1>
    <h2>Date Range: <?php echo $start_date ?? 'All'; ?> - <?php echo $end_date ?? 'All'; ?></h2>

    <section class="summary">
        <h3>Summary</h3>
        <table>
            <tr><th>Total Sales</th><th>Total Transactions</th><th>Average Sale per Transaction</th></tr>
            <tr><td>₱<?php echo number_format($total_sales, 2); ?></td><td><?php echo $total_transactions; ?></td><td>₱<?php echo number_format($average_sales, 2); ?></td></tr>
        </table>
    </section>

    <section class="details">
        <h3>Order Details</h3>
        <table>
            <tr><th>Date</th><th>Customer Name</th><th>Items Sold</th><th>Total Amount</th><th>Payment Status</th></tr>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo date("m/d/Y", strtotime($order['order_date'])); ?></td>
                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                <td><?php echo implode(", ", $order['items']); ?></td>
                <td>₱<?php echo number_format($order['total_amount'], 2); ?></td>
                <td><?php echo htmlspecialchars($order['payment_status']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>


    <?php $conn->close(); ?>
</body>
</html>
