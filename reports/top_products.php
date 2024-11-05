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



// Query to fetch top products
$sql_top_products = "
    SELECT mi.item_name, 
           SUM(od.quantity) AS quantity_sold, 
           SUM(od.sub_total) AS total_sales
    FROM order_details od
    JOIN menu_items mi ON od.menu_item_stock_id = mi.item_id
    WHERE od.created_at >= '$start_date' AND od.created_at <= '$end_date'
    GROUP BY mi.item_name";
$result_top_products = $conn->query($sql_top_products);

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
    <h1 class="header-title">Top Product Sales Report</h1>
    <h2>Date Range: <?php echo $start_date ?? 'All'; ?> - <?php echo $end_date ?? 'All'; ?></h2>


    <section class="top-products">
        <h3>Top Products</h3>
        <table>
            <tr><th>Product</th><th>Quantity Sold</th><th>Total Sales</th></tr>
            <?php while ($row = $result_top_products->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                <td><?php echo $row['quantity_sold']; ?></td>
                <td>₱<?php echo number_format($row['total_sales'], 2); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>


    <?php $conn->close(); ?>
</body>
</html>
