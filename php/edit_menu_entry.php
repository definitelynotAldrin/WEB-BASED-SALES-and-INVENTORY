<?php
ob_start();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['item_id']) && isset($_POST['item_name']) && isset($_POST['item_price']) && isset($_POST['item_categories']) && isset($_POST['stock_categories'])) {
        include_once "../includes/connection.php";

        $itemId = intval($_POST['item_id']); // ID of the menu item to be updated
        $itemName = $_POST['item_name'];
        $itemPrice = $_POST['item_price'];
        $itemCat = $_POST['item_categories'];
        $stockName = $_POST['stock_categories'];

        // Build query string for redirect URL
        $data = "item_id=" . $itemId . "&item_name=" . urlencode($itemName) . "&item_price=" . urlencode($itemPrice) . "&item_categories=" . urlencode($itemCat) . "&stock_categories=" . urlencode($stockName);

        if (empty($itemName)) {
            $errorMsg = "Menu name is required";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        } else if (empty($itemPrice)) {
            $errorMsg = "Menu price is required";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        } else if (empty($itemCat)) {
            $errorMsg = "Menu category is required";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        } else if (empty($stockName)) {
            $errorMsg = "Stock category is required";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        }

        // Check if a new file was uploaded
        if (isset($_FILES["item_photo"]) && $_FILES["item_photo"]["error"] == UPLOAD_ERR_OK) {
            // Handle file upload
            $tempName = $_FILES["item_photo"]["tmp_name"];
            $fileName = $_FILES["item_photo"]["name"];
            $filePath = "../uploads/" . $fileName;
            move_uploaded_file($tempName, $filePath);

            // Update the menu item with the new image
            $sql = "UPDATE menu_items SET item_name = ?, item_price = ?, item_category = ?, item_image = ? WHERE item_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $itemName, $itemPrice, $itemCat, $filePath, $itemId);
        } else {
            // Update the menu item without changing the image
            $sql = "UPDATE menu_items SET item_name = ?, item_price = ?, item_category = ? WHERE item_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $itemName, $itemPrice, $itemCat, $itemId);
        }
        
        $stmt->execute();
        $stmt->close();

        // Fetch the corresponding stock_id
        $stockSql = "SELECT stock_id FROM stocks WHERE stock_name = ?";
        $stockStmt = $conn->prepare($stockSql);
        $stockStmt->bind_param("s", $stockName);
        $stockStmt->execute();
        $stockResult = $stockStmt->get_result();

        if ($stockResult->num_rows > 0) {
            $stockRow = $stockResult->fetch_assoc();
            $stockId = $stockRow['stock_id'];

            // Update or insert into menu_item_stocks table
            $menuStockSql = "INSERT INTO menu_item_stocks (menu_item_id, stock_id, quantity_required) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity_required = VALUES(quantity_required)";
            $menuStockStmt = $conn->prepare($menuStockSql);
            $quantityRequired = 1; // Update or set as needed
            $menuStockStmt->bind_param("iii", $itemId, $stockId, $quantityRequired);
            $menuStockStmt->execute();
            $menuStockStmt->close();
        }

        $stockStmt->close();

        header("Location: ../public/menu_entry.php?success=Menu item updated successfully");
        exit;
    } else {
        $errorMsg = "All fields are required";
        header("Location: ../public/menu_entry.php?error=$errorMsg");
        exit;
    }
} else {
    header("Location: ../public/menu_entry.php");
    exit;
}

ob_end_flush();
