<?php
include_once "../includes/connection.php";

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    header('Content-Type: application/json');

    // Set stock as active in the database
    $sql = "UPDATE stocks SET stock_status = 'active' WHERE stock_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

       
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Item successfully set as active.']);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Something went wrong!']);
        exit;
    }


    $stmt->close();
    $conn->close();
}
?>
