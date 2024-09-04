<?php
ob_start();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['item_name']) && isset($_POST['item_price']) && isset($_POST['item_categories']) && isset($_POST['stock_id'])) {
        include_once "../includes/connection.php";

        $itemName = $_POST['item_name'];
        $itemPrice = $_POST['item_price'];
        $itemCat = $_POST['item_categories'];
        $stockID = $_POST['stock_id'];

        $data = "item_name=" . $itemName . "&item_price=" . $itemPrice . "&item_categories=" . $itemCat . "&stock_id=" . $stockID;

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
        } else if (empty($stockID)) {
            $errorMsg = "Stock category is required";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        } else if (!isset($_FILES["item_photo"]) || $_FILES["item_photo"]["error"] != UPLOAD_ERR_OK) {
            $errorMsg = "Menu image is required";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        } else {
            // Handle file upload
            $tempName = $_FILES["item_photo"]["tmp_name"];
            $fileName = $_FILES["item_photo"]["name"];
            $filePath = "../uploads/" . $fileName;
            move_uploaded_file($tempName, $filePath);

            // Insert into menu_items table
            $sql = "INSERT INTO menu_items (item_name, item_price, item_category, item_image) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $itemName, $itemPrice, $itemCat, $filePath);
            $stmt->execute();

            // Get the last inserted item_id
            $menuItemId = $stmt->insert_id;
            $stmt->close();

            // Fetch the corresponding stock_id
            $stockSql = "SELECT * FROM stocks WHERE stock_id = ?";
            $stockStmt = $conn->prepare($stockSql);
            $stockStmt->bind_param("s", $stockID);
            $stockStmt->execute();
            $stockResult = $stockStmt->get_result();

            if ($stockResult->num_rows > 0) {
                $stockRow = $stockResult->fetch_assoc();
                $stockId = $stockRow['stock_id'];

                // Insert into menu_item_stocks table with quantity 1
                $quantityRequired = 1;
                $menuStockSql = "INSERT INTO menu_item_stocks (menu_item_id, stock_id, quantity_required) VALUES (?, ?, ?)";
                $menuStockStmt = $conn->prepare($menuStockSql);
                $menuStockStmt->bind_param("iii", $menuItemId, $stockId, $quantityRequired);
                $menuStockStmt->execute();
                $menuStockStmt->close();
            }

            $stockStmt->close();

            header("Location: ../public/menu_entry.php?success=Menu item saved successfully");
            exit;
        }
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

