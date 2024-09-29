<?php
// Include the connection file
include_once "../includes/connection.php";

// Check if the order_id is provided via POST
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Prepare and execute the delete query
    $sql = "DELETE FROM order_details WHERE order_detail_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Order deleted successfully.";
    } else {
        echo "Failed to delete order.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
