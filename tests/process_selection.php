<?php
if (isset($_POST['submit'])) {
    // Get the menu item details from the form
    $menu_name = $_POST['menu_name'];
    $price = $_POST['price'];
    $stocks = $_POST['stocks'];  // Array of selected stock IDs
    $quantities = $_POST['quantities'];  // Array of quantities for each selected stock

    // Connect to the database
    include_once "test_connection.php";

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the new menu item into the menu_item table
    $query = "INSERT INTO menu_item (name, price) VALUES ('$menu_name', '$price')";
    if ($conn->query($query) === TRUE) {
        $menu_item_id = $conn->insert_id;  // Get the last inserted menu item ID

        // Loop through each selected stock and insert into menu_item_stocks table
        foreach ($stocks as $index => $stock_id) {
            $quantity_required = $quantities[$index];  // Get the quantity for this stock
            // Insert into menu_item_stocks table with the specified quantity
            $stock_query = "INSERT INTO menu_item_stocks (menu_item_id, stock_id, quantity_required) VALUES ('$menu_item_id', '$stock_id', '$quantity_required')";
            $conn->query($stock_query);
        }

        echo "Menu item added successfully with its associated stocks.";
    } else {
        echo "Error: " . $conn->error;
    }

    // Close connection
    $conn->close();
}

// include_once "test_connection.php";

