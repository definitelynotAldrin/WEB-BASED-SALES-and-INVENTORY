<?php
include_once "../includes/connection.php";

// Fetch all customers ordered by total amount spent, descending
$sql = "SELECT customer_name, total_amount_spent FROM customers ORDER BY total_amount_spent DESC LIMIT 10";
$result = $conn->query($sql);

$customers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customers[] = [
            'customer_name' => $row['customer_name'],
            'total_amount_spent' => number_format($row['total_amount_spent'], 2)
        ];
    }
} else {
    $customers[] = [
        'customer_name' => "No customers found",
        'total_amount_spent' => "0.00"
    ];
}

// Output the data as JSON
echo json_encode($customers);
?>
