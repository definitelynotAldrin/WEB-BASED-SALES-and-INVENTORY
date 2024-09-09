<?php
ob_start();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['item_id'], $_POST['item_name'], $_POST['item_price'], $_POST['item_categories'], $_POST['stock_id'], $_POST['quantities'])) {
        include_once "../includes/connection.php";

        $itemId = intval($_POST['item_id']); // ID of the menu item to be updated
        $itemName = trim($_POST['item_name']);
        $itemPrice = floatval($_POST['item_price']);
        $itemCat = $_POST['item_categories'];
        $stockIds = $_POST['stock_id']; // Array of stock IDs
        $quantities = $_POST['quantities']; // Array of quantities

        // Build query string for redirect URL
        $data = "item_id=" . $itemId . "&item_name=" . urlencode($itemName) . "&item_price=" . urlencode($itemPrice) . "&item_categories=" . urlencode($itemCat);

        // Input validation
        if (empty($itemName)) {
            $errorMsg = "Menu name is required";
            header("Location: ../public/menu_entry_edit.php?error=$errorMsg&$data");
            exit;
        } else if ($itemPrice <= 0) {
            $errorMsg = "Menu price is required and must be greater than zero";
            header("Location: ../public/menu_entry_edit.php?error=$errorMsg&$data");
            exit;
        } else if (empty($itemCat)) {
            $errorMsg = "Menu category is required";
            header("Location: ../public/menu_entry_edit.php?error=$errorMsg&$data");
            exit;
        }

        // Check if menu name and category combination already exists (excluding the current item being updated)
        $checkSql = "SELECT * FROM menu_items WHERE item_name = ? AND item_category = ? AND item_id != ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("ssi", $itemName, $itemCat, $itemId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Menu item with the same name and category already exists
            $errorMsg = "Menu item already exists";
            header("Location: ../public/menu_entry_edit.php?error=$errorMsg&$data");
            exit;
        }
        $checkStmt->close();

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
                header("Location: ../public/menu_entry_edit.php?error=$errorMsg&$data");
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

            // First delete any existing stocks associated with this menu item
            $deleteStocksSql = "DELETE FROM menu_item_stocks WHERE menu_item_id = ?";
            $deleteStocksStmt = $conn->prepare($deleteStocksSql);
            $deleteStocksStmt->bind_param("i", $itemId);
            $deleteStocksStmt->execute();
            $deleteStocksStmt->close();

            // Insert or update the stocks for this menu item
            $menuStockSql = "INSERT INTO menu_item_stocks (menu_item_id, stock_id, quantity_required) 
                             VALUES (?, ?, ?)";
            $menuStockStmt = $conn->prepare($menuStockSql);

            // Loop through the stocks and quantities
            for ($i = 0; $i < count($stockIds); $i++) {
                $stockId = intval($stockIds[$i]);
                $quantityRequired = intval($quantities[$i]);

                if ($stockId > 0 && $quantityRequired >= 0) {
                    $menuStockStmt->bind_param("iid", $menuItemId, $stockID, $quantityRequired);
                    $menuStockStmt->execute();
                } else {
                    $errorMsg = "Invalid stock ID or quantity.";
                    header("Location: ../public/menu_entry_edit.php?error=$errorMsg&$data");
                    exit;
                }
            }

            $menuStockStmt->close();
            header("Location: ../public/menu_entry.php?success=Menu item updated successfully");
        } else {
            $errorMsg = "Failed to update menu item.";
            header("Location: ../public/menu_entry_edit.php?error=$errorMsg&$data");
        }

    } else {
        $errorMsg = "All fields are required";
        header("Location: ../public/menu_entry_edit.php?error=$errorMsg");
    }
} else {
    header("Location: ../public/menu_entry_edit.php");
}

ob_end_flush();
?>
