<?php
session_start();
include_once "../includes/connection.php";

header('Content-Type: application/json');

// Get stock_id from POST request
$stock_id = isset($_POST['stock_id']) ? $_POST['stock_id'] : null;

if (!$stock_id) {
    echo json_encode(["success" => false, "error" => "Invalid stock ID"]);
    exit;
}

try {
    // Begin transaction to ensure both queries execute together
    $conn->begin_transaction();

    // Delete related records in the child table first
    $deleteChildQuery = "DELETE FROM menu_item_stocks WHERE stock_id = ?";
    $deleteChildStmt = $conn->prepare($deleteChildQuery);

    if (!$deleteChildStmt) {
        throw new Exception("Failed to prepare child table delete query");
    }

    $deleteChildStmt->bind_param("i", $stock_id);
    if (!$deleteChildStmt->execute()) {
        throw new Exception("Failed to delete related records in menu_item_stocks");
    }

    // Delete the main record in the parent table
    $deleteParentQuery = "DELETE FROM stocks WHERE stock_id = ?";
    $deleteParentStmt = $conn->prepare($deleteParentQuery);

    if (!$deleteParentStmt) {
        throw new Exception("Failed to prepare parent table delete query");
    }

    $deleteParentStmt->bind_param("i", $stock_id);
    if (!$deleteParentStmt->execute()) {
        throw new Exception("Failed to delete record in stocks");
    }

    // Commit the transaction
    $conn->commit();

    // Success response
    echo json_encode([
        "success" => true,
        "message" => "Item successfully deleted"
    ]);

    // Close prepared statements
    $deleteChildStmt->close();
    $deleteParentStmt->close();
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();

    // Return error response
    echo json_encode([
        "success" => false,
        "error" => "Error occurred: " . $e->getMessage()
    ]);
}

// Close the database connection
$conn->close();
?>
