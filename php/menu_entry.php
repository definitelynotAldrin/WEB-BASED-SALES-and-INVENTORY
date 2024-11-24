<?php
ob_start();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include_once "../includes/connection.php";

    $itemName = $_POST['item_name'] ?? '';
    $itemPrice = $_POST['item_price'] ?? '';
    $itemCat = $_POST['item_categories'] ?? '';
    $stockIDs = $_POST['stock_id'] ?? [];
    $stockQuantities = $_POST['quantities'] ?? [];

    $data = "item_name=" . urlencode($itemName) . "&item_price=" . urlencode($itemPrice) . "&item_categories=" . urlencode($itemCat) . "&stock_id=" . urlencode(implode(',', $stockIDs)) . "&quantities=" . urlencode(implode(',', $stockQuantities));

    // Validation checks
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
    } else if (empty($stockIDs) || empty($stockQuantities) || count($stockIDs) !== count($stockQuantities)) {
        $errorMsg = "Stock categories and quantities are required and must match";
        header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
        exit;
    } else if (!isset($_FILES["item_photo"]) || $_FILES["item_photo"]["error"] != UPLOAD_ERR_OK) {
        $errorMsg = "Menu image is required";
        header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
        exit;
    } else {
        // Check if the menu item with the same name and category already exists
        $checkSql = "SELECT * FROM menu_items WHERE item_name = ? AND item_category = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("ss", $itemName, $itemCat);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            $errorMsg = "Menu item already exists!";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        }

        // Proceed with file upload if item doesn't exist
        $tempName = $_FILES["item_photo"]["tmp_name"];
        $fileName = $_FILES["item_photo"]["name"];
        $filePath = "../uploads/" . $fileName;
        move_uploaded_file($tempName, $filePath);

        // Insert into menu_items table
        $sql = "INSERT INTO menu_items (item_name, item_price, item_category, item_image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siss", $itemName, $itemPrice, $itemCat, $filePath);
        $stmt->execute();

        // Get the last inserted item_id
        $menuItemId = $stmt->insert_id;
        $stmt->close();

        // Insert into menu_item_stocks table with quantities
        $menuStockSql = "INSERT INTO menu_item_stocks (menu_item_id, stock_id, quantity_required) VALUES (?, ?, ?)";
        $menuStockStmt = $conn->prepare($menuStockSql);

        foreach ($stockIDs as $index => $stockID) {
            $quantityRequired = $stockQuantities[$index];

            // Insert stock entry for each stock ID and quantity
            $menuStockStmt->bind_param("iid", $menuItemId, $stockID, $quantityRequired);
            $menuStockStmt->execute();
        }

        $menuStockStmt->close();

        header("Location: ../public/menu_entry.php?success=Menu item saved successfully");
        exit;
    }
} else {
    header("Location: ../public/menu_entry.php");
    exit;
}

ob_end_flush();