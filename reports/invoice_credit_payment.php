<?php
// Connect to your database
include_once "../includes/connection.php";

date_default_timezone_set('Asia/Manila');

// Get the array of order IDs from the URL (for multiple selected orders)
$order_ids = isset($_GET['order_ids']) ? explode(',', $_GET['order_ids']) : [];

// Check if there are order IDs selected, else show an error
if (empty($order_ids)) {
    die("No orders selected.");
}

// Prepare the query to fetch customer and order details based on multiple order IDs
$order_placeholders = implode(',', array_fill(0, count($order_ids), '?'));
$sql = "
    SELECT SUM(total_amount) AS total_amount
    FROM orders
    WHERE order_id IN ($order_placeholders)
";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat("i", count($order_ids)), ...$order_ids);
$stmt->execute();
$order_details = $stmt->get_result()->fetch_assoc();

// Fetch any common customer name if needed
$sql_customer = "
    SELECT customer_name
    FROM orders
    WHERE order_id IN ($order_placeholders)
    LIMIT 1
";
$stmt_customer = $conn->prepare($sql_customer);
$stmt_customer->bind_param(str_repeat("i", count($order_ids)), ...$order_ids);
$stmt_customer->execute();
$customer_details = $stmt_customer->get_result()->fetch_assoc();

// Prepare the query to fetch ordered items for all selected orders
$sql_items = "
    SELECT 
        menu_items.item_name,
        SUM(order_details.quantity) as quantity,
        SUM(order_details.sub_total) as sub_total
    FROM 
        order_details
    JOIN 
        menu_items 
    ON 
        order_details.menu_item_stock_id = menu_items.item_id
    WHERE 
        order_details.order_id IN ($order_placeholders)
    GROUP BY 
        menu_items.item_name
";
$stmt_items = $conn->prepare($sql_items);
$stmt_items->bind_param(str_repeat("i", count($order_ids)), ...$order_ids);
$stmt_items->execute();
$order_items = $stmt_items->get_result();

// Payment details, fetching the latest payment for one of the selected orders
$sql_payment = "SELECT discounted_amount, cash_tendered, change_due, payment_status FROM payments WHERE order_id = ? ORDER BY payment_date DESC LIMIT 1";
$stmt_payment = $conn->prepare($sql_payment);
$stmt_payment->bind_param("i", $order_ids[0]); // Only need one order ID for payment info
$stmt_payment->execute();
$payment_details = $stmt_payment->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice Receipt</title>
    <style>
        /* Styles for a 3" or 4" wide receipt */
        body { font-family: Arial, sans-serif; width: 250px; margin: 0 auto; }
        h2, p { text-align: center; margin: 5px 0; text-transform: capitalize; }
        .receipt { border-top: 1px dashed #333; padding: 10px 0; }
        .header, .footer { text-align: center; }
        .content { margin-top: 10px; }
        .item-list { width: 100%; }
        .item-list th, .item-list td { text-align: left; padding: 4px; }
        .item-list th { font-weight: bold; }
        .summary { margin-top: 10px; }
        .summary td { padding: 4px; text-align: right; text-transform: capitalize; }
        .thank-you { margin-top: 15px; text-align: center; font-size: 0.9em; }
        .return-button{
            text-decoration: none;
            color: #333;
            position: absolute;
            top: 15px;
            left: 15px;
        }

        @media print {
            body { margin: 0; }
            .return-button{
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print(); window.onafterprint = function() { window.close(); }">
<a href="../public/settlement_panel.php" class="return-button">Return</a>
    <div class="header">
        <h2>Kan-anan by the Sea</h2>
        <p>Talisayan Mis Or</p>
        <p>Phone: (123) 456-7890</p>
    </div>

    <div class="receipt">
        <p><strong>Date:</strong> <?php echo date('Y-m-d'); ?></p>
        <p><strong>Time:</strong> <?php echo date("h:i:s a"); ?></p>
        <p><strong>Order IDs:</strong> <?php echo implode(", ", $order_ids); ?></p>
        <p><strong>Customer:</strong> <?php echo htmlspecialchars($customer_details['customer_name']); ?></p>
    </div>

    <div class="content">
        <table class="item-list">
            <tr><th>Item</th><th>Qty</th><th>Subtotal</th></tr>
            <?php while ($item = $order_items->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>&#x20B1;<?php echo number_format($item['sub_total'], 2); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <table class="summary" width="100%">
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>₱<?php echo number_format($order_details['total_amount'], 2); ?></strong></td>
            </tr>
            <tr>
                <td><strong>Cash Tendered</strong></td>
                <td>₱<?php echo number_format($payment_details['cash_tendered'], 2); ?></td>
            </tr>
            <tr>
                <td><strong>Change</strong></td>
                <td>₱<?php echo number_format($payment_details['change_due'], 2); ?></td>
            </tr>
            <tr>
                <td><strong>Amount Paid</strong></td>
                <td><strong>₱<?php echo number_format($payment_details['discounted_amount'] > 0 ? $payment_details['discounted_amount'] : $order_details['total_amount'], 2); ?></strong></td>
            </tr>
            <tr>
                <td><strong>Payment Status</strong></td>
                <td><?php echo htmlspecialchars($payment_details['payment_status']); ?></td>
            </tr>
        </table>
    </div>

    <br>
    <div class="footer">
        <p>Thank you for dining with us!</p>
        <p>Have a great day!</p>
    </div>
</body>
</html>
