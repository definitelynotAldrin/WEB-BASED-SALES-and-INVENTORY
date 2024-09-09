<?php
include_once "../includes/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['stock_id'])) {
        $stockID = $_POST['stock_id'];

        // Query to delete the stock entry from menu_item_stocks
        $deleteQuery = "DELETE FROM menu_item_stocks WHERE stock_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $stockID);

        if ($stmt->execute()) {
            echo "Stock deleted successfully.";
        } else {
            echo "Error deleting stock: " . $conn->error;
        }
        $stmt->close();
    }
} else {
    echo "Invalid request.";
}
?>
