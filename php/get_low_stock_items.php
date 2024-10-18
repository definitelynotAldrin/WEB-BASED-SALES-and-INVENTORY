<?php
include_once "../includes/connection.php";

$low_stock_threshold = 10; // Define your low stock threshold here

// Modified SQL to fetch stock_unit along with stock_name and stock_quantity
$sql = "SELECT stock_name, stock_quantity, stock_unit FROM stocks WHERE stock_quantity < ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $low_stock_threshold);
$stmt->execute();
$result = $stmt->get_result();

$low_stock_items = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Check the stock unit and format accordingly
        $formatted_quantity = $row['stock_unit'] == 'Pieces' 
            ? intval($row['stock_quantity'])  // No decimals for 'Pieces'
            : number_format($row['stock_quantity'], 2);  // 2 decimal places for 'KG'

        $low_stock_items[] = [
            'stock_name' => $row['stock_name'],
            'stock_quantity' => $formatted_quantity,
            'stock_unit' => $row['stock_unit']
        ];
    }
}

echo json_encode($low_stock_items);
