<?php

include_once "../includes/connection.php";
header('Content-Type: application/json');

// Retrieve the posted data
$account_id = isset($_POST['account_id']) ? $_POST['account_id'] : '';

if (empty($account_id)) {
    echo json_encode(['success' => false, 'error' => 'Account ID is required.']);
    exit;
}

try {
    // Begin a transaction for data integrity
    $conn->begin_transaction();

    // Delete from `menu_items_stocks`
    $deleteStocksQuery = "DELETE FROM menu_item_stocks WHERE menu_item_id = ?";
    $stmt = $conn->prepare($deleteStocksQuery);
    if (!$stmt) {
        throw new Exception("Failed to prepare delete query for `menu_items_stocks`: " . $conn->error);
    }
    $stmt->bind_param("i", $account_id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute delete query for `menu_items_stocks`: " . $stmt->error);
    }

    // Delete from `menu_items`
    $deleteMenuQuery = "DELETE FROM menu_items WHERE item_id = ?";
    $stmt = $conn->prepare($deleteMenuQuery);
    if (!$stmt) {
        throw new Exception("Failed to prepare delete query for `menu_items`: " . $conn->error);
    }
    $stmt->bind_param("i", $account_id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute delete query for `menu_items`: " . $stmt->error);
    }

    // Commit the transaction
    $conn->commit();

    // Send a success response
    echo json_encode(['success' => true, 'message' => 'Menu successfully deleted!']);
} catch (Exception $e) {
    // Rollback the transaction in case of error
    $conn->rollback();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    // Close the prepared statement and the connection
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}
?>
