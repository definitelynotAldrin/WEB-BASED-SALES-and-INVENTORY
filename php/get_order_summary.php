<?php
session_start();

// Check if order details exist in the session
if (isset($_SESSION['order_details']) && !empty($_SESSION['order_details'])) {
    // Loop through the order details and display them
    foreach ($_SESSION['order_details'] as $order) {
        echo "<tr>
                <td>{$order['menu_name']}</td>
                <td>{$order['quantity']}</td>
                <td>&#8369; {$order['menu_price']}</td>
                <td class='sub-total'>&#8369; {$order['sub_total']}</td>
                <td class='btn-remove' data-id='{$order['menu_item_id']}'>
                    <i class='fa-regular fa-trash-can'></i>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No items in the order summary yet.</td></tr>";
}
?>
