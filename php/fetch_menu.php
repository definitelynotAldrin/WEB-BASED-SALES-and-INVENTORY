<?php
include_once "../includes/connection.php";

// Fetch category and search parameters from the AJAX request
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Base SQL query
$sql = "
    SELECT mi.*,
    GROUP_CONCAT(s.stock_name) AS ingredients, 
    SUM(CASE WHEN s.stock_status = 1 THEN 0 ELSE 1 END) AS inactive_stock_count,  -- Counts inactive stocks
    SUM(CASE WHEN s.stock_quantity = 0 THEN 1 ELSE 0 END) AS low_quantity_count,   -- Counts stocks with quantity = 0
    GROUP_CONCAT(CASE WHEN s.stock_status = 0 THEN 'inactive' ELSE 'active' END) AS stock_statuses,
    GROUP_CONCAT(CASE WHEN s.stock_quantity = 0 THEN 'low' ELSE 'sufficient' END) AS quantity_statuses
FROM menu_items mi
LEFT JOIN menu_item_stocks mis ON mi.item_id = mis.menu_item_id
LEFT JOIN stocks s ON mis.stock_id = s.stock_id
WHERE 1=1"; // Base condition to simplify adding AND clauses

// Filter by category if it's not 'all'
if ($category !== 'all') {
    $sql .= " AND mi.item_category = ?";
}

// Filter by search query if it's not empty
if (!empty($search)) {
    $sql .= " AND mi.item_name LIKE ?";
}

$sql .= " GROUP BY mi.item_id";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters based on the conditions
if ($category !== 'all' && !empty($search)) {
    $searchParam = "%" . $search . "%";
    $stmt->bind_param("ss", $category, $searchParam);
} elseif ($category !== 'all') {
    $stmt->bind_param("s", $category);
} elseif (!empty($search)) {
    $searchParam = "%" . $search . "%";
    $stmt->bind_param("s", $searchParam);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

$menuItems = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Handle potential NULL or empty values for item_category
        $itemCategory = !empty($row['item_category']) ? $row['item_category'] : 'undefined';
    
        // Mark menu item as inactive if any ingredient has low stock or is inactive
        $inactiveClass = ($row['inactive_stock_count'] > 0 || $row['low_quantity_count'] > 0) ? 'inactive-card' : '';
    
        $menuItems[] = [
            'item_id' => $row['item_id'],
            'item_name' => $row['item_name'],
            'item_category' => $itemCategory,  // Use the safe $itemCategory
            'item_price' => $row['item_price'],
            'item_image' => $row['item_image'],
            'inactive_class' => $inactiveClass,
            'ingredients' => $row['ingredients'],
            'stock_statuses' => $row['stock_statuses'],  // Include stock statuses
            'quantity_statuses' => $row['quantity_statuses']  // Include quantity statuses
        ];
    }
}

echo json_encode($menuItems);

