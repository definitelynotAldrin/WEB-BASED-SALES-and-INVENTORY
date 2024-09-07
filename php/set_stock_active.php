<?php
include_once "../includes/connection.php";

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Set stock as active in the database
    $sql = "UPDATE stocks SET stock_status = 'active' WHERE stock_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>
