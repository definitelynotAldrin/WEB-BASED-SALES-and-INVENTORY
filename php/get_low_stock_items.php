<?php
include_once "../includes/connection.php";

$low_stock_threshold = 10; // Define your low stock threshold here

$sql = "SELECT stock_name, stock_quantity FROM stocks WHERE stock_quantity < ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $low_stock_threshold);
$stmt->execute();
$result = $stmt->get_result();

$low_stock_items = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $low_stock_items[] = [
            'stock_name' => $row['stock_name'],
            'stock_quantity' => $row['stock_quantity']
        ];
    }
}

echo json_encode($low_stock_items);

