<?php
// Include the connection file
include_once "../includes/connection.php";

// $customer_id = $_GET['customer_id'];


// $sql = "SELECT * FROM order_details WHERE customer_id = '$customer_id' AND status = 1";
//     $query = $conn->query($sql);

//     $groupedOrders = [];
//     if($query->num_rows >= 1){
        
//         while($row = $query->fetch_assoc()) {
//             echo json_encode(array("customer_name" => $row['customer_name']));
            
//             $menuId = $row['menu_id'];
    
//             // Check if the menu item already exists in the grouped orders
//             if (isset($groupedOrders[$menuId])) {
//                 // If it exists, update the quantity and subtotal
//                 $groupedOrders[$menuId]['quantity'] += $row['quantity'];
//                 $groupedOrders[$menuId]['sub_total'] += $row['sub_total'];
//             } else {
//                 // If it doesn't exist, add it to the grouped orders array
//                 $groupedOrders[$menuId] = [
//                     'menu_name' => $row['menu_name'],
//                     'quantity' => $row['quantity'],
//                     'menu_price' => $row['menu_price'],
//                     'sub_total' => $row['sub_total'],
//                     'order_detail_id' => $row['order_detail_id']
//                 ];
//             }
//         }

       

       

//         // Total amount
//         $totalAmount = 0;

//         // Loop through the grouped orders and display them
//         foreach ($groupedOrders as $order) {
//             echo "<tr>";
//             echo "<td style='display:none;'>" . htmlspecialchars($order['menu_id']) . "</td>";
//             echo "<td>" . htmlspecialchars($order['menu_name']) . "</td>";
//             echo "<td>" . htmlspecialchars($order['quantity']) . "</td>";
//             echo "<td>" . number_format($order['menu_price'], 2) . "</td>";
//             echo "<td>" . number_format($order['sub_total'], 2) . "</td>";
//             echo "<td class='btn-remove' data-id='" . $order['order_detail_id'] . "'>
//                     <i class='fa-regular fa-trash-can'></i>
//                 </td>";
//             echo "</tr>";

//             // Update total amount
//             $totalAmount += $order['sub_total'];
//         }

//         echo '
//             <script>
//                 window.onload = function() {
//                     document.getElementById("customer_name").value = "'.$row["customer_name"].'";
//                     console.log();
//                 };
//             </script>';

        
//     }
//     else{
       
//         // Fetch order details from the database
//         $sql = "SELECT * FROM order_details WHERE customer_id = 0 AND status = 0";
//         $result = $conn->query($sql);

//         // Array to group the menu items by their menu_id
//         $groupedOrders = [];

//         if ($result->num_rows > 0) {
//             // Loop through each row of data
//             while ($row = $result->fetch_assoc()) {
//                 $menuId = $row['menu_id'];

//                 // Check if the menu item already exists in the grouped orders
//                 if (isset($groupedOrders[$menuId])) {
//                     // If it exists, update the quantity and subtotal
//                     $groupedOrders[$menuId]['quantity'] += $row['quantity'];
//                     $groupedOrders[$menuId]['sub_total'] += $row['sub_total'];
//                 } else {
//                     // If it doesn't exist, add it to the grouped orders array
//                     $groupedOrders[$menuId] = [
//                         'menu_name' => $row['menu_name'],
//                         'quantity' => $row['quantity'],
//                         'menu_price' => $row['menu_price'],
//                         'sub_total' => $row['sub_total'],
//                         'order_detail_id' => $row['order_detail_id']
//                     ];
//                 }
//             }

//             // Total amount
//             $totalAmount = 0;

//             // Loop through the grouped orders and display them
//             foreach ($groupedOrders as $order) {
//                 echo "<tr>";
//                 echo "<td style='display:none;'>" . htmlspecialchars($order['menu_id']) . "</td>";
//                 echo "<td>" . htmlspecialchars($order['menu_name']) . "</td>";
//                 echo "<td>" . htmlspecialchars($order['quantity']) . "</td>";
//                 echo "<td>" . number_format($order['menu_price'], 2) . "</td>";
//                 echo "<td>" . number_format($order['sub_total'], 2) . "</td>";
//                 echo "<td class='btn-remove' data-id='" . $order['order_detail_id'] . "'>
//                         <i class='fa-regular fa-trash-can'></i>
//                     </td>";
//                 echo "</tr>";

//                 // Update total amount
//                 $totalAmount += $order['sub_total'];
//             }

//         } else {
//             // If no orders are found, display a message
//             echo "<tr><td colspan='6'>No orders found</td></tr>";
//         }
//     }



// $conn->close();



// Start session at the beginning of your file

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
