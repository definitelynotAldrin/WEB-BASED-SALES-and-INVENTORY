<?php
ob_start();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['item_id'], $_POST['item_name'], $_POST['item_price'], $_POST['item_categories'], $_POST['stock_id'])) {
        include_once "../includes/connection.php";

        $itemId = intval($_POST['item_id']); // ID of the menu item to be updated
        $itemName = trim($_POST['item_name']);
        $itemPrice = floatval($_POST['item_price']);
        $itemCat = $_POST['item_categories'];
        $stockId = intval($_POST['stock_id']);

        // Build query string for redirect URL
        $data = "item_id=" . $itemId . "&item_name=" . urlencode($itemName) . "&item_price=" . urlencode($itemPrice) . "&item_categories=" . urlencode($itemCat) . "&stock_id=" . urlencode($stockId);

        // Input validation
        if (empty($itemName)) {
            $errorMsg = "Menu name is required";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        } else if ($itemPrice <= 0) {
            $errorMsg = "Menu price is required and must be greater than zero";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        } else if (empty($itemCat)) {
            $errorMsg = "Menu category is required";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        } else if ($stockId <= 0) {
            $errorMsg = "Stock category is required";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        }

        // Check if a new file was uploaded
        if (isset($_FILES["item_photo"]) && $_FILES["item_photo"]["error"] == UPLOAD_ERR_OK) {
            // Validate file type (e.g., image/jpeg, image/png)
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES["item_photo"]["type"], $allowedTypes)) {
                $tempName = $_FILES["item_photo"]["tmp_name"];
                $fileName = basename($_FILES["item_photo"]["name"]);
                $filePath = "../uploads/" . $fileName;
                move_uploaded_file($tempName, $filePath);

                // Update the menu item with the new image
                $sql = "UPDATE menu_items SET item_name = ?, item_price = ?, item_category = ?, item_image = ? WHERE item_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssi", $itemName, $itemPrice, $itemCat, $fileName, $itemId);
            } else {
                $errorMsg = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
                header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
                exit;
            }
        } else {
            // Update the menu item without changing the image
            $sql = "UPDATE menu_items SET item_name = ?, item_price = ?, item_category = ? WHERE item_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $itemName, $itemPrice, $itemCat, $itemId);
        }

        if ($stmt->execute()) {
            $stmt->close();

            // Update or insert into menu_item_stocks table
            $menuStockSql = "INSERT INTO menu_item_stocks (menu_item_id, stock_id, quantity_required) 
                             VALUES (?, ?, ?) 
                             ON DUPLICATE KEY UPDATE quantity_required = VALUES(quantity_required)";
            $menuStockStmt = $conn->prepare($menuStockSql);
            $quantityRequired = 1; // Update or set as needed
            $menuStockStmt->bind_param("iii", $itemId, $stockId, $quantityRequired);

            if ($menuStockStmt->execute()) {
                header("Location: ../public/menu_entry.php?success=Menu item updated successfully");
            } else {
                $errorMsg = "Failed to update stock information.";
                header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            }

            $menuStockStmt->close();
        } else {
            $errorMsg = "Failed to update menu item.";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
        }

    } else {
        $errorMsg = "All fields are required";
        header("Location: ../public/menu_entry.php?error=$errorMsg");
    }
} else {
    header("Location: ../public/menu_entry.php");
}

ob_end_flush();
?>
