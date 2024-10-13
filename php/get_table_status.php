<?php

header('Content-Type: application/json');
include_once "../includes/connection.php";

// Get the current date
$current_date = date('Y-m-d');

// Query to get the occupied tables for today only
$sql = "SELECT customer_table 
        FROM orders 
        WHERE table_status = 1 
        AND DATE(order_date) = ?"; // Assuming 'created_at' stores the datetime

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $current_date);
$stmt->execute();
$result = $stmt->get_result();

$occupied_tables = array(); // Initialize an array to store the occupied table numbers

while ($row = $result->fetch_assoc()) {
    $occupied_tables[] = $row['customer_table']; // Store customer_table in the array
}

// Return the occupied tables as a JSON response
echo json_encode(array('occupied_tables' => $occupied_tables));
