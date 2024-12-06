<?php
include_once "../includes/connection.php";
header('Content-Type: application/json');

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    
    // Set stock as inactive in the database
    $sql = "UPDATE stocks SET stock_status = 'inactive' WHERE stock_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Item successfully set as inactive.']);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Something went wrong!']);
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
