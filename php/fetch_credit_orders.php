<?php
include_once "../includes/connection.php";

$searchCustomer = isset($_GET['search_customer']) ? $_GET['search_customer'] : '';

// SQL query to search only by customer name and filter by credit payment status
$sql = "SELECT * FROM orders WHERE payment_status = 'credit'";

// Prepare parameters and types
$params = [];
$types = "";

// Filter by customer name if provided
if (!empty($searchCustomer)) {
    $sql .= " AND customer_name LIKE ?";
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
            'total_amount' => $row['total_amount']
        ];
    }

    echo json_encode(['success' => true, 'orders' => $orders]);
} else {
    echo json_encode(['success' => false, 'orders' => []]);
}

$stmt->close();
$conn->close();
?>
