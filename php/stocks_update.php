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
            // Start transaction
            $conn->begin_transaction();

            try {
                // 1. Retrieve the previous stock quantity before update
                $sqlGetPrevQuantity = "SELECT stock_quantity FROM stocks WHERE stock_id = ?";
                $stmtGetPrevQuantity = $conn->prepare($sqlGetPrevQuantity);
                $stmtGetPrevQuantity->bind_param("i", $stockID);
                $stmtGetPrevQuantity->execute();
                $result = $stmtGetPrevQuantity->get_result();
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $previousQuantity = $row['stock_quantity']; // Store previous quantity
                } else {
                    throw new Exception("Stock item not found.");
                }

                // 2. Update the stock item (but don't update the date)
                $updateSql = "UPDATE stocks SET stock_name = ?, stock_quantity = ?, stock_unit = ? WHERE stock_id = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("sssi", $formattedName, $stockQuantity, $stockUnit, $stockID);

                if (!$updateStmt->execute()) {
                    throw new Exception("Failed to update stock item.");
                }

                // 3. Insert a new history record in `stock_history`
                $historySql = "INSERT INTO stock_history (stock_id, updated_quantity, previous_quantity, updated_at, last_action_type) 
                               VALUES (?, ?, ?, ?, 'update')";
                $historyStmt = $conn->prepare($historySql);
                $historyStmt->bind_param("iiis", $stockID, $stockQuantity, $previousQuantity, $submissionTime);

                if (!$historyStmt->execute()) {
                    throw new Exception("Failed to insert stock history.");
                }

                // Commit the transaction
                $conn->commit();

                header("Location: ../public/stocks_entry.php?success=Stock item updated and history recorded successfully");
            } catch (Exception $e) {
                // Rollback transaction in case of error
                $conn->rollback();
                $errorMsg = $e->getMessage();
                header("Location: ../public/stocks_entry.php?error=$errorMsg");
            }

            // Close prepared statements
            $updateStmt->close();
            $historyStmt->close();
            $stmtGetPrevQuantity->close();
            
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
