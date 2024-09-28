<?php
include_once '../includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_id = $_POST['menu_id']; // Adjusted to match JS key
    $menu_name = $_POST['menu_name']; // Adjusted to match JS key
    $quantity = $_POST['quantity'];
    $menu_price = $_POST['menu_price']; // Adjusted to match JS key

    // Calculate sub_total
    $sub_total = $quantity * $menu_price;

    // Insert order detail into the database
    $sql = "INSERT INTO order_details (menu_id, menu_name, quantity, menu_price, sub_total) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isdds", $menu_id, $menu_name, $quantity, $menu_price, $sub_total);

    if ($stmt->execute()) {
        $order_detail_id = $stmt->insert_id;

        // Return the inserted data as a response
        echo json_encode([
            'success' => true,
            'order_detail' => [
                'order_detail_id' => $order_detail_id,
                'menu_name' => $menu_name,
                'quantity' => $quantity,
                'sub_total' => $sub_total
            ]
        ]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false]);
}
?>
