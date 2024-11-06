<?php
include_once "../includes/connection.php";

$searchCustomer = isset($_GET['search_archive']) ? $_GET['search_archive'] : '';

// SQL query to join orders and payments tables and filter by customer name and payment status
$sql = "SELECT o.order_id, o.customer_name, o.total_amount, o.order_date, o.order_time, p.payment_status, p.collectibles 
        FROM orders o 
        JOIN payments p ON o.order_id = p.order_id
        WHERE p.payment_status = 'paid' AND p.collectibles = 'Y'";

// Prepare parameters and types
$params = [];
$types = "";

// Filter by customer name if provided
if (!empty($searchCustomer)) {
    $sql .= " AND o.customer_name LIKE ?";
    $params[] = "%" . $searchCustomer . "%";
    $types = "s";  // Parameter type for bind_param (s = string)
}

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Bind parameters dynamically based on filters
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Check if there are orders
if ($result->num_rows > 0) {
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = [
            'order_id' => $row['order_id'],
            'customer_name' => $row['customer_name'],
            'total_amount' => $row['total_amount'],
            'order_date' => $row['order_date'],
            'order_time' => $row['order_time'],
            'payment_status' => $row['payment_status'],
            'collectibles' => $row['collectibles']
        ];
    }

    echo json_encode(['success' => true, 'orders' => $orders]);
} else {
    echo json_encode(['success' => false, 'orders' => []]);
}

$stmt->close();
$conn->close();
?>

