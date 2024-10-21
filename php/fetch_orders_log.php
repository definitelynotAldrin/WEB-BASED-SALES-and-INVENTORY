<?php
include_once "../includes/connection.php";

$searchCustomer = isset($_GET['search_customer']) ? $_GET['search_customer'] : '';
$searchDate = isset($_GET['search_date']) ? $_GET['search_date'] : '';

// Get the current date
$currentDate = date('Y-m-d');

// SQL query with optional filters for customer name and search date
$sql = "SELECT * FROM orders WHERE 1=1";

// If no search date is provided, default to the current date
if (empty($searchDate)) {
    $sql .= " AND order_date = ?";
    $params[] = $currentDate;
    $types = "s";  // Parameter type for bind_param (s = string)
} else {
    $sql .= " AND order_date = ?";
    $params[] = $searchDate;
    $types = "s";  // Parameter type for bind_param (s = string)
}

// Filter by customer name if provided
if (!empty($searchCustomer)) {
    $sql .= " AND customer_name LIKE ?";
    $params[] = "%" . $searchCustomer . "%";
    $types .= "s";  // Add another string type for the customer name parameter
}

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Dynamically bind the parameters based on the number of filters
$stmt->bind_param($types, ...$params);

$stmt->execute();
$result = $stmt->get_result();

// Check if there are orders
if ($result->num_rows > 0) {
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = [
            'order_id' => $row['order_id'],
            'customer_name' => $row['customer_name'],
            'order_date' => $row['order_date'],
            'order_time' => $row['order_time']
        ];
    }

    echo json_encode(['success' => true, 'orders' => $orders]);
} else {
    echo json_encode(['success' => false, 'orders' => []]);
}

$stmt->close();
$conn->close();
?>
