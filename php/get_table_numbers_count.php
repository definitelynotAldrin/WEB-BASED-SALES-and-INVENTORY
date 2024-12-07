<?php

include_once "../includes/connection.php";

// Query to count all table numbers
$sql = "SELECT COUNT(*) AS total_count FROM table_numbers";
$result = $conn->query($sql);

$totalTables = 0; // Default to 0 if no data exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalTables = $row['total_count'];
}

// Return total count as JSON
echo json_encode(['table' => $totalTables]);
$conn->close();

?>
