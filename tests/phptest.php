<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
     include_once "../includes/connection.php";
     
        $sql = "SELECT mi.item_id, mi.item_name, mi.item_category, s.stock_quantity, mis.quantity_required
        FROM menu_items mi
        JOIN menu_item_stocks mis ON mi.item_id = mis.menu_item_id
        JOIN stocks s ON mis.stock_id = s.stock_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $stock_quantity = $row['stock_quantity'];
        $quantity_required = $row['quantity_required'];
        $low_stock_threshold = 10; // Define your low stock threshold here

        // Check if stock is low
        if ($stock_quantity < $low_stock_threshold) {
            $low_stock_indicator = "Low Stock: " . $stock_quantity . " left";
        } else {
            $low_stock_indicator = "In Stock";
        }

        // Display the menu item with the stock indicator
        echo "<div class='menu-item'>";
        echo "<h3>" . $row['item_name'] . "</h3>";
        echo "<p>Stock Status: " . $low_stock_indicator . "</p>";
        echo "</div>";
    }
} else {
    echo "No items found.";
}

    ?>
</body>
</html>