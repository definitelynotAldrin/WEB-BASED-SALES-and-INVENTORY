<?php
include_once '../includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_id = $_POST['menu_id']; // Adjusted to match JS key
    $menu_name = $_POST['menu_name']; // Adjusted to match JS key
    $quantity = $_POST['quantity'];
    $menu_price = $_POST['menu_price']; // Adjusted to match JS key
    $customer_id = $_POST['customer'];
    $name = $_POST['customer_name'];

    if($customer_id != 0){

        // Calculate sub_total
    $sub_total = $quantity * $menu_price;
    $stat = 1;
    // Insert order detail into the database
    $sql = "INSERT INTO order_details (menu_id, menu_name, quantity, customer_name, customer_id, menu_price, sub_total, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isdsidsi", $menu_id, $menu_name, $quantity, $name, $customer_id, $menu_price, $sub_total, $stat);

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

    }else{

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

    }
} else {
    echo json_encode(['success' => false]);
}
?>


<?php
// Include the connection file
include_once "../includes/connection.php";

// Start session at the beginning of your file
session_start();

// Add item to order details in session
$menu_item_id = $_POST['menu_item_id'];
$quantity = $_POST['quantity'];
$item_price = $_POST['item_price'];
$sub_total = $quantity * $item_price;

// Create an array for the order details if it doesn't exist
if (!isset($_SESSION['order_details'])) {
    $_SESSION['order_details'] = array();
}

// Add the item to the session array
$_SESSION['order_details'][] = array(
    'menu_item_id' => $menu_item_id,
    'quantity' => $quantity,
    'item_price' => $item_price,
    'sub_total' => $sub_total
);

echo "Item added to order summary!";

?>
