<?php

header('Content-Type: application/json');
include_once "../includes/connection.php";

// Query to get the occupied tables
$sql = "SELECT customer_table FROM orders WHERE table_status = 1"; // Get occupied tables
$result = $conn->query($sql);

$occupied_tables = array(); // Initialize an array to store the occupied table numbers
while ($row = $result->fetch_assoc()) {
    $occupied_tables[] = $row['customer_table']; // Store customer_table in the array
}

// Return the occupied tables as a JSON response
echo json_encode(array('occupied_tables' => $occupied_tables));
