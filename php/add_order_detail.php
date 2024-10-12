<?php
session_start(); // Start session

include_once "../includes/connection.php"; 

// Check if required POST data is received
if (isset($_POST['menu_id']) && isset($_POST['quantity']) && isset($_POST['menu_price']) && isset($_POST['menu_category'])) {
    $menu_id = intval($_POST['menu_id']);
    $menu_name = $_POST['menu_name'];
    $quantity = floatval($_POST['quantity']);
    $menu_price = floatval($_POST['menu_price']);
    $menu_category = $_POST['menu_category'];
    $sub_total = $quantity * $menu_price;

    // Check if the category is 'Beverage' or 'Dessert' and ensure quantity is an integer
    if (($menu_category === 'Beverage' || $menu_category === 'Dessert') && floor($quantity) != $quantity) {
        echo json_encode(array('status' => 'error', 'message' => 'Quantity for beverages and desserts must be a whole number.'));
        exit;
    }

    // Get the stock items associated with the menu item
    $stmt = $conn->prepare("SELECT ms.stock_id, s.stock_name, s.stock_quantity, ms.quantity_required 
                          FROM menu_item_stocks ms
                          JOIN stocks s ON ms.stock_id = s.stock_id 
                          WHERE ms.menu_item_id = ?");
    $stmt->bind_param("i", $menu_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $low_stock_items = array();
    $stock_deductions = array(); // To track stock deductions
    while ($row = $result->fetch_assoc()) {
        $stock_id = $row['stock_id'];
        $stock_name = $row['stock_name'];
        $stock_quantity = $row['stock_quantity'];
        $quantity_required = $row['quantity_required'] * $quantity;

        // Check if stock is low
        if ($stock_quantity < $quantity_required) {
            $low_stock_items[] = $stock_name;
        } else {
            // Store the stock_id and deduction amount for later processing
            $stock_deductions[$stock_id] = $quantity_required;
        }
    }

    if (!empty($low_stock_items)) {
        echo json_encode(array(
            'status' => 'error',
            'message' => 'Insufficient stock for the following items: ' . implode(', ', $low_stock_items)
        ));
        exit; 
    }

    // If sufficient stock, proceed to deduct stock
    foreach ($stock_deductions as $stock_id => $deduction) {
        $update_stmt = $conn->prepare("UPDATE stocks SET stock_quantity = stock_quantity - ? WHERE stock_id = ?");
        $update_stmt->bind_param("di", $deduction, $stock_id);
        $update_stmt->execute();
    }

    // Add the item to the order
    if (!isset($_SESSION['order_details'])) {
        $_SESSION['order_details'] = array();
    }

    $item_exists = false;
    foreach ($_SESSION['order_details'] as &$order_item) {
        if ($order_item['menu_item_id'] == $menu_id) {
            $order_item['quantity'] += $quantity;
            $order_item['sub_total'] = $order_item['quantity'] * $menu_price;
            $item_exists = true;
            break;
        }
    }

    if (!$item_exists) {
        $_SESSION['order_details'][] = array(
            'menu_item_id' => $menu_id,
            'menu_name' => $menu_name,
            'quantity' => $quantity,
            'menu_price' => $menu_price,
            'sub_total' => $sub_total,
            'stock_deductions' => $stock_deductions // Store the deductions for rollback purposes
        );
    }

    echo json_encode(array('status' => 'success', 'message' => 'Item added/updated in order summary.'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid data. Please try again.'));
}
