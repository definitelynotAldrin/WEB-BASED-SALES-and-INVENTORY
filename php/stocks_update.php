<?php
ob_start();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['item_id'], $_POST['item_name'], $_POST['item_quantity'], $_POST['stock_unit'], $_POST['submission_time'])) {
        include_once "../includes/connection.php";

        $stockID = intval($_POST['item_id']);  // Ensure it's an integer
        $stockName = trim($_POST['item_name']);
        $stockQuantity = trim($_POST['item_quantity']);
        $stockUnit = $_POST['stock_unit'];
        $submissionTime = $_POST['submission_time'];

        // Format the stock name
        $formattedName = ucfirst(strtolower($stockName));

        if (empty($stockName) || empty($stockQuantity) || empty($stockUnit)) {
            // Handle missing fields
            $errorMsg = "All fields are required";
            $data = "item_name=" . urlencode($stockName) . "&item_quantity=" . urlencode($stockQuantity) . "&stock_unit=" . urlencode($stockUnit) . "&submission_time=" . urlencode($submissionTime);
            header("Location: ../public/stocks_entry.php?error=$errorMsg&$data");
            exit;
        } else {
            // Update the stock item
            $sql = "UPDATE stocks SET stock_name = ?, stock_quantity = ?, stock_unit = ?, stock_date_added = ? WHERE stock_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $formattedName, $stockQuantity, $stockUnit, $submissionTime, $stockID);

            if ($stmt->execute()) {
                header("Location: ../public/stocks_entry.php?success=Stock item updated successfully");
            } else {
                $errorMsg = "Failed to update stock item.";
                header("Location: ../public/stocks_entry.php?error=$errorMsg");
            }
            
            $stmt->close();
            exit;
        }
    } else {
        $errorMsg = "Invalid request!";
        header("Location: ../public/stocks_entry.php?error=$errorMsg");
        exit;
    }
} else {
    header("Location: ../public/stocks_entry.php");
    exit;
}

ob_end_flush();
