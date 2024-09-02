<?php
ob_start();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['item_name']) && isset($_POST['item_price']) && isset($_POST['item_categories'])) {
        include_once "../includes/connection.php";

        $itemName = $_POST['item_name'];
        $itemPrice = $_POST['item_price'];
        $itemCat = $_POST['item_categories'];

        $data = "item_name=" . $itemName . "&item_price=" . $itemPrice . "&item_categories=" . $itemCat;

        if (empty($itemName) && empty($itemPrice)) {
            $errorMsg = "All fields are required";
            header("Location: ../public/menu_entry.php?error=$errorMsg");
            exit;
        } else if (empty($itemPrice)) {
            $errorMsg = "Menu price is required";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        } else if (empty($itemName)) {
            $errorMsg = "Menu name is required";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        } else if (empty($itemCat)) {
            $errorMsg = "Menu category is required";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        } else if (!isset($_FILES["item_photo"]) || $_FILES["item_photo"]["error"] != UPLOAD_ERR_OK) {
            $errorMsg = "Menu image is required";
            header("Location: ../public/menu_entry.php?error=$errorMsg&$data");
            exit;
        } else {
            $tempName = $_FILES["item_photo"]["tmp_name"];
            $fileName = $_FILES["item_photo"]["name"];
            $filePath = "../uploads/" . $fileName;
            move_uploaded_file($tempName, $filePath);

            $sql = "INSERT INTO menu_items (item_name, item_price, item_category, item_image) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $itemName, $itemPrice, $itemCat, $filePath);
            $stmt->execute();
            $stmt->close();

            header("Location: ../public/menu_entry.php?success=Menu item saved successfully");
            exit;
        }
    } else {
        // If for some reason the fields are not set (shouldn't happen due to form controls)
        $errorMsg = "All fields are required";
        header("Location: ../public/menu_entry.php?error=$errorMsg");
        exit;
    }
} else {
    // If the request method is not POST, redirect to the form
    header("Location: ../public/menu_entry.php");
    exit;
}

ob_end_flush();
