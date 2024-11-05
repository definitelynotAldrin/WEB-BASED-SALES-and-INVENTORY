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


// Query to fetch daily sales totals starting from November
$sql_sales_trends = "
    SELECT DATE(payment_date) AS sale_date, SUM(total_amount) AS daily_sales
    FROM payments p
    WHERE payment_status = 'paid'
    AND payment_date BETWEEN '$start_date' AND '$end_date'
    GROUP BY sale_date
    ORDER BY sale_date ASC
";
$result_sales_trends = $conn->query($sql_sales_trends);
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
    <h1 class="header-title">Sales Report</h1>
    <h2>Date Range: <?php echo $start_date ?? 'All'; ?> - <?php echo $end_date ?? 'All'; ?></h2>

    <section class="sales-trends">
        <h3>Daily Sales</h3>
        <table>
            <tr><th>Date</th><th>Daily Sales</th></tr>
            <?php while ($row = $result_sales_trends->fetch_assoc()): ?>
            <tr>
                <td><?php echo date("m/d/Y", strtotime($row['sale_date'])); ?></td>
                <td>₱<?php echo number_format($row['daily_sales'], 2); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <?php $conn->close(); ?>
</body>
</html>
