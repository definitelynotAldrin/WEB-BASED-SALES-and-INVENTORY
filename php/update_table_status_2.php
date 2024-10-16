<?php
include_once "../includes/connection.php"; // Adjust the path based on your setup

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_id']) && isset($_POST['table_status'])) {
        $orderId = $_POST['order_id'];
        $tableStatus = $_POST['table_status'];

        // Prepare the SQL query to update the table status
        $sql = "UPDATE orders SET table_status = ? WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $tableStatus, $orderId);

        if ($stmt->execute()) {
            // Respond with success message
            echo json_encode(['status' => 'success', 'message' => 'Table status updated successfully']);
        } else {
            // Respond with an error message
            echo json_encode(['status' => 'error', 'message' => 'Failed to update table status']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data received']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
$conn->close();
?>
