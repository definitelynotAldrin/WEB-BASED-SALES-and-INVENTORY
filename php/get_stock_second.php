<?php
include_once "../includes/connection.php";

if (isset($_GET['stock_id'])) {
    $stockID = $_GET['stock_id'];

    // Prepare and execute the SQL statement
    $sql = "SELECT * FROM stocks WHERE stock_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $stockID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stock = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'stock_id' => $stock['stock_id'],
            'stock_name' => $stock['stock_name'],
            'stock_quantity' => $stock['stock_quantity']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false]);
}
